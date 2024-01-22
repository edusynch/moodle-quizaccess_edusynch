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
 * Course actions
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
header('Content-Type: application/json');

require_once(__DIR__ . '/../../../../config.php');

global $PAGE, $DB;

$action      = required_param('action', PARAM_ALPHA);
$token_param = required_param('token', PARAM_ALPHANUMEXT);
$search_term = optional_param('search_term', '', PARAM_ALPHANUMEXT);

$config = new \quizaccess_edusynch\config();
$token  = $config->get_key('oauth_token');

if ($token->value !== $token_param) {
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    die;
}

if ($action == 'list') {
    $couses         = [];
    $likefullname   = $DB->sql_like('fullname', ':fullname');
    if (empty($search_term)) {
        $courses = $DB->get_records("course");
    } else {
        $courses = $DB->get_records_sql(
            "SELECT * FROM {course} WHERE {$likefullname}",
            ['fullname' => '%' . $DB->sql_like_escape($search_term) . '%'],
        );
    }
    
    $parsed_courses = [];

    foreach ($courses as $course) {
        array_push($parsed_courses, [
            'id'         => $course->id,
            'name'       => $course->fullname,
            'created_at' => date('Y-m-d H:i:s', $course->timecreated),
            'published'  => $course->visible == "1" ? true : false,
        ]);
    }

    header('Content-Type: application/json');
    echo json_encode(['success' => "%{$search_term}%", 'courses' => $parsed_courses]);
} else if ($action == 'show') {
    $courseId       = required_param('id', PARAM_INT);
    $course        = $DB->get_record("course", ['id' => intval($courseId)]);

    $course = [
        'id'         => $course->id,
        'name'       => $course->fullname,
        'created_at' => date('Y-m-d H:i:s', $course->timecreated),
        'published'  => $course->visible == "1" ? true : false,
    ];

    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'course' => $course]);
}


