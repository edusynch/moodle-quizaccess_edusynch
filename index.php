<?php 
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

require_once(__DIR__ . '/../../../../config.php');
/**
 * EPROCTORING_URL - sets the current URL (web) of the plugins page.
 */
define('EPROCTORING_PATH', $CFG->wwwroot . '/mod/quiz/accessrule/edusyncheproctoring/');
define('EPROCTORING_URL', EPROCTORING_PATH . 'index.php');

require_login();

$action     = optional_param('action', 'settings', PARAM_ALPHA);
$subaction  = optional_param('subaction', '', PARAM_ALPHA);

global $PAGE, $DB, $ADMIN, $SESSION;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/mod/quiz/accessrule/edusyncheproctoring/index.php');
$PAGE->set_title('EduSynch E-Proctoring');
$PAGE->set_heading('EduSynch E-Proctoring');

$config      = new \quizaccess_edusyncheproctoring\config();
$config_key  = $config->get_key('api_key');    

if ($action != 'settings' && !$config_key) {
    echo $OUTPUT->header();

    ?>
    <div class="alert alert-info mt-3">
        <i class="fa fa-info-circle"></i> Please, visit <a href="<?php echo EPROCTORING_URL . '?action=settings' ?>">Settings Page</a> to set your credentials before continue.
    </div>
    <?php
    return;
} else {
    if($action == 'settings') {
        require_capability('quizaccess/edusyncheproctoring:edit_settings', $context);
    
        global $PAGE;
    
        $application_info = \quizaccess_edusyncheproctoring\user::get_application_info();
        $total_students   = intval($application_info['total_students']);
    
        
        $student_api   = optional_param('student_api', '', PARAM_RAW);
        $cms_api       = optional_param('cms_api', '', PARAM_RAW);
        $events_api    = optional_param('events_api', '', PARAM_RAW);
        $api_key       = optional_param('api_key', '', PARAM_RAW);
        $user          = optional_param('user', '', PARAM_RAW);
        $password      = optional_param('password', '', PARAM_RAW);
        $success       = optional_param('success', 0, PARAM_INT); 

        $importform = new \quizaccess_edusyncheproctoring\importstudent_form(EPROCTORING_URL . '?action=settings&subaction=import');

    
        $success = (bool) $success;
        $quizzes       = $config->get_key('quizzes');    
    
        if($api_key == '') {
            $student_api  = $config->get_key('student_api');    
            $cms_api      = $config->get_key('cms_api');    
            $events_api   = $config->get_key('events_api');    
            $api_key      = $config->get_key('api_key');    
            $user         = $config->get_key('user');    
            $password     = $config->get_key('password');    
            
            $student_api_value  = $student_api ? $student_api->value : null;    
            $cms_api_value      = $cms_api ? $cms_api->value : null;    
            $events_api_value   = $events_api ? $events_api->value : null;    
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
    
            if(!empty($student_api) && !empty($cms_api) && !empty($events_api)) {
                $config->set_key('student_api', $student_api);              
                $config->set_key('cms_api', $cms_api);   
                $config->set_key('events_api', $events_api);   
            }
    
            $student_api_value  = $student_api;
            $cms_api_value      = $cms_api;
            $events_api_value   = $events_api;        
            $success = true;
        }
    
        $quizzes_enabled = is_null($quizzes) ? [] : json_decode($quizzes->value, true);
    
        if($subaction == 'import') {
            global $USER;
    
            $file = required_param('import_list', PARAM_FILE); 
    
            $fs = get_file_storage();
            $context = context_user::instance($USER->id);
            $files = $fs->get_area_files($context->id, 'user', 'draft', $file, 'id DESC', false);
    
            $tempfile = reset($files)->copy_content_to_temp();
            $import_list = \quizaccess_edusyncheproctoring\user::import_students($tempfile);    
    
            redirect(EPROCTORING_URL . '?action=settings&success=1');
         } else if ($subaction == 'quizzes') {
            $quizzes = optional_param_array('quizzes', [], PARAM_INT);    
        
            if(count($quizzes) > 0) {
                $quizzes = array_unique($quizzes);
            }
    
            $quizzes_array = [];
            foreach($quizzes as $quiz) {
                $quiz_info   = $DB->get_record('quiz', ['id' => $quiz]);
                $course_info = $DB->get_record('course', ['id' => $quiz_info->course]);
                $quizzes_array[] = ['id' => $quiz, 'name' => $quiz_info->name, 'course' => $course_info->fullname];
            }
            $config->set_key('quizzes', json_encode($quizzes_array));
    
            redirect(EPROCTORING_URL . '?action=settings&success=1');
         }
    
    } else if ($action == 'sessions') {   
        global $COURSE, $USER, $CFG;

        $current_page = optional_param('page', 1, PARAM_INT);
        $courseid     = required_param('courseid', PARAM_INT);
        $quizid       = required_param('quizid', PARAM_INT);

        $coursecontext  = context_course::instance($courseid);   
        require_capability('quizaccess/edusyncheproctoring:view_report', $coursecontext);
    
        $content       = \quizaccess_edusyncheproctoring\session::list($current_page, $quizid);    
        $sessions_list = array_filter($content['sessions'], function($array) use($content) {
            return in_array($array['id'], $content['sessions_per_quiz']);
        });
    
        $prev_page          = $content['prev_page'];    
        $next_page          = $content['next_page'];    
        $last_page          = $content['last_page'];    
        $total_pages        = $content['total_pages'];       
    
    } else if ($action == 'session') {   
        $courseid    = required_param('courseid', PARAM_INT);
        $quizid      = required_param('quizid', PARAM_INT);
        $session_id  = required_param('session_id', PARAM_INT);
        $events_page = optional_param('events_page', 1, PARAM_INT);

        $coursecontext  = context_course::instance($courseid);   
        require_capability('quizaccess/edusyncheproctoring:view_report', $coursecontext);
    

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
    
}

$PAGE->requires->jquery();
    
echo $OUTPUT->header();    

include 'views/' . $action . '.php';

echo $OUTPUT->footer();
