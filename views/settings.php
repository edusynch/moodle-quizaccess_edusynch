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

    <div class="tab-content">

        <?php if ($success): ?>
        <div class="alert alert-success"><?php echo get_string('misc:success', 'quizaccess_edusynch') ?></div>
        <?php endif; ?>

        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel">
            <h4 class="mt-3"><?php echo get_string('config:keys', 'quizaccess_edusynch') ?></h4>
            <form action="<?php echo EPROCTORING_URL  ?>?action=settings&generate=token" method="POST" class="mt-3">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="token"><?php echo get_string('config:token', 'quizaccess_edusynch') ?>:
                            </label>
                            <input class="form-control" type="text" id="token" name="token"
                                value="<?php echo $token_value ?>">
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="btn btn-primary"><?php echo get_string('config:generate_token', 'quizaccess_edusynch') ?></button>
            </form>

        </div>

    </div>
</div>

<span id="add-course-label" data-label="<?php echo get_string('config:add_course', 'quizaccess_edusynch') ?>"></span>
<span id="add-course-for-save-label" data-label="<?php echo get_string('config:add_course_for_save', 'quizaccess_edusynch') ?>"></span>
<span id="course-label" data-label="<?php echo get_string('config:course', 'quizaccess_edusynch') ?>"></span>
<span id="quiz-label" data-label="<?php echo get_string('config:quiz', 'quizaccess_edusynch') ?>"></span>
<span id="select-course-label" data-label="<?php echo get_string('config:select_course', 'quizaccess_edusynch') ?>"></span>
<span id="select-quiz-label" data-label="<?php echo get_string('config:select_quiz', 'quizaccess_edusynch') ?>"></span>
<script src="js/add-course.js"></script>

