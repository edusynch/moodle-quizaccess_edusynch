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
 * Session view
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

?>
<div class="container">
    <h4 class="mt-5"><?php echo get_string('session_report:session_details', 'quizaccess_edusynch') ?> -
        #<?php echo $session_details['id'] ?></h4>
    <?php if(isset($quiz_data)): ?>
    <small> 
        <?php echo $quiz_data->name ?>
        &nbsp; <a href="<?php echo EPROCTORING_URL ?>?action=sessions&courseid=<?php echo $courseid ?>&quizid=<?php echo $quizid ?>"><i class="fa fa-chevron-circle-left"></i> <?php echo get_string('session_report:back_to_list', 'quizaccess_edusynch') ?></a>
     </small>
    <?php endif; ?>
    <?php if(isset($success_message)): ?>
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="alert alert-success"><?php echo $success_message ?></div>
            </div>
        </div>
    <?php endif; ?>
    <div class="mt-3 row">
        <div class="col">
            <div class="card">
                <div class="card-body py-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4 d-flex">
                                <?php echo $useravatar ?>
                                <div class="pl-3">
                                    <p class="text-primary font-weight-bold mb-0">
                                        <?php echo $session_details['student']['name'] ?></p>
                                    <p class="text-dark mb-0">
                                        <small><?php echo $session_details['student']['email'] ?></small>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-8 d-flex text-dark">
                                <div class="pr-5">
                                    <p class="mb-0">
                                        <?php echo get_string('session_report:start_time', 'quizaccess_edusynch') ?></p>
                                    <p class="mb-0 font-weight-bold">
                                        <?php echo date('H:i', strtotime($session_details['start_time'])) ?></p>
                                </div>
                                <div class="px-5 border-left">
                                    <p class="mb-0">
                                        <?php echo get_string('session_report:end_time', 'quizaccess_edusynch') ?></p>
                                    <p class="mb-0 font-weight-bold">
                                        <?php echo $session_details['end_time'] ? date('Y-m-d H:i:s', strtotime($session_details['end_time'])) : '-' ?>
                                    </p>
                                </div>
                                <div class="pl-5 border-left">
                                    <p class="mb-0">
                                        <?php echo get_string('session_report:completed', 'quizaccess_edusynch') ?></p>
                                    <p class="mb-0 font-weight-bold">
                                        <?php echo $session_details['completed'] ? get_string('misc:yes', 'quizaccess_edusynch') : get_string('misc:no', 'quizaccess_edusynch') ?>
                                    </p>
                                </div>
                                <div class="pl-5">
                                    <p class="mb-0">
                                        <?php echo get_string('sessions_list:incident_level', 'quizaccess_edusynch') ?></p>
                                    <p class="mb-0 font-weight-bold">
                                        <form class="form-inline" method="POST" action="<?php echo EPROCTORING_URL ?>?action=session&session_id=<?php echo $session_id?>&courseid=<?php echo $courseid ?>&quizid=<?php echo $quizid ?>&events_page=1&subaction=changeincident">
                                            <div class="input-group">
                                                <select name="incident_level" class="form-control" id="incident-level-change" rel="<?php echo $session_details['id'] ?>">
                                                    <option value="Low" <?php echo $session_details['incident_level'] == 'Low' ? 'selected' : ''?>><?php echo get_string('session_report:incident:low', 'quizaccess_edusynch')  ?></option>
                                                    <option value="Medium" <?php echo $session_details['incident_level'] == 'Medium' ? 'selected' : ''?>><?php echo get_string('session_report:incident:medium', 'quizaccess_edusynch')  ?></option>
                                                    <option value="High" <?php echo $session_details['incident_level'] == 'High' ? 'selected' : ''?>><?php echo get_string('session_report:incident:high', 'quizaccess_edusynch')  ?></option>
                                                </select>
                                                &nbsp;
                                                <button class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
                                            </div>
                                        </form>
                                    </p>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-weight-bold"><?php echo get_string('session_report:log', 'quizaccess_edusynch') ?>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (count($events)): ?>
                    <nav>
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php echo is_null($prev_page) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    <?php echo is_null($prev_page) ? '' : 'href="'. EPROCTORING_URL . '?action=session&session_id='. $session_id .'&courseid='.$courseid.'&quizid='.$quizid.'&events_page=' . $prev_page .'"' ?>><?php echo get_string('misc:btn_prev', 'quizaccess_edusynch') ?></a>
                            </li>
                            <?php for($page = 1; $page <= $total_pages; $page++): ?>
                            <li class="page-item <?php echo $page == $events_page ? 'active' : '' ?>"><a
                                    class="page-link"
                                    href="<?php echo EPROCTORING_URL ?>?action=session&session_id=<?php echo $session_id?>&courseid=<?php echo $courseid ?>.'&quizid=<?php echo $quizid ?>'&events_page=<?php echo $page ?>"><?php echo $page ?></a>
                            </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $last_page ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    <?php echo $last_page ? '' : 'href="'. EPROCTORING_URL . '?action=session&session_id='. $session_id .'&courseid='.$courseid.'&quizid='.$quizid.'&events_page=' . $next_page .'"' ?>><?php echo get_string('misc:btn_next', 'quizaccess_edusynch') ?></a>
                            </li>
                        </ul>
                    </nav>

                    <div class="d-flex mb-3">
                        <p class="mb-0 font-weight-bold mr-5">
                            <?php echo get_string('session_report:hour', 'quizaccess_edusynch') ?></p>
                        <p class="mb-0 font-weight-bold">
                            <?php echo get_string('session_report:type', 'quizaccess_edusynch') ?></p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <?php foreach($events as $event): ?>
                        <li class="list-group-item p-0 py-3 d-flex border-bottom">
                            <p class="mb-0 mr-5"><?php echo date('H:i', strtotime($event['date'])) ?></p>
                            <p class="mb-0">
                                <?php echo get_string_manager()->string_exists('EVENT_' . $event['type'], 'quizaccess_edusynch') ? get_string('EVENT_' . $event['type'], 'quizaccess_edusynch') : $event['type'] ?>
                            </p>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <nav class="mt-3">
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php echo is_null($prev_page) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    <?php echo is_null($prev_page) ? '' : 'href="'. EPROCTORING_URL . '?action=session&session_id='. $session_id .'&courseid='.$courseid.'&quizid='.$quizid.'&events_page=' . $prev_page .'"' ?>><?php echo get_string('misc:btn_prev', 'quizaccess_edusynch') ?></a>
                            </li>
                            <?php for($page = 1; $page <= $total_pages; $page++): ?>
                            <li class="page-item <?php echo $page == $events_page ? 'active' : '' ?>"><a
                                    class="page-link"
                                    href="<?php echo EPROCTORING_URL ?>?action=session&session_id=<?php echo $session_id?>&courseid=<?php echo $courseid ?>.'&quizid=<?php echo $quizid ?>'&events_page=<?php echo $page ?>"><?php echo $page ?></a>
                            </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $last_page ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    <?php echo $last_page ? '' : 'href="'. EPROCTORING_URL . '?action=session&session_id='. $session_id .'&courseid='.$courseid.'&quizid='.$quizid.'&events_page=' . $next_page .'"' ?>><?php echo get_string('misc:btn_next', 'quizaccess_edusynch') ?></a>
                            </li>
                        </ul>
                    </nav>
                    <?php else: ?>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i>
                        <?php echo get_string('session_report:no_logs', 'quizaccess_edusynch') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-weight-bold">
                        <?php echo get_string('session_report:screen_archive', 'quizaccess_edusynch') ?></h4>
                </div>
                <div class="card-body">
                    <?php if (count($photos)): ?>
                    <div id="carouselPhotoIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php for($i = 0; $i < count($photos); $i++): ?>
                            <li data-target="#carouselPhotoIndicators" data-slide-to="<?php echo $i ?>"
                                <?php echo $i == 0 ? 'class="active"' : ''?>></li>
                            <?php endfor; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php for($i = 0; $i < count($photos); $i++): ?>
                            <div class="carousel-item <?php echo $i == 0 ? 'active' : '' ?>">
                                <img src="<?php echo $photos[$i]['photo']['url'] ?>" class="d-block w-100"
                                    alt="<?php echo $photos[$i]['photo_type'] ?>">
                            </div>
                            <?php endfor; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselPhotoIndicators"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span
                                class="sr-only"><?php echo get_string('misc:btn_prev', 'quizaccess_edusynch') ?></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselPhotoIndicators"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span
                                class="sr-only"><?php echo get_string('misc:btn_next', 'quizaccess_edusynch') ?></span>
                        </button>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i>
                        <?php echo get_string('session_report:no_screens', 'quizaccess_edusynch') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-5">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-weight-bold">
                        <?php echo get_string('session_report:video_archive', 'quizaccess_edusynch') ?></h4>
                </div>
                <div class="card-body">
                    <?php if (count($videos)): ?>
                    <div id="carouselVideoIndicators" class="carousel slide">
                        <ol class="carousel-indicators">
                            <?php for($i = 0; $i < count($videos); $i++): ?>
                            <li data-target="#carouselVideoIndicators" data-slide-to="<?php echo $i ?>"
                                <?php echo $i == 0 ? 'class="active"' : ''?>></li>
                            <?php endfor; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php for($i = 0; $i < count($videos); $i++): ?>
                            <div class="carousel-item <?php echo $i == 0 ? 'active' : '' ?>">
                                <video class="d-block w-100" autoplay="" muted="" controls="" height="712">
                                    <source src="<?php echo $videos[$i]['video']['url'] ?>" type="video/mp4" />
                                </video>
                            </div>
                            <?php endfor; ?>                        
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselVideoIndicators"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only"><?php echo get_string('misc:btn_prev', 'quizaccess_edusynch') ?></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselVideoIndicators"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only"><?php echo get_string('misc:btn_next', 'quizaccess_edusynch') ?></span>
                        </button>
                    </div>
                    <?php else: ?>
                        <?php echo get_string('session_report:no_videos', 'quizaccess_edusynch') ?></div>
                    <?php endif; ?>
                
                </div>
            </div>
        </div>
    </div>
</div>
