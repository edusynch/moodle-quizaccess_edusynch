<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Session class
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quizaccess_edusynch;

use quizaccess_edusynch\config;
use quizaccess_edusynch\network;
use quizaccess_edusynch\student;
use quizaccess_edusynch\user;

use stdClass;


defined('MOODLE_INTERNAL') || die();
/**
 * session class.
 *
 * This class manages the E-Proctoring sessions
 *
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class session {

    /** @var int Maximum sessions per page on list */
    public static $SESSIONS_PER_PAGE       = 20;
    /** @var int Maximum session's events per page on list */
    public static $SESSION_EVENTS_PER_PAGE = 50;
    /** @var array Ignored Edusynch antifraud events (to reduce the server load) */
    public static $SESSION_IGNORED_EVENTS  = ['UI_EVENT'];
    /** @var string Name of the table which sessions are stored */
    public static $SESSION_STORE_TABLE     = 'quizaccess_edusynch_sessions';


    /**
     * Creates an antifraud session with the student logged
     *
     * @param   int     $userid  The moodle user ID 
     * @param   int     $quizid  The moodle Quiz ID 
     * @return  array   Created session details  
     */       
    public static function create($userid, $quizid)
    {       
        global $DB, $USER;
       
        // Is Student enabled?
        try {
            $student_token = student::login($userid);

            $quiz_data = $DB->get_record('quiz', ['id' => $quizid]);
            
            $session_request = network::sendRequest(
                'POST', 
                'student',
                'antifraud/sessions/create',
                [
                    "ip_address" => $USER->lastip,
                    "metadata" => [
                        "userid" => $userid,                    
                        "quizid" => $quizid,                    
                        "courseid" => $quiz_data->course,                    
                    ]
                ],
                [
                    'Authorization' => 'Bearer ' . $student_token,
                ]
            );
            $session_id = $session_request['id'];

            $session_object             = new stdClass;
            $session_object->quiz_id    = $quizid;
            $session_object->session_id = $session_id;
            $DB->insert_record(self::$SESSION_STORE_TABLE, $session_object);
    
            return ['success' => true, 'session_id' => $session_id, 'token' => $student_token];
        } catch (\Exception $e) {
            return ['success' => false, 'session_id' => null, 'token' => null];
        }

    }

    /**
     * Lists the antifraud sessions 
     *
     * @param   int     $page  The page wanted 
     * @return  array   List of sessions  
     */       
    public static function list($page = 1, $quizid = null, $start_date, $end_date, $search = '')
    {
        global $DB;

        try {
            $token = user::login();

            $per_page = $quizid ? 9999 : self::$SESSIONS_PER_PAGE;

            $sessions_request = network::sendRequest(
                'GET', 
                'cms',
                'cms/v1/antifraud_sessions?page='. $page .'&paginates_per=' . $per_page . '&start_date='. $start_date .'&end_date='. $end_date .'&search=' . $search,
                null,
                [
                    'Authorization' => 'Bearer ' . $token,
                ]
            );  

            if($quizid) {
                $sessions_per_quiz = [];
                $records_per_quiz  = $DB->get_records(self::$SESSION_STORE_TABLE, ['quiz_id' => $quizid]);                
                foreach($records_per_quiz as $record) {
                    $sessions_per_quiz[] = $record->session_id;
                }                

                $sessions_request['content']['sessions_per_quiz'] = $sessions_per_quiz;
            }
            
            return $sessions_request['content'];
        } catch (\Exception $e) {
            return false;
        }     
    }

    /**
     * Shows an antifraud session details
     *
     * @param   int     $id  The session ID 
     * @return  array   Session details  
     */       
    public static function show($id)
    {
        try {
            $token = user::login();

            $sessions_request = network::sendRequest(
                'GET', 
                'cms',
                'cms/v1/antifraud_sessions/' . $id ,
                null,
                [
                    'Authorization' => 'Bearer ' . $token,
                ]
            );  
            
            return $sessions_request['content'];
        } catch (\Exception $e) {
            die(get_string('error:unable_session_details', 'quizaccess_edusynch'));
        }     
    }

    /**
     * Updates an antifraud session
     *
     * @param   int     $sessionid  The session ID 
     * @param   array   $params     Params to update 
     * @return  array   Updated session details  
     */       
    public static function update($sessionid, $params)
    {       
        global $DB;
       
        try {
            $user_token = user::login();
            
            $session_request = network::sendRequest(
                'PUT', 
                'cms',
                'cms/v1/antifraud_sessions/' . $sessionid,
                $params,
                [
                    'Authorization' => 'Bearer ' . $user_token,
                ]
            );

            $session = $session_request['content'];
    
            return ['success' => true, 'session' => $session];
        } catch (\Exception $e) {
            return ['success' => false, 'session' => null];
        }

    }            

    /**
     * Lists the antifraud session events
     *
     * @param   int     $session_id  The session ID 
     * @param   int     $page        The page wanted 
     * @return  array   Session events  
     */      
    public static function events($session_id, $page = 1)
    {
        try {
            $token = user::login();

            $events_request = network::sendRequest(
                'GET', 
                'cms',
                'cms/v1/antifraud_sessions/' . $session_id . '/events?except='. implode(',', self::$SESSION_IGNORED_EVENTS) .'&page=' . $page . '&paginates_per=' . self::$SESSION_EVENTS_PER_PAGE,
                null,
                [
                    'Authorization' => 'Bearer ' . $token,
                ]
            );  
            
            return $events_request['content'];
        } catch (\Exception $e) {
            die(get_string('error:unable_session_events', 'quizaccess_edusynch'));
        }     
    }   
    
    /**
     * Sends an event associated to session
     *
     * @param   int     $student_id  The student's ID 
     * @param   int     $session_id  The session's ID 
     * @param   string  $event_type  The event's type 
     * @return  bool    true if events created, false if some error occurrs   
     */      
    public static function create_event_for($student_token, $session_id, $event_type)
    {
        date_default_timezone_set("UTC");

        try {
            $event_body     = [
                'event' => [
                    'type' => $event_type,
                    'date' => date('Y-m-d H:i:s'),
                    'isAntifraud' => true,
                    'antifraudId' => $session_id,
                    'read' => false,
                ] 
            ];

            $events_request = network::sendRequest(
                'POST', 
                'events',
                'events',
                $event_body,
                [
                    'Authorization' => 'Bearer ' . $student_token,
                ]
            );  
            
            return true;
        } catch (\Exception $e) {
            return false;
        }     
    }     

    /**
     * Changes the incident level of an antifraud session
     *
     * @param   int     $sessionid  The session ID 
     * @param   string  $incident   The incident level string 
     * @return  array   Updated session details  
     */       
    public static function change_incident($sessionid, $incident_level)
    {       
        return session::update($sessionid, ['incident_level' => $incident_level]);
    }    

    /**
     * Toggles the reviwed flag
     *
     * @param   int     $sessionid  The session ID 
     * @param   bool    $reviewed   Reviewed flag 
     * @return  array   Updated session details  
     */       
    public static function toggle_revision($sessionid, $reviewed)
    {       
        return session::update($sessionid, ['reviewed' => ($reviewed === 0 ? false : true)]);
    }        

}