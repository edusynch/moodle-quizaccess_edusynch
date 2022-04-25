<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

function quizaccess_edusyncheproctoring_render_navbar_output() {
    global $PAGE, $CFG;

    $context = context_system::instance();

    if (!is_siteadmin()) {
        return '';
    }
    
}

function quizaccess_edusyncheproctoring_before_footer()
{

}

function quizaccess_edusyncheproctoring_coursemodule_edit_post_actions($moduleinfo)
{
    global $DB;

    $modulename = $moduleinfo->modulename;

    echo '<pre>';

    if($modulename == 'quiz' && isset($moduleinfo->edusynch_requireeproctoring)) {
        $required           = intval($moduleinfo->edusynch_requireeproctoring);
        $requireeproctoring = (bool) $required;
        $quizid             = intval($moduleinfo->id);
        
        $config          = new \quizaccess_edusyncheproctoring\config();
        $enabled_quizzes = $config->get_key('quizzes');
        
        
        if($required) {
            $quizzes_array = [$quizid];
        } else {
            $quizzes_array = [];
        }

        if($enabled_quizzes) {
            $json_decode = json_decode($enabled_quizzes->value, true);
            foreach($json_decode as $item) {
                $itemid = intval($item['id']);
                
                // Prevent to add quiz if it's not required
                if($itemid != $quizid || ($itemid == $quizid && $required)) {
                    $quizzes_array[] = $item['id'];
                } 
            }
        }

        
        $quizzes_array = array_unique($quizzes_array);

        $final_array = [];
        foreach($quizzes_array as $quiz) {
            $quiz_info   = $DB->get_record('quiz', ['id' => $quiz]);
            $course_info = $DB->get_record('course', ['id' => $quiz_info->course]);
            $final_array[] = ['id' => $quiz, 'name' => $quiz_info->name, 'course' => $course_info->fullname];
        }
        $config->set_key('quizzes', json_encode($final_array));
    }
}