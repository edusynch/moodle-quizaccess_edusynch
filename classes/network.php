<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

namespace quizaccess_edusyncheproctoring;

use quizaccess_edusyncheproctoring\config;
use quizaccess_edusyncheproctoring\helpers;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/accessrule/edusyncheproctoring/vendor/autoload.php');

/**
 * network class.
 *
 * This class manages the interaction with Edusynch servers
 *
 * @package    quizaccess_edusyncheproctoring
 * @category   quiz
 * @copyright  2022 Edusynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class network {

    /** @var string The Edusynch Student Server URL */
    public static $BASE_URL_STUDENT = 'https://api.edusynch.com';
    /** @var string The Edusynch CMS Server URL */
    public static $BASE_URL_CMS     = 'https://cmsapi.edusynch.com';

    /**
     * Sends a request to a server
     *
     * @param  string  $method  The request's method 
     * @param  string  $base    The edusynch server target (cms | student)  
     * @param  string  $url     The URL Requested  
     * @param  array   $body    Array with the body of the request (if any)  
     * @param  array   $headers Array with custom headers of the request (if any)  
     * @return string  The JSON response of the request  
     */      
    public static function sendRequest($method = 'GET', $base = 'cms', $url, $body = [], $headers = [])
    {       
        try {
            $client = new \GuzzleHttp\Client();

            $default_headers = ['Content-Type' => 'application/json'];
            $request_config  = ['headers' => $default_headers];

            if (count($headers) > 0) {
                $request_config['headers'] = $request_config['headers'] + $headers;
            }

            if($body && count($body) > 0) {
                $request_config['json'] = $body;
            }
    
            $request = $client->request(
                $method, 
                ($base == 'cms' ? self::$BASE_URL_CMS : self::$BASE_URL_STUDENT) . '/' . $url,
                $request_config
            );
            
            
            $response = json_decode($request->getBody(), true);            
            
            return $response;    
        } catch (\Exception $e) {
            throw new \Exception('An error occurred: ' . $e->getMessage());
        }

    }

}