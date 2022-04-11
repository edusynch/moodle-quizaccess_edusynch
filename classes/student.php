<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

namespace quizaccess_edusyncheproctoring;

use quizaccess_edusyncheproctoring\config;
use quizaccess_edusyncheproctoring\network;

defined('MOODLE_INTERNAL') || die();

/**
 * student class.
 *
 * This class manages the E-Proctoring students
 *
 * @package    quizaccess_edusyncheproctoring
 * @category   quiz
 * @copyright  2022 Edusynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class student {

    /**
     * Requests for a student token on Edusynch for the logged user
     *
     * @param   int     $userid  The moodle user ID 
     * @return  string  The generated token  
     */     
    public static function login($userid)
    {       
        global $DB;
        
        $config = new config();
        $api_key = $config->get_key('api_key')->value;   
        
        try {
            $user = $DB->get_record('user', ['id' => $userid]);
            
            $firstname = $user->firstname;
            $lastname = $user->lastname;
            $email = $user->email;

            $student_check = network::sendRequest(
                'POST', 
                'student',
                'common/authentication/login_antifraud',
                [
                    'application_key' => $api_key,
                    'name' => $firstname . ' ' . $lastname,
                    'email' => $email,
                ]
            );
            
            $token = $student_check['content']['student']['token'];

            return $token;
        } catch (\Exception $e) {
            throw new \Exception('Unable to login student: ' . $e->getMessage());
        }
    } 

}