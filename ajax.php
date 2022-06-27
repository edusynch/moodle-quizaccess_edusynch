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
 * Ajax actions
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
header('Content-Type: application/json');

require_once(__DIR__ . '/../../../../config.php');
is_siteadmin() || die;

global $PAGE, $DB;

$config = new \quizaccess_edusynch\config();

$action = required_param('action', PARAM_ALPHA);

if ($action == 'courses') {
    $courses = $DB->get_records('course'); 

    $return = [];

    foreach($courses as $index => $course) {
        $return[] = ['id' => $course->id, 'name' => $course->fullname];
    }
    
    echo json_encode($return);
} else if ($action == 'quizzes') {
    $course = required_param('course', PARAM_INT);

    $quizzes = $DB->get_records('quiz', ['course' => $course]); 

    $return = [];

    foreach($quizzes as $index => $quiz) {
        $return[] = ['id' => $quiz->id, 'name' => $quiz->name];
    }
    
    echo json_encode($return);
}