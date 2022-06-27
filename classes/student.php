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
 * Student class
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quizaccess_edusynch;

use quizaccess_edusynch\config;
use quizaccess_edusynch\network;

defined('MOODLE_INTERNAL') || die();

/**
 * student class.
 *
 * This class manages the E-Proctoring students
 *
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
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
            throw new \Exception(get_string('error:general', 'quizaccess_edusynch', $e->getMessage()));
        }
    } 

}