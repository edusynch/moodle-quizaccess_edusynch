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
 * Settings form
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
?>
<div class="container">
    <?php 
$host = $PAGE->url->get_host();
?>

<span id="add-course-label" data-label="<?php echo get_string('config:add_course', 'quizaccess_edusynch') ?>"></span>
<span id="add-course-for-save-label" data-label="<?php echo get_string('config:add_course_for_save', 'quizaccess_edusynch') ?>"></span>
<span id="course-label" data-label="<?php echo get_string('config:course', 'quizaccess_edusynch') ?>"></span>
<span id="quiz-label" data-label="<?php echo get_string('config:quiz', 'quizaccess_edusynch') ?>"></span>
<span id="select-course-label" data-label="<?php echo get_string('config:select_course', 'quizaccess_edusynch') ?>"></span>
<span id="select-quiz-label" data-label="<?php echo get_string('config:select_quiz', 'quizaccess_edusynch') ?>"></span>

<span id="data-auth" data-label="<?php echo $_SESSION["USER"]->id ?>"></span>
<span id="data-url" data-label="<?php echo $lti_url_value ?>"></span>
<span id="data-draft-token" data-label="<?php echo $draft_token ?>"></span>
<span id="data-saved-token" data-label="<?php echo $saved_token ?>"></span>
<span id="data-moodle-url" data-label="<?php echo $moodle_url ?>"></span>

<script src="js/add-course.js"></script>

<?php include('dist/index.html') ?>

