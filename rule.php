<?php 
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

function quizaccess_edusyncheproctoring_attempt_viewed_handler($event)
{
    global $DB, $SESSION, $USER, $CFG;

    $userid       = $event->userid; 
    $attemptid    = $event->objectid;
    $cmid         = $event->contextinstanceid;
    $currentpage  = optional_param('page', 0, PARAM_INT);
    
    $quizid       = $DB->get_record('quiz_attempts', ['id' => $attemptid])->quiz; 
    $quiz_enabled = \quizaccess_edusyncheproctoring\quiz::is_enabled($quizid);

    if($quiz_enabled) {
        $is_eproctoring_started = isset($SESSION->edusyncheproctoring_started) ? $SESSION->edusyncheproctoring_started : false;

        if(!$is_eproctoring_started) 
        {
            $SESSION->edusyncheproctoring_redirect  = 'mod/quiz/attempt.php?attempt=' . $attemptid . '&cmid=' . $cmid . '&page=' . $currentpage;
            $SESSION->edusyncheproctoring_attemptid = $attemptid;
            $SESSION->edusyncheproctoring_cmid      = $cmid;
            $SESSION->userid                        = $userid;
            $SESSION->quizid                        = $quizid;            
            redirect($CFG->wwwroot . '/mod/quiz/accessrule/edusyncheproctoring/setup_quiz.php?attemptid=' . $attemptid . '&cmid=' . $cmid . '&page=' . $currentpage);
        }
    }
}

function quizaccess_edusyncheproctoring_attempt_preview_started_handler($event)
{
    // TODO
}

function quizaccess_edusyncheproctoring_attempt_regraded_handler($event)
{
    // TODO
}

function quizaccess_edusyncheproctoring_attempt_started_handler($event)
{
    global $DB, $SESSION, $USER, $CFG;

    $userid       = $event->userid; 
    $attemptid    = $event->objectid;
    $cmid         = $event->contextinstanceid;
    $quizid       = $DB->get_record('quiz_attempts', ['id' => $attemptid])->quiz; 
    $quiz_enabled = \quizaccess_edusyncheproctoring\quiz::is_enabled($quizid);
    $currentpage  = 0;

    if($quiz_enabled) {
        $is_eproctoring_started = isset($SESSION->edusyncheproctoring_started) ? $SESSION->edusyncheproctoring_started : false;

        if(!$is_eproctoring_started) 
        {
            $SESSION->edusyncheproctoring_redirect = 'mod/quiz/attempt.php?attempt=' . $attemptid . '&cmid=' . $cmid . '&page=' . $currentpage;
            $SESSION->userid                       = $userid;
            $SESSION->quizid                       = $quizid;
            redirect($CFG->wwwroot . '/mod/quiz/accessrule/edusyncheproctoring/setup_quiz.php?attemptid=' . $attemptid . '&cmid=' . $cmid . '&page=' . $currentpage);
        }
    }
    
}

function quizaccess_edusyncheproctoring_attempt_summary_viewed_handler($event)
{
    // TODO
}

function quizaccess_edusyncheproctoring_attempt_submitted_handler($event)
{
    global $SESSION;

    $session_id    = isset($SESSION->edusyncheproctoring_sessionid) ? $SESSION->edusyncheproctoring_sessionid : null;        
    $student_token = isset($SESSION->edusyncheproctoring_token) ? $SESSION->edusyncheproctoring_token : null;   

    if(!is_null($session_id) && !is_null($student_token)) {
        $end_event = \quizaccess_edusyncheproctoring\session::create_event_for($student_token, $session_id, 'FINISH_SIMULATION');
        $SESSION->edusyncheproctoring_started   = null;        
        $SESSION->edusyncheproctoring_token     = null;   
        $SESSION->userid = null;
        $SESSION->quizid = null;        
    }

}

function quizaccess_edusyncheproctoring_report_viewed_handler($event)
{
    // TODO
}

function quizaccess_edusyncheproctoring_attempt_reviewed_handler($event)
{
    global $SESSION;
    
    $session_id    = isset($SESSION->edusyncheproctoring_sessionid) ? $SESSION->edusyncheproctoring_sessionid : null;        

    if(!is_null($session_id)) {
        echo "<script type=\"text/javascript\">
        var body = document.querySelectorAll('body')[0];
        
        body.setAttribute('data-proctoring', 'expired');
        </script>
        ";   
        
        $SESSION->edusyncheproctoring_sessionid = null;
    }
}

function quizaccess_edusyncheproctoring_course_module_instance_list_viewed_handler($event)
{
    // TODO
}

function quizaccess_edusyncheproctoring_course_module_viewed_handler($event)
{
    global $PAGE, $SESSION, $COURSE, $CFG;

    $context    = context_course::instance($COURSE->id);
    $userid     = $event->userid; 
    $quizid     = $event->objectid; 
    
    $quiz_enabled    = \quizaccess_edusyncheproctoring\quiz::is_enabled($quizid);

    if($quiz_enabled) {
        $PAGE->requires->jquery();

        $has_permission_to_view_report = has_capability('quizaccess/edusyncheproctoring:view_report', $context);

        if($has_permission_to_view_report) {
            $js = "
            var main_div = $('div[role=main]');
            main_div.append('<div class=\"text-center\"><a class=\"btn btn-warning\" href=\"$CFG->wwwroot/mod/quiz/accessrule/edusyncheproctoring/index.php?action=sessions&courseid=$COURSE->id&quizid=$quizid\">View EduSynch E-Proctoring reports</button></a>');
            ";

            $PAGE->requires->js_init_code($js);
        }

    }
    

}

function quizaccess_edusyncheproctoring_attempt_abandoned_handler($event)
{
    // TODO
}

class quizaccess_edusyncheproctoring extends quiz_access_rule_base {
    public static function add_settings_form_fields(mod_quiz_mod_form $quizform, MoodleQuickForm $mform) {
        global $COURSE;
        
        $context    = context_course::instance($COURSE->id);
        
        if(has_capability('quizaccess/edusyncheproctoring:enable_quiz', $context)) {
            
            $eproctoring_required = 0;
            $form_data = $quizform->get_current(); 

            if(isset($form_data->id) && !is_null($form_data->id)) {
                $config          = new \quizaccess_edusyncheproctoring\config();
                $enabled_quizzes = $config->get_key('quizzes');
                
                if(!is_null($enabled_quizzes)) {
                    $quizzes = json_decode($enabled_quizzes->value, true);
                    foreach($quizzes as $quiz) {
                        if($quiz['id'] == $form_data->id) {
                            $eproctoring_required = 1;
                            continue;
                        }
                    }
                }
            }

            $header = $mform->createElement('header', 'edusyncheproctoring', 'Edusynch E-Proctoring');
            $mform->insertElementBefore($header, 'security');

            $element = $mform->createElement(
                'select',
                'edusynch_requireeproctoring',
                'Require E-Proctoring Plugin',
                [0 => 'No', 1 => 'Yes']
            );
            $mform->insertElementBefore($element, 'security');
            $mform->setType('edusynch_requireeproctoring', PARAM_INT);
            $mform->setDefault('edusynch_requireeproctoring', $eproctoring_required);
        }

    }
}
