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
$generate   = optional_param('generate', '', PARAM_ALPHA);
$lti_url    = optional_param('lti_url', '', PARAM_ALPHA);
$subaction  = optional_param('subaction', '', PARAM_ALPHA);

global $PAGE, $DB, $ADMIN, $SESSION, $USER;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/mod/quiz/accessrule/edusynch/index.php');
$PAGE->set_title(get_string('pluginname', 'quizaccess_edusynch'));
$PAGE->set_heading(get_string('pluginname', 'quizaccess_edusynch'));

$config      = new \quizaccess_edusynch\config();
$config_key  = $config->get_key('oauth_token');    

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
    
        if ($generate == 'token') {
            $string = sha1(rand());
            $token = substr($string, 0, 70);
            $config->set_key('oauth_token', $token);
        }

        if ($lti_url == 'save') {
            $lti_url = optional_param('url', '', PARAM_TEXT);
            $config->set_key('lti_url', $lti_url);
        }
        
        $token         = optional_param('token', '', PARAM_ALPHANUMEXT);    
        $success = (bool) $success;  

        $token         = $config->get_key('oauth_token');
        $lti_url       = $config->get_key('lti_url');
        $token_value   = $token ? $token->value : null;
        $lti_url_value = $lti_url ? $lti_url->value : 'https://lti.edusynch.com';
    
    }  else if ($action == 'launch') {
        $user_id   = $USER->id;
        $user_role = $USER->role;
        $locale    = $USER->lang;
        $cms_api   = $config->get_key('cms_api');
        $lti_url   = $config->get_key('lti_url');

        $new_token_record          = new \stdClass;
        $new_token_record->user_id = $user_id;
        $new_token_record->token   = md5("user_id=$userid");
        $token_string              = $new_token_record->token;
        $DB->insert_record('quizaccess_edusynch_auth', $new_token_record);

        $role_assignamens = $DB->get_records("role_assignments", ['userid' => $user_id]);
        $roles = [];
        foreach ($role_assignamens as $role_assignamen) {
            $result = $DB->get_record('role', ['id' => $role_assignamen->roleid]);
            array_push($roles, ucfirst($result->archetype));
        }

        $domain        = str_replace("/mod/quiz/accessrule/edusynch/index.php", "", $PAGE->url);
        $token         = $config->get_key('oauth_token');
        $token_value   = $token ? $token->value : null;
        $lti_url_value = $lti_url ? $lti_url->value : 'https://lti.edusynch.com';
    }
    
}

$PAGE->requires->jquery();
    
echo $OUTPUT->header();    
include 'views/navbars.php';
include 'views/' . $action . '.php';

echo $OUTPUT->footer();

