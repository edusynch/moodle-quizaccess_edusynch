<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

namespace quizaccess_edusynch;

use quizaccess_edusynch\config;
use quizaccess_edusynch\network;

defined('MOODLE_INTERNAL') || die();

/**
 * user class.
 *
 * This class manages the E-Proctoring students
 *
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 Edusynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class user {

    /**
     * Requests for a user token on Edusynch 
     *
     * @return  string  The generated token  
     */       
    public static function login()
    {       
        global $DB;

        try {
            $config = new config();

            $api_key  = $config->get_key('api_key');   
            $user     = $config->get_key('user');   
            $password = $config->get_key('password');   

            
            $payload = [
                'external_app_type' => 'moodle',
                'external_app_key' => !is_null($api_key) ? $api_key->value : '',
                'email' => !is_null($user) ? $user->value : '',
                'password' => !is_null($password) ? $password->value : '',
            ];

            $payload_jwt = helpers::get_jwt($payload);
    
            $login_request = network::sendRequest(
                'POST', 
                'cms',
                '/auth/v1/authentications/login',
                [
                    'payload' => $payload_jwt,
                ]
            );  
            $token = $login_request['content']['user']['token'];

            return $token;

        } catch (\Exception $e) {
            throw new \Exception('Unable to login user: ' . $e->getMessage());
        }
    }

    /**
     * Requests for a student token on Edusynch for the logged user
     *
     * @param   int     $userid  The moodle user ID 
     * @return  string  The generated token  
     */     
    public static function import_students($file)
    {       
        global $DB;
        
        $config = new config();
        $api_key = $config->get_key('api_key')->value;   
        
        try {
            $token = user::login();

            $students = network::sendRequest(
                'POST', 
                'cms',
                'cms/v1/students/import_external',
                [
                    'file' => $file,
                    'filename' => 'import.csv',
                ],
                [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'multipart/form-data',
                ]
            );

            return $students;
        } catch (\Exception $e) {
            throw new \Exception('Unable to import students: ' . $e->getMessage());
        }
    }       

    public static function get_application_info()
    {        
        $config = new config();
        $api_key = $config->get_key('api_key')->value;   
        
        try {
            $token = user::login();

            $info = network::sendRequest(
                'GET', 
                'cms',
                'cms/v1/external_applications/info',
                null,
                [
                    'Authorization' => 'Bearer ' . $token,
                ]
            );

            return ['success' => true, 'data' => $info['content']['external_application']];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }        
    }
}