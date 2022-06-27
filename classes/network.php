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
 * Network class
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quizaccess_edusynch;

use quizaccess_edusynch\config;
use quizaccess_edusynch\helpers;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/accessrule/edusynch/vendor/autoload.php');

/**
 * network class.
 *
 * This class manages the interaction with Edusynch servers
 *
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class network {

    /** @var string The Edusynch Student Server URL */
    public static $BASE_URL_STUDENT = 'https://api.edusynch.com';
    /** @var string The Edusynch CMS Server URL */
    public static $BASE_URL_CMS     = 'https://cmsapi.edusynch.com';
    /** @var string The Edusynch Events Server URL */
    public static $BASE_URL_EVENTS  = 'https://events.edusynch.com';    

    /**
     * Sends a request to a server
     *
     * @param  string  $method  The request's method 
     * 
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

            $config      = new config();
            $student_api = $config->get_key('student_api');
            $cms_api     = $config->get_key('cms_api');
            $events_api  = $config->get_key('events_api');

            if(is_null($student_api)) {
                $student_api = self::$BASE_URL_STUDENT;
            } else {
                $student_api = $student_api->value;
            }

            if(is_null($cms_api)) {
                $cms_api = self::$BASE_URL_CMS;
            } else {
                $cms_api = $cms_api->value;
            }

            if(is_null($events_api)) {
                $events_api = self::$BASE_URL_EVENTS;
            } else {
                $events_api = $events_api->value;
            }            


            $api_url = '';
            switch($base) {
                case 'cms':
                    $api_url = $cms_api;
                break;
                case 'student':
                    $api_url = $student_api;
                break;
                case 'events':
                    $api_url = $events_api;
                break;
            }

            $default_headers = ['Content-Type' => array_key_exists('Content-Type', $headers) ? $headers['Content-Type'] : 'application/json'];
            $request_config  = ['headers' => $default_headers];

            if (count($headers) > 0) {
                $request_config['headers'] = $request_config['headers'] + $headers;
            }

            if($body && count($body) > 0) {
                if($default_headers['Content-Type'] != 'application/json') {
                    unset($request_config['headers']['Content-Type']); // Auto-seted by Guzzle
                    $request_config['multipart'] = [
                        ['name' => 'file', 'contents' => \GuzzleHttp\Psr7\Utils::tryFopen($body['file'],'r'), 'filename' => $body['filename']]
                    ];
                } else {
                    $request_config['json'] = $body;
                }
            }
    
            $request = $client->request(
                $method, 
                $api_url . '/' . $url,
                $request_config
            );
            
            
            $response = json_decode($request->getBody(), true);            
            
            return $response;    
        } catch (\Exception $e) {
            throw new \Exception(get_string('error:general', 'quizaccess_edusynch', $e->getMessage()));
        }

    }

}