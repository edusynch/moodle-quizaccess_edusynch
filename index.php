<?php 
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

require_once(__DIR__ . '/../../../../config.php');
/**
 * EPROCTORING_URL - sets the current URL (web) of the plugins page.
 */
define('EPROCTORING_URL', $CFG->wwwroot . '/mod/quiz/accessrule/edusyncheproctoring/index.php');

is_siteadmin() || die;

$action     = optional_param('action', 'settings', PARAM_ALPHA);

global $PAGE;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/mod/quiz/accessrule/edusyncheproctoring/index.php');
$PAGE->set_title('EduSynch E-Proctoring');
$PAGE->set_heading('EduSynch E-Proctoring');

echo $OUTPUT->header();

include 'views/navbars.php';
$config      = new \quizaccess_edusyncheproctoring\config();
$config_key  = $config->get_key('api_key');    

if ($action != 'settings' && !$config_key) {
    ?>
    <div class="alert alert-danger mt-3">
        Please, visit SETTINGS page to set your credentials before continue.
    </div>
    <?php
    return;
}

if($action == 'settings') {
    $student_api = optional_param('student_api', '', PARAM_RAW);
    $cms_api     = optional_param('cms_api', '', PARAM_RAW);
    $api_key     = optional_param('api_key', '', PARAM_RAW);
    $api_key     = optional_param('api_key', '', PARAM_RAW);
    $user        = optional_param('user', '', PARAM_RAW);
    $password    = optional_param('password', '', PARAM_RAW);

    $success = null;
    if($api_key == '') {
        $student_api  = $config->get_key('student_api');    
        $cms_api      = $config->get_key('cms_api');    
        $api_key      = $config->get_key('api_key');    
        $user         = $config->get_key('user');    
        $password     = $config->get_key('password');    
        $student_api_value  = $student_api ? $student_api->value : null;    
        $cms_api_value      = $cms_api ? $cms_api->value : null;    
        $api_key_value      = $api_key ? $api_key->value : null;    
        $user_value         = $user ? $user->value : null;    
        $password_value     = $password ? $password->value : null;    
    } else {
        $config->set_key('api_key', $api_key);
        $config->set_key('user', $user);
        $config->set_key('password', $password);
        $api_key_value  = $api_key;
        $user_value     = $user;
        $password_value = $password;

        if(!empty($student_api) && !empty($cms_api)) {
            $config->set_key('student_api', $student_api);              
            $config->set_key('cms_api', $cms_api);   
            $student_api_value  = $student_api;
            $cms_api_value      = $cms_api;
        }
        $success = true;
    }

} else if ($action == 'sessions') {
    $current_page = optional_param('page', 1, PARAM_INT);

    $content = \quizaccess_edusyncheproctoring\session::list($current_page);    

    $sessions_list      = $content['sessions'];
    $prev_page          = $content['prev_page'];    
    $next_page          = $content['next_page'];    
    $last_page          = $content['last_page'];    
    $total_pages        = $content['total_pages'];       

} else if ($action == 'session') {
    $session_id  = required_param('session_id', PARAM_INT);
    $events_page = optional_param('events_page', 1, PARAM_INT);

    $content      = \quizaccess_edusyncheproctoring\session::show($session_id);    
    $events_query = \quizaccess_edusyncheproctoring\session::events($session_id, $events_page);    
    
    $session_details    = $content['session'];    
    $photos             = $content['photos'];    
    $events             = $events_query['events'];    
    $prev_page          = $events_query['prev_page'];    
    $next_page          = $events_query['next_page'];    
    $last_page          = $events_query['last_page'];    
    $total_pages        = $events_query['total_pages'];    
}

include 'views/' . $action . '.php';

echo $OUTPUT->footer();
