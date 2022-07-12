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
 * Index view
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');
/**
 * EPROCTORING_URL - sets the current URL (web) of the plugins page.
 */
define('EPROCTORING_PATH', $CFG->wwwroot . '/mod/quiz/accessrule/edusynch/');
define('EPROCTORING_URL', EPROCTORING_PATH . 'index.php');

require_login();

$action     = optional_param('action', 'settings', PARAM_ALPHA);
$subaction  = optional_param('subaction', '', PARAM_ALPHA);

global $PAGE, $DB, $ADMIN, $SESSION;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/mod/quiz/accessrule/edusynch/index.php');
$PAGE->set_title(get_string('pluginname', 'quizaccess_edusynch'));
$PAGE->set_heading(get_string('pluginname', 'quizaccess_edusynch'));

$config      = new \quizaccess_edusynch\config();
$config_key  = $config->get_key('api_key');    

if ($action != 'settings' && !$config_key) {
    echo $OUTPUT->header();
    include 'views/navbars.php';

    ?>
    <div class="alert alert-info mt-3">
        <i class="fa fa-info-circle"></i> 
        <?php echo get_string('config:no_settings', 'quizaccess_edusynch', EPROCTORING_URL . '?action=settings') ?>
    </div>
    <?php
    return;
} else {
    if($action == 'settings') {
        require_capability('quizaccess/edusynch:edit_settings', $context);
    
        global $PAGE;
    
        $application_info = \quizaccess_edusynch\user::get_application_info();

        $total_students   = 0;
        
        if($application_info['success']) {
            $total_students   = intval($application_info['data']['total_students']);
        }
    
        
        $student_api   = optional_param('student_api', '', PARAM_RAW);
        $cms_api       = optional_param('cms_api', '', PARAM_RAW);
        $events_api    = optional_param('events_api', '', PARAM_RAW);
        $api_key       = optional_param('api_key', '', PARAM_RAW);
        $user          = optional_param('user', '', PARAM_RAW);
        $password      = optional_param('password', '', PARAM_RAW);
        $success       = optional_param('success', 0, PARAM_INT); 

        $importform = new \quizaccess_edusynch\importstudent_form(EPROCTORING_URL . '?action=settings&subaction=import');
    
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
            $import_list = \quizaccess_edusynch\user::import_students($tempfile);    
    
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

        $current_date  = date_format(new DateTime(), 'Y-m-d');
        $one_month_ago = date_format((new DateTime())->sub(DateInterval::createFromDateString('1 month')), 'Y-m-d');

        $current_page = optional_param('page', 1, PARAM_INT);
        $start_date   = optional_param('start_date', $one_month_ago, PARAM_RAW);
        $end_date     = optional_param('end_date', $current_date, PARAM_RAW);
        $search       = optional_param('search', '', PARAM_RAW);

        $quiz_selected = false;

        if(!is_siteadmin()) {
            $courseid     = required_param('courseid', PARAM_INT);
            $quizid       = required_param('quizid', PARAM_INT);
        } else {
            $courseid     = optional_param('courseid', null, PARAM_INT);
            $quizid       = optional_param('quizid', null, PARAM_INT); 
            
            $quizzes      = $config->get_key('quizzes');    
            $quizzes_enabled = is_null($quizzes) ? [] : json_decode($quizzes->value, true);

            foreach($quizzes_enabled as &$qe) {
                $sessions_query = $DB->count_records("quizaccess_edusynch_sessions", ['quiz_id' => $qe['id']]);
                $qe['total_sessions'] = $sessions_query;

                $quiz_query     = $DB->get_record("quiz", ['id' => $qe['id']], 'course');
                if($quiz_query) {
                    $qe['courseid']       = $quiz_query->course;
                }
            }
        }

        if($courseid && $quizid) {
            $quiz_selected = true;
            
            $coursecontext  = context_course::instance($courseid);   
            require_capability('quizaccess/edusynch:view_report', $coursecontext);
        
            $content       = \quizaccess_edusynch\session::list($current_page, $quizid, $start_date, $end_date, $search);   
            
            if($content) {
                $sessions_list = array_filter($content['sessions'], function($array) use($content) {
                    return in_array($array['id'], $content['sessions_per_quiz']);
                });
            
                $prev_page          = $content['prev_page'];    
                $next_page          = $content['next_page'];    
                $last_page          = $content['last_page'];    
                $total_pages        = $content['total_pages']; 
            }

            $quiz_data = $DB->get_record('quiz', ['id' => $quizid]);
        }
      
    
    } else if ($action == 'session') {   
        $courseid    = required_param('courseid', PARAM_INT);
        $quizid      = required_param('quizid', PARAM_INT);
        $session_id  = required_param('session_id', PARAM_INT);
        $events_page = optional_param('events_page', 1, PARAM_INT);

        $coursecontext  = context_course::instance($courseid);   
        require_capability('quizaccess/edusynch:view_report', $coursecontext);
    
        if($subaction == 'changeincident') {
            $incident_level  = optional_param('incident_level', null, PARAM_ALPHA);
            
            if($incident_level) {
                \quizaccess_edusynch\session::change_incident($session_id, $incident_level); 
                $success_message = get_string('session_report:incident_level_changed', 'quizaccess_edusynch');  
            }
        }

        $content      = \quizaccess_edusynch\session::show($session_id);    
        $events_query = \quizaccess_edusynch\session::events($session_id, $events_page);    
        
        $session_details    = $content['session'];    
        $photos             = $content['photos'];    
        $videos             = $content['videos'];    
        $events             = $events_query['events'];    
        $prev_page          = $events_query['prev_page'];    
        $next_page          = $events_query['next_page'];    
        $last_page          = $events_query['last_page'];    
        $total_pages        = $events_query['total_pages'];    
        
        $quiz_data = $DB->get_record('quiz', ['id' => $quizid]);

        $user = new \stdClass();
        // $additionalfields = explode(',', implode(',', \core_user\fields::get_picture_fields()));
        $user = $DB->get_record('user', ['email' => $session_details['student']['email']]);
        $useravatar = $OUTPUT->user_picture($user, array('courseid' => $courseid));        



    }
    
}

$PAGE->requires->jquery();
    
echo $OUTPUT->header();    
include 'views/navbars.php';
include 'views/' . $action . '.php';

echo $OUTPUT->footer();
