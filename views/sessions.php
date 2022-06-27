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
 * Sessions list
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
?>
<div class="container">
    <h4 class="mt-3"><?php echo get_string('sessions_list:title', 'quizaccess_edusynch') ?></h4>
    <?php if(isset($quiz_data)): ?>
    <small><?php echo $quiz_data->name ?></small>
    <?php endif; ?>
    <div class="mt-3 tab-content">

        <?php if ($quiz_selected): ?>
        <form method="GET">
            <input type="hidden" name="action" value="sessions">
            <input type="hidden" name="quizid" value="<?php echo $quizid ?>">
            <input type="hidden" name="courseid" value="<?php echo $courseid ?>">
            <input type="hidden" name="page" value="<?php echo $current_page ?>">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <input placeholder="Search" type="text" class="form-control" name="search" value="<?php echo $search ?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input placeholder="From" type="date" value="<?php echo $start_date; ?>" class="form-control"
                            name="start_date">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input placeholder="From" type="date" value="<?php echo $end_date; ?>" class="form-control"
                            name="end_date">
                    </div>
                </div>

                <div class="col-md-1 text-right">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <?php if (isset($sessions_list) && count($sessions_list) > 0): ?>

        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item <?php echo is_null($prev_page) ? 'disabled' : '' ?>">
                    <a class="page-link"
                        <?php echo is_null($prev_page) ? '' : 'href="'. EPROCTORING_URL . '?action=sessions&courseid='.$courseid.'&quizid='.$quizid.'&page=' . $prev_page .'"' ?>><?php echo get_string('misc:btn_prev', 'quizaccess_edusynch') ?></a>
                </li>
                <?php for($page = 1; $page <= $total_pages; $page++): ?>
                <li class="page-item <?php echo $page == $current_page ? 'active' : '' ?>"><a class="page-link"
                        href="<?php echo EPROCTORING_URL ?>?action=sessions&courseid='.$courseid.'&quizid='.$quizid.'&page=<?php echo $page ?>"><?php echo $page ?></a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $last_page ? 'disabled' : '' ?>">
                    <a class="page-link"
                        <?php echo $last_page ? '' : 'href="'. EPROCTORING_URL . '?action=sessions&courseid='.$courseid.'&quizid='.$quizid.'&page=' . $next_page .'"' ?>><?php echo get_string('misc:btn_next', 'quizaccess_edusynch') ?></a>
                </li>
            </ul>
        </nav>

        <div class="tab-pane fade show active" id="nav-sessions" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <th><?php echo get_string('sessions_list:id', 'quizaccess_edusynch') ?></th>
                        <th><?php echo get_string('sessions_list:student', 'quizaccess_edusynch') ?></th>
                        <th><?php echo get_string('sessions_list:date', 'quizaccess_edusynch') ?></th>
                        <th><?php echo get_string('sessions_list:incident_level', 'quizaccess_edusynch') ?></th>
                        <th class="text-center"><?php echo get_string('sessions_list:actions', 'quizaccess_edusynch') ?>
                        </th>
                    </thead>
                    <tbody>
                        <?php foreach($sessions_list as $session): ?>
                        <tr>
                            <td class="align-middle text-dark"><?php echo $session['id'] ?></td>
                            <td class="align-middle font-weight-bold text-dark text-truncate">
                                <?php echo $session['student']['name'] ?>
                                &lt;<?php echo $session['student']['email'] ?>&gt;</td>
                            <td class="align-middle text-dark">
                                <?php echo date('Y-m-d H:i', strtotime($session['start_time'])) ?></td>
                            <td class="align-middle text-dark text-center lead">
                                <span
                                    class="badge badge-<?php echo $session['incident_level'] == 'Low' ? 'success' : ($session['incident_level'] == 'Medium' ? 'warning' : 'danger') ?> session-status"><?php echo get_string('session_report:incident:' .strtolower($session['incident_level']), 'quizaccess_edusynch')  ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo EPROCTORING_URL . '?action=session&session_id=' . $session['id'] . '&courseid='.$courseid.'&quizid='.$quizid ?>"
                                    class="btn btn-primary"><i class="fa fa-history"></i>
                                    <?php echo get_string('session_report:log', 'quizaccess_edusynch') ?></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item <?php echo is_null($prev_page) ? 'disabled' : '' ?>">
                    <a class="page-link"
                        <?php echo is_null($prev_page) ? '' : 'href="'. EPROCTORING_URL . '?action=sessions&courseid='.$courseid.'&quizid='.$quizid.'&page=' . $prev_page .'"' ?>><?php echo get_string('misc:btn_prev', 'quizaccess_edusynch') ?></a>
                </li>
                <?php for($page = 1; $page <= $total_pages; $page++): ?>
                <li class="page-item <?php echo $page == $current_page ? 'active' : '' ?>"><a class="page-link"
                        href="<?php echo EPROCTORING_URL ?>?action=sessions&courseid='.$courseid.'&quizid='.$quizid.'&page=<?php echo $page ?>"><?php echo $page ?></a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $last_page ? 'disabled' : '' ?>">
                    <a class="page-link"
                        <?php echo $last_page ? '' : 'href="'. EPROCTORING_URL . '?action=sessions&courseid='.$courseid.'&quizid='.$quizid.'&page=' . $next_page .'"' ?>><?php echo get_string('misc:btn_next', 'quizaccess_edusynch') ?></a>
                </li>
            </ul>
        </nav>

        <?php else: ?>
        <div class="alert alert-info"><i class="fa fa-info-circle"></i>
            <?php echo get_string('sessions_list:no_sessions', 'quizaccess_edusynch') ?></div>
        <?php endif; ?>

        <?php else: ?>
        <?php if(count($quizzes_enabled) > 0): ?>
        <div class="alert alert-info"><i class="fa fa-info-circle"></i>
            <?php echo get_string('sessions_list:select_course_and_quiz', 'quizaccess_edusynch') ?></div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo get_string('config:course', 'quizaccess_edusynch') ?>
                        </th>
                        <th><?php echo get_string('config:quiz', 'quizaccess_edusynch') ?>
                        </th>
                        <th><?php echo get_string('sessions_list:total_number', 'quizaccess_edusynch') ?></th>
                        <th width="15%"><?php echo get_string('sessions_list:view_reports', 'quizaccess_edusynch') ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($quizzes_enabled as $quiz): ?>
                    <tr id="quiz-<?php echo $quiz['id'] ?>">
                        <td><?php echo $quiz['course']; ?></td>
                        <td><?php echo $quiz['name']; ?></td>
                        <td><?php echo $quiz['total_sessions']; ?></td>
                        <td>
                            <a href="<?php echo EPROCTORING_URL . '?action=sessions&courseid='.$quiz['courseid'].'&quizid='.$quiz['id']?>"
                                class="btn btn-outline-primary d-block" data-quiz="<?php echo $quiz['id'] ?>">
                                <i class="fa fa-file-text-o"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info"><i class="fa fa-info-circle"></i>
            <?php echo get_string('sessions_list:no_quiz_enabled', 'quizaccess_edusynch') ?>
        </div>
        <?php endif; ?>

        <?php endif; ?>
    </div>
</div>