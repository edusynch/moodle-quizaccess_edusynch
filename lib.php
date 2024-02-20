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
 * Library methods
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function quizaccess_edusynch_render_navbar_output() {
    global $PAGE, $CFG, $USER, $DB;

    $title = "EduSynch E-Proctoring";
    $url = new \moodle_url('/mod/quiz/accessrule/edusynch/index.php');
    if (!is_siteadmin()) {
        $url = new \moodle_url('/mod/quiz/accessrule/edusynch/index.php?action=launch&course_id=' . $_GET['id']);
    }
    $icon = new \pix_icon('i/hide', '');
    $node = \navigation_node::create($title, $url, \navigation_node::TYPE_CUSTOM, null, null, $icon);
    $version = explode(".", $CFG->release);

    $role_assignamens = $DB->get_records("role_assignments", ['userid' => $USER->id]);
    $roles = [];
    foreach ($role_assignamens as $role_assignamen) {
        $result = $DB->get_record('role', ['id' => $role_assignamen->roleid]);
        array_push($roles, ucfirst($result->archetype));
    }

    if ($version[0] < '4') {
        if (!is_siteadmin() && !in_array('Manager', $roles) && !str_contains($PAGE->url, 'course') && !str_contains($PAGE->url, 'edusynch')) {
            return;
        }

        $PAGE->flatnav->add($node);

        return '';
    } else {
        $node->showinflatnavigation = true;
        $PAGE->navigation->add_node($node);
    }
}

function quizaccess_edusynch_before_footer()
{
}

function quizaccess_edusynch_coursemodule_edit_post_actions($moduleinfo)
{
    global $DB;

    $modulename = $moduleinfo->modulename;

    echo '<pre>';

    if($modulename == 'quiz' && isset($moduleinfo->edusynch_requireeproctoring)) {
        $required           = intval($moduleinfo->edusynch_requireeproctoring);
        $requireeproctoring = (bool) $required;
        $quizid             = intval($moduleinfo->id);
        
        $config          = new \quizaccess_edusynch\config();
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

            if($quiz_info) {
                $course_info = $DB->get_record('course', ['id' => $quiz_info->course]);
                $final_array[] = ['id' => $quiz, 'name' => $quiz_info->name, 'course' => $course_info->fullname];
            }
        }

        if(count($final_array) > 0) {
            $config->set_key('quizzes', json_encode($final_array));
        }
    }
}

