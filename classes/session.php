<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

namespace quizaccess_edusyncheproctoring;

use quizaccess_edusyncheproctoring\config;
use quizaccess_edusyncheproctoring\network;
use quizaccess_edusyncheproctoring\student;
use quizaccess_edusyncheproctoring\user;

defined('MOODLE_INTERNAL') || die();
/**
 * session class.
 *
 * This class manages the E-Proctoring sessions
 *
 * @package    quizaccess_edusyncheproctoring
 * @category   quiz
 * @copyright  2022 Edusynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class session {

    /** @var int Maximum sessions per page on list */
    public static $SESSIONS_PER_PAGE       = 20;
    /** @var int Maximum session's events per page on list */
    public static $SESSION_EVENTS_PER_PAGE = 50;
    /** @var array Ignored Edusynch antifraud events (to reduce the server load) */
    public static $SESSION_IGNORED_EVENTS  = ['UI_EVENT'];

    /**
     * Creates an antifraud session with the student logged
     *
     * @param   int     $userid  The moodle user ID 
     * @param   int     $quizid  The moodle Quiz ID 
     * @return  array   Created session details  
     */       
    public static function create($userid, $quizid)
    {       
        global $DB;
       
        // Is Quiz enabled?
        $config      = new config();
        $quizzes     = $config->get_key('quizzes');

        $quizzes = $quizzes ? json_decode($quizzes->value, true) : [];

        $search = array_search($quizid, array_column($quizzes, 'id'));

        if($search === false) {
            return ['success' => false];
        }

        // Is Student enabled?
        try {
            $student_token = student::login($userid);
            
            $session_request = network::sendRequest(
                'POST', 
                'student',
                'antifraud/sessions/create',
                null,
                [
                    'Authorization' => 'Bearer ' . $student_token,
                ]
            );
            $session_id = $session_request['id'];
    
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
    public static function list($page = 1)
    {
        try {
            $token = user::login();

            $sessions_request = network::sendRequest(
                'GET', 
                'cms',
                'cms/v1/antifraud_sessions?page='. $page .'&paginates_per=' . self::$SESSIONS_PER_PAGE,
                null,
                [
                    'Authorization' => 'Bearer ' . $token,
                ]
            );  
            
            return $sessions_request['content'];
        } catch (\Exception $e) {
            die('Unable to list sessions. Check your credentials in SETTINGS section.');
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
            die('Unable to get session details');
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
            die('Unable to get session events');
        }     
    }    

}