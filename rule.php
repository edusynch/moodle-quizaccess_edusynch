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
    $session_details = \quizaccess_edusyncheproctoring\session::create($userid);

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

function quizaccess_edusyncheproctoring_attempt_abandoned_handler($event)
{
    // TODO
}