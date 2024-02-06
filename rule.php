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

    
}

function quizaccess_edusynch_attempt_summary_viewed_handler($event)
{
    // TODO
}

function quizaccess_edusynch_attempt_submitted_handler($event)
{

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

        $config        = new \quizaccess_edusynch\config();
        $lti_url       = $config->get_key('lti_url');       

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

        $payload = [
            'provider' => 'moodle',
            'url' => 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            'student_data' => [
                'token' => $token_string
            ]
        ];

        $login_request = \quizaccess_edusynch\network::sendRequest(
            'POST', 
            'lti',
            $lti_url->value . '/auth/v1/authentications/login', 
            ['payload' => json_encode($payload)],
            ['Content-Type' => 'form-data']
        );    

            
        $framechecker = "";
        $quizProctored = false;
        if(array_key_exists("content", $login_request) && $login_request["content"]["enabled"]) 
            $quizProctored = true;

        if($quizProctored) {
            $json_encode_response = json_encode($login_request);
            $framechecker = "
            div.innerHTML='<iframe id=\"edusynch-app\" style=\"border: 0;\" src=\"https://checker.edusynch.com/\" width=\"100%\" height=\"920\"></iframe>';
            ";
        }


        $js = "
            window.LOGIN_LTI = JSON.parse('{$json_encode_response}');
            var div = document.querySelectorAll('.quizstartbuttondiv')[0].parentNode;
            var form = div.querySelectorAll('form')[0];
            var btn = form.querySelectorAll('button[type=submit]')[0];
             
            btn.style.display = 'none';

            setTimeout(function(){
                // Insert iframe 
                if(document.head.dataset.eproctoring != 'true') {
                    {$framechecker}
                } else {
                    btn.style.display = '';
                    btn.setAttribute('data-eproctoring', 'submit');
        
                    var btnsub = document.getElementById(\"id_submitbutton\");
                    btnsub.setAttribute('data-eproctoring', 'start');   
                }    
            }, 3000);
     
        ";        

        echo "<script type=\"text/javascript\">window.EDUSYNCH_TOKEN=\"$token_string\"</script>";

        $PAGE->requires->js_init_code($js);                  
    } catch (\Exception $e) {
        // Form free
        $error = json_encode($e->getMessage());

        $js = "
            console.log('ERROR: {$error}');
        ";        


        $PAGE->requires->js_init_code($js);        
    }

}

function quizaccess_edusynch_attempt_abandoned_handler($event)
{
    // TODO
}

