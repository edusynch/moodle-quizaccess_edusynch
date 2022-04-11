<?php 
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */
header('Content-Type: application/json');

require_once(__DIR__ . '/../../../../config.php');
is_siteadmin() || die;

global $PAGE, $DB;

$config = new \quizaccess_edusyncheproctoring\config();

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