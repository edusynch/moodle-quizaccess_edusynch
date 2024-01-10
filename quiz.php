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
 * Quiz actions
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');

global $PAGE, $DB;

$action      = required_param('action', PARAM_ALPHA);
$token_param = required_param('token', PARAM_ALPHANUMEXT);

$config = new \quizaccess_edusynch\config();
$token  = $config->get_key('oauth_token');

if ($token->value !== $token_param) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    die;
}

if ($action == 'show') {
    $response  = [];
    $course_id = optional_param('courseId', '', PARAM_INT);
    $quiz_id   = optional_param('quizId', '', PARAM_INT);

    if (!empty($quiz_id)) {
        $quiz = $DB->get_record_sql(
            'SELECT {course_modules}.id AS `quiz_id`, {quiz}.* FROM {quiz}, {course_modules}, {modules} 
            
            WHERE 
            {course_modules}.course = :course_id
            AND {course_modules}.id = :quiz_id
            AND {course_modules}.module = {modules}.id 
            AND {modules}.name = :module_name
            AND mdl_course_modules.instance = mdl_quiz.id
            ',
            [
                'module_name' => 'quiz',
                'quiz_id' => $quiz_id,
                'course_id' => $course_id,
            ]
        );  

        $response = [
            'success' => true,
            'quiz'    => [
                'id'          => $quiz->quiz_id,
                'title'       => $quiz->name,
                'access_code' => $quiz->password,
                'course_id'   => $quiz->course,
                'intro'       => $quiz->intro,
                'created_at'  => date('Y-m-d H:i:s', $quiz->timecreated),
                'timeopen'    => $quiz->timeopen,
                'timelimit'   => $quiz->timelimit,
                'timeclose'   => $quiz->timeclose,
            ],
        ];
    } else {
        $quizzes = $DB->get_records_sql(
            'SELECT {course_modules}.id AS `quiz_id`, {quiz}.* FROM {quiz}, {course_modules}, {modules} 
            
            WHERE 
            {course_modules}.course = :course_id
            AND {course_modules}.module = {modules}.id 
            AND {modules}.name = :module_name
            AND mdl_course_modules.instance = mdl_quiz.id
            ',
            [
                'module_name' => 'quiz',
                'course_id' => $course_id,
            ]
        );  
        $parsed_quizzes = [];
        $page           = optional_param('page', 1, PARAM_INT);
        $paginates_per  = optional_param('paginates_per', 10, PARAM_INT);

        foreach ($quizzes as $quiz) {
            array_push($parsed_quizzes, [
                'id'          => $quiz->quiz_id,
                'title'       => $quiz->name,
                'access_code' => $quiz->password,
                'course_id'   => $course_id,
                'intro'       => $quiz->intro,
                'created_at'  => date('Y-m-d H:i:s', $quiz->timecreated),
                'timeopen'    => $quiz->timeopen,
                'timelimit'   => $quiz->timelimit,
                'timeclose'   => $quiz->timeclose,
            ]);
        }

        $total_pages  = ceil(count($parsed_quizzes) / $paginates_per);
        $current_page = $page;
        $next_page    = $current_page < $total_pages ? $current_page + 1 : $total_pages;
        $prev_page    = $current_page > 1 ? $current_page - 1 : 1;
        $offset       = ($current_page - 1) * $paginates_per;
        $quizzes      = array_slice($parsed_quizzes, $offset, $paginates_per);

        $response = [
            'success'      => true,
            'total_pages'  => $total_pages,
            'current_page' => $current_page,
            'next_page'    => $next_page,
            'prev'         => $prev_page,
            'quizzes'      => $quizzes,
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else if ($action == 'update') {
    $quiz_id     = required_param('id', PARAM_INT);
    $description = optional_param('description', '', PARAM_ALPHANUMEXT);
    $timeclose   = optional_param('timeclose', '', PARAM_INT);
    $access_code = optional_param('access_code', '', PARAM_ALPHANUMEXT);


    $module = $DB->get_record_sql(
        'SELECT {course_modules}.id AS `quiz_id`, {quiz}.* FROM {quiz}, {course_modules}, {modules} 
        
        WHERE 
        {course_modules}.course = :course_id
        AND {course_modules}.id = :quiz_id
        AND {course_modules}.module = {modules}.id 
        AND {modules}.name = :module_name
        AND mdl_course_modules.instance = mdl_quiz.id
        ',
        [
            'module_name' => 'quiz',
            'quiz_id' => $quiz_id,
            'course_id' => $course_id,
        ]
    );     

    $quiz     = $DB->get_record('quiz', ['id' => $module->id]);

    if (!empty($description)) $quiz->intro = $description;
    if (!empty($timeclose)) $quiz->timeclose = $timeclose;
    if (!empty($access_code)) $quiz->password = $access_code;

    $DB->update_record('quiz', $quiz);

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
}

