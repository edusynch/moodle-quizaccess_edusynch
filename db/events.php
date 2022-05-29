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
 * Quiz plugin for integration with Edusynch Eproctoring proctoring system.
 *
 * @package   quizaccess_edusynch
 * @copyright 2022, EduSynch <contact@edusynch.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname' => 'mod_quiz\event\attempt_viewed',
        'callback' => 'quizaccess_edusynch_attempt_viewed_handler',
        'internal' => false,
    ],
    [
        'eventname' => 'mod_quiz\event\attempt_reviewed',
        'callback' => 'quizaccess_edusynch_attempt_reviewed_handler',
        'internal' => false,
    ],   
    
    [
        'eventname' => '\mod_quiz\event\attempt_submitted',
        'callback' => 'quizaccess_edusynch_attempt_submitted_handler',
        'internal' => false,
    ], 

    [
        'eventname' => 'mod_quiz\event\attempt_preview_started',
        'callback' => 'quizaccess_edusynch_attempt_preview_started_handler',
        'internal' => false,
    ],  
    
    [
        'eventname' => 'mod_quiz\event\attempt_summary_viewed',
        'callback' => 'quizaccess_edusynch_attempt_summary_viewed_handler',
        'internal' => false,
    ],        

    [
        'eventname' => 'mod_quiz\event\attempt_regraded',
        'callback' => 'quizaccess_edusynch_attempt_regraded_handler',
        'internal' => false,
    ],     

    [
        'eventname' => 'mod_quiz\event\attempt_started',
        'callback' => 'quizaccess_edusynch_attempt_started_handler',
        'internal' => false,
    ],     

    [
        'eventname' => 'mod_quiz\event\report_viewed',
        'callback' => 'quizaccess_edusynch_report_viewed_handler',
        'internal' => false,
    ],      

    [
        'eventname' => 'mod_quiz\event\course_module_instance_list_viewed',
        'callback' => 'quizaccess_edusynch_course_module_instance_list_viewed_handler',
        'internal' => false,
    ],      

    [
        'eventname' => 'mod_quiz\event\course_module_viewed',
        'callback' => 'quizaccess_edusynch_course_module_viewed_handler',
        'internal' => false,
    ],      
    
    [
        'eventname' => 'mod_quiz\event\attempt_abandoned',
        'callback' => 'quizaccess_edusynch_attempt_abandoned_handler',
        'internal' => false,
    ],         

];
