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

$action = required_param('action', PARAM_ALPHA);
$token_param = required_param('token', PARAM_ALPHANUMEXT);

$config = new \quizaccess_edusynch\config();

$token = $config->get_key('oauth_token');

if ($token->value !== $token_param) {
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    die;
}


if ($action == 'show') {
    $courses = $DB->get_records("course");
    $parsed_courses = array_map(function ($course) {
        return ['id' => $course->id, 'name' => $course->fullname];
    }, $courses);

    echo json_encode(['success' => true, 'courses' => $parsed_courses]);
}

