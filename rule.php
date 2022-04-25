<?php 
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

function quizaccess_edusyncheproctoring_attempt_viewed_handler($event)
{
    // TODO
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
    // TODO
}

function quizaccess_edusyncheproctoring_attempt_summary_viewed_handler($event)
{
    global $PAGE; 
    
    echo "<script type=\"text/javascript\">
        // Finish attempt
        var form = document.querySelectorAll('input[name=finishattempt]')[0].parentNode;
        var btn = form.querySelectorAll('button[type=submit]')[0];
        
        btn.setAttribute('data-proctoring', 'finish');

        form.setAttribute('data-proctoring', 'form');
        </script>
";

}

function quizaccess_edusyncheproctoring_report_viewed_handler($event)
{
    // TODO
}

function quizaccess_edusyncheproctoring_course_module_instance_list_viewed_handler($event)
{
    // TODO
}

function quizaccess_edusyncheproctoring_course_module_viewed_handler($event)
{
    global $PAGE;

    $PAGE->requires->jquery();
    

    $userid = $event->userid; 
    $quizid = $event->objectid; 
    $session_details = \quizaccess_edusyncheproctoring\session::create($userid, $quizid);

    if($session_details['success']) {
        $js = "
        // Start attempt
        var btn = $('div.quizstartbuttondiv').find('[type=submit]:first');
        
        btn.attr('disabled', 'disabled');
        btn.attr('data-id', '".$session_details['session_id']."');
        btn.attr('data-token', '".$session_details['token']."');
        btn.attr('data-proctoring', 'start');

        var form = document.getElementsByTagName('form')[0];
        form.setAttribute('data-proctoring', 'form');
";
        $PAGE->requires->js_init_code($js);
    }

}

function quizaccess_edusyncheproctoring_attempt_abandoned_handler($event)
{
    // TODO
}

class quizaccess_edusyncheproctoring extends quiz_access_rule_base {
    public static function add_settings_form_fields(mod_quiz_mod_form $quizform, MoodleQuickForm $mform) {
        $element = $mform->createElement(
            'select',
            'edusyncheproctoring_required',
            'Require E-proctoring Plugin',
            ['0' => 'No', '1' => 'Yes']
        );


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

        $header = $mform->createElement('header', 'edusyncheproctoring', 'Edusynch E-proctoring');
        $mform->insertElementBefore($header, 'security');

        $element = $mform->createElement(
            'select',
            'edusynch_requireeproctoring',
            'Require E-proctoring Plugin',
            [0 => 'No', 1 => 'Yes']
        );
        $mform->insertElementBefore($element, 'security');
        $mform->setType('edusynch_requireeproctoring', PARAM_INT);
        $mform->setDefault('edusynch_requireeproctoring', $eproctoring_required);

    }
}
