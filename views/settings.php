<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<div class="container">
    <?php 
$host = $PAGE->url->get_host();
?>

    <div class="tab-content">

        <?php if ($success): ?>
        <div class="alert alert-success">Success!</div>
        <?php endif; ?>

        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel">
            <h4 class="mt-3">Keys</h4>

            <form action="<?php echo EPROCTORING_URL  ?>?action=settings" method="POST" class="mt-3">
                <?php if ($host == 'localhost' || strpos($host, 'edusynch.com') !== FALSE): ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key">Student API: </label>
                            <input class="form-control" type="text" id="student_api" name="student_api"
                                value="<?php echo $student_api_value ? $student_api_value : 'https://api.edusynch.com' ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key">CMS API: </label>
                            <input class="form-control" type="text" id="cms_api" name="cms_api"
                                value="<?php echo $cms_api_value ? $cms_api_value : 'https://cmsapi.edusynch.com' ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key">Events API: </label>
                            <input class="form-control" type="text" id="events_api" name="events_api"
                                value="<?php echo $events_api_value ? $events_api_value : 'https://events.edusynch.com' ?>">
                        </div>
                    </div>
                </div>

                <?php endif; ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key">API Key: </label>
                            <input class="form-control" type="text" id="api_key" name="api_key"
                                value="<?php echo $api_key_value ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="user">User: </label>
                            <input class="form-control" type="text" id="user" name="user"
                                value="<?php echo $user_value ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password">Password: </label>
                            <input class="form-control" type="password" id="password" name="password"
                                value="<?php echo $password_value ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>

            <hr>
            <h4 class="mt-3">Import students</h4>

            <div class="row">
                <div class="col-md-12">
                    Use the box below to import a .CSV file with your students data, like <a
                        href="<?php echo EPROCTORING_PATH ?>students-import.csv">this example</a>

                    <br>
                    <?php echo $importform->render() ?>
                </div>
            </div>


            <hr>
            <h4 class="mt-3">Courses enabled</h4>
            <form id="quizzes-form" action="<?php echo EPROCTORING_URL  ?>?action=settings&subaction=quizzes" method="POST">
                <div class="row my-5">
                    <div class="col">
                        <div class="card">
                            <div class="card-header d-flex">
                                <h4 class="font-weight-bold">Manage courses</h4>
                                <button type="button" class="btn btn-sm btn-primary ml-auto" id="btnAddCourse">Add <i
                                        class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="addCourseContainer"></div>
                                <div class="courses">
                                    <h6 class="text-black-50 mb-4 font-weight-bold" style="font-size: 20px;">
                                        Courses
                                        <span class="font-weight-normal" style="font-size: 14px;"> (List)</span>
                                    </h6>
                                    <?php if (count($quizzes_enabled) > 0): ?>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Course</th>
                                                    <th>Quiz</th>
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
                                                            class="btn btn-outline-danger d-block ml-auto btn-delete-quiz" data-quiz="<?php echo $quiz['id'] ?>">
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
                                    <img class="d-block mx-auto mb-1" src="images/empty-courses.svg" alt="empty-courses">
                                    <p class="text-center text-black-50">Please, add a course!</p>
                                </div>
                                <?php endif; ?>

                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>

    </div>
</div>

<script src="js/add-course.js"></script>