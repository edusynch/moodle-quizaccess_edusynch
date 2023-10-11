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

            <form action="<?php echo EPROCTORING_URL  ?>?action=settings" method="POST" class="mt-3">
                <?php if (true || $host == 'localhost' || strpos($host, 'edusynch.com') !== FALSE): ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key"><?php echo get_string('config:students_api', 'quizaccess_edusynch') ?>: </label>
                            <input class="form-control" type="text" id="student_api" name="student_api"
                                value="<?php echo $student_api_value ? $student_api_value : 'https://api.edusynch.com' ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key"><?php echo get_string('config:cms_api', 'quizaccess_edusynch') ?>: </label>
                            <input class="form-control" type="text" id="cms_api" name="cms_api"
                                value="<?php echo $cms_api_value ? $cms_api_value : 'https://cmsapi.edusynch.com' ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key"><?php echo get_string('config:events_api', 'quizaccess_edusynch') ?>: </label>
                            <input class="form-control" type="text" id="events_api" name="events_api"
                                value="<?php echo $events_api_value ? $events_api_value : 'https://events.edusynch.com' ?>">
                        </div>
                    </div>
                </div>

                <?php endif; ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key"><?php echo get_string('config:api_key', 'quizaccess_edusynch') ?>:
                            </label>
                            <input class="form-control" type="text" id="api_key" name="api_key"
                                value="<?php echo $api_key_value ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="user"><?php echo get_string('config:user', 'quizaccess_edusynch') ?>: </label>
                            <input class="form-control" type="text" id="user" name="user"
                                value="<?php echo $user_value ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password"><?php echo get_string('config:password', 'quizaccess_edusynch') ?>:
                            </label>
                            <input class="form-control" type="password" id="password" name="password"
                                value="<?php echo $password_value ?>">
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="btn btn-primary"><?php echo get_string('config:save', 'quizaccess_edusynch') ?></button>
            </form>

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

            <hr>
            <h4 class="mt-3"><?php echo get_string('config:import_students', 'quizaccess_edusynch') ?></h4>

            <div class="row">
                <div class="col-md-12">
                    <?php if($total_students > 0): ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> <?php echo get_string('config:total_students', 'quizaccess_edusynch', $total_students) ?>
                    </div>
                    <?php endif; ?>

                    <?php echo get_string('config:import_students_desc', 'quizaccess_edusynch') ?> <a
                        href="<?php echo EPROCTORING_PATH ?>students-import.csv"><?php echo get_string('config:import_students_desc_link', 'quizaccess_edusynch') ?></a>

                    <br>
                    <?php echo $importform->render() ?>
                </div>
            </div>


            <hr>
            <h4 class="mt-3"><?php echo get_string('config:courses_enabled', 'quizaccess_edusynch') ?></h4>
            <form id="quizzes-form" action="<?php echo EPROCTORING_URL  ?>?action=settings&subaction=quizzes"
                method="POST">
                <div class="row my-5">
                    <div class="col">
                        <div class="card">
                            <div class="card-header d-flex">
                                <h4 class="font-weight-bold">
                                    <?php echo get_string('config:manage_courses', 'quizaccess_edusynch') ?></h4>
                                <button type="button" class="btn btn-sm btn-primary ml-auto"
                                    id="btnAddCourse"><?php echo get_string('config:add', 'quizaccess_edusynch') ?> <i
                                        class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="addCourseContainer"></div>
                                <div class="courses">
                                    <h6 class="text-black-50 mb-4 font-weight-bold" style="font-size: 20px;">
                                        <?php echo get_string('config:courses', 'quizaccess_edusynch') ?>
                                        <span class="font-weight-normal" style="font-size: 14px;">
                                            (<?php echo get_string('config:list_courses', 'quizaccess_edusynch') ?>)</span>
                                    </h6>
                                    <?php if (count($quizzes_enabled) > 0): ?>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th><?php echo get_string('config:course', 'quizaccess_edusynch') ?>
                                                    </th>
                                                    <th><?php echo get_string('config:quiz', 'quizaccess_edusynch') ?>
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($quizzes_enabled as $quiz): ?>
                                                <tr id="quiz-<?php echo $quiz['id'] ?>">
                                                    <td><?php echo $quiz['course']; ?></td>
                                                    <td><?php echo $quiz['name']; ?></td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-outline-danger d-block ml-auto btn-delete-quiz"
                                                            data-quiz="<?php echo $quiz['id'] ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <input type="hidden" name="quizzes[]" value="<?php echo $quiz['id'] ?>">
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="empty-courses py-5">
                                    <img class="d-block mx-auto mb-1" src="images/empty-courses.svg"
                                        alt="empty-courses">
                                    <p class="text-center text-black-50">
                                        <?php echo get_string('config:no_courses', 'quizaccess_edusynch') ?></p>
                                </div>
                                <?php endif; ?>

                                <button type="submit"
                                    class="btn btn-primary"><?php echo get_string('config:save', 'quizaccess_edusynch') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
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

