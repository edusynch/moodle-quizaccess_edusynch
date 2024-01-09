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
 * Plugin actions
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function quizaccess_edusynch_attempt_viewed_handler($event)
{
    global $DB, $SESSION, $USER, $CFG;

    $userid       = $event->userid; 
    $attemptid    = $event->objectid;
    $cmid         = $event->contextinstanceid;
    $currentpage  = optional_param('page', 0, PARAM_INT);


}

function quizaccess_edusynch_attempt_preview_started_handler($event)
{
    // TODO
}

function quizaccess_edusynch_attempt_regraded_handler($event)
{
    // TODO
}

function quizaccess_edusynch_attempt_started_handler($event)
{
    global $DB, $SESSION, $USER, $CFG;

    $userid       = $event->userid; 
    $attemptid    = $event->objectid;
    $cmid         = $event->contextinstanceid;
    $quizid       = $DB->get_record('quiz_attempts', ['id' => $attemptid])->quiz; 
    $quiz_enabled = \quizaccess_edusynch\quiz::is_enabled($quizid);
    $currentpage  = 0;
    
}

function quizaccess_edusynch_attempt_summary_viewed_handler($event)
{
    // TODO
}

function quizaccess_edusynch_attempt_submitted_handler($event)
{
    global $SESSION;

    $session_id    = isset($SESSION->edusynch_sessionid) ? $SESSION->edusynch_sessionid : null;        
    $student_token = isset($SESSION->edusynch_token) ? $SESSION->edusynch_token : null;   

    if(!is_null($session_id) && !is_null($student_token)) {
        $SESSION->edusynch_started   = null;        
        $SESSION->edusynch_token     = null;   
        $SESSION->userid = null;
        $SESSION->quizid = null;        
    }

}

function quizaccess_edusynch_report_viewed_handler($event)
{
    // TODO
}

function quizaccess_edusynch_attempt_reviewed_handler($event)
{

}

function quizaccess_edusynch_course_module_instance_list_viewed_handler($event)
{
    // TODO
}

function quizaccess_edusynch_course_module_viewed_handler($event)
{
    global $DB, $PAGE, $SESSION, $COURSE, $CFG;

    $context    = context_course::instance($COURSE->id);
    $userid     = $event->userid; 
    $quizid     = $event->objectid;
    

    $PAGE->requires->jquery();

    $expiration_datetime = new DateTime('now');
    $expiration_now      = $expiration_datetime->format('Y-m-d H:i:s');
    $token_string        = null;

    try {
        $token_record = $DB->get_record_sql(
            'SELECT * FROM {quizaccess_edusynch_tokens} WHERE user_id = :user_id AND expiration > :expiration',
            [
                'user_id' => $userid,
                'expiration' => $expiration_now,
            ]
        );

        $js = "
            var div = document.querySelectorAll('.quizstartbuttondiv')[0].parentNode;
            var form = div.querySelectorAll('form')[0];
            var btn = form.querySelectorAll('button[type=submit]')[0];
            
            btn.setAttribute('data-eproctoring', 'submit');

            var btnsub = document.getElementById(\"id_submitbutton\");
            btnsub.setAttribute('data-eproctoring', 'start');            
        ";        

        $PAGE->requires->js_init_code($js);
    
    } catch (Exception $e) {
        die($e->getMessage());
    }

    


    
    if (!$token_record) {
        $expiration_datetime->add(new DateInterval('PT10M'));

        $new_token_record             = new \stdClass;
        $new_token_record->user_id    = $userid;
        $new_token_record->token      = md5("user_id=$userid,quiz_id=$quizid,date=$expiration_now");
        $new_token_record->expiration = $expiration_datetime->format('Y-m-d H:i:s');
        $DB->insert_record('quizaccess_edusynch_tokens', $new_token_record);
        $token_string = $new_token_record->token;
    } else {
        $token_string = $token_record->token;
    }

    echo "<script type=\"text/javascript\">window.EDUSYNCH_TOKEN=\"$token_string\"</script>";
}

function quizaccess_edusynch_attempt_abandoned_handler($event)
{
    // TODO
}

class quizaccess_edusynch extends quiz_access_rule_base {
    public static function add_settings_form_fields(mod_quiz_mod_form $quizform, MoodleQuickForm $mform) {
        global $COURSE;
        
        $context    = context_course::instance($COURSE->id);
        
        if(has_capability('quizaccess/edusynch:enable_quiz', $context)) {
            
            $eproctoring_required = 0;
            $form_data = $quizform->get_current(); 

            if(isset($form_data->id) && !is_null($form_data->id)) {
                $config          = new \quizaccess_edusynch\config();
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

            $header = $mform->createElement('header', 'edusynch', get_string('pluginname', 'quizaccess_edusynch'));
            $mform->insertElementBefore($header, 'security');

            $element = $mform->createElement(
                'select',
                'edusynch_requireeproctoring',
                get_string('config:require_for_quiz', 'quizaccess_edusynch'),
                [0 => get_string('misc:no', 'quizaccess_edusynch'), 1 => get_string('misc:yes', 'quizaccess_edusynch')]
            );
            $mform->insertElementBefore($element, 'security');
            $mform->setType('edusynch_requireeproctoring', PARAM_INT);
            $mform->setDefault('edusynch_requireeproctoring', $eproctoring_required);
        }

    }
}

