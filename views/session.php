<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */
?>
<div class="container">
    <h4 class="mb-5">Session details - #<?php echo $session_details['id'] ?></h4>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body py-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4 d-flex">
                                <img src="<?php echo $session_details['student']['avatar']["thumb"]["url"] ?>" alt="avatar" width="48" height="48"
                                    class="rounded-circle">
                                <div class="pl-3">
                                    <p class="text-primary font-weight-bold mb-0"><?php echo $session_details['student']['name'] ?></p>
                                    <p class="text-dark mb-0"><small><?php echo $session_details['student']['email'] ?></small></p>
                                </div>
                            </div>
                            <div class="col-sm-8 d-flex text-dark">
                                <div class="pr-5">
                                    <p class="mb-0">Start Time</p>
                                    <p class="mb-0 font-weight-bold"> <?php echo date('H:i', strtotime($session_details['start_time'])) ?></p>
                                </div>
                                <div class="px-5 border-left">
                                    <p class="mb-0">End Time</p>
                                    <p class="mb-0 font-weight-bold"><?php echo $session_details['end_time'] ? date('Y-m-d H:i:s', strtotime($session_details['end_time'])) : '-' ?></p>
                                </div>
                                <div class="pl-5 border-left">
                                    <p class="mb-0">Completed</p>
                                    <p class="mb-0 font-weight-bold"><?php echo $session_details['completed'] ? 'Yes' : 'No' ?></p>
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
                    <h4 class="font-weight-bold">Log</h4>
                </div>
                <div class="card-body">
                    <?php if (count($events)): ?>
                    <nav>
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php echo is_null($prev_page) ? 'disabled' : '' ?>">
                                <a class="page-link" <?php echo is_null($prev_page) ? '' : 'href="'. EPROCTORING_URL . '?action=session&session_id='. $session_id .'&courseid='.$courseid.'&quizid='.$quizid.'&events_page=' . $prev_page .'"' ?>>Previous</a>
                            </li>
                            <?php for($page = 1; $page <= $total_pages; $page++): ?>
                            <li class="page-item <?php echo $page == $events_page ? 'active' : '' ?>"><a class="page-link" href="<?php echo EPROCTORING_URL ?>?action=session&session_id=<?php echo $session_id?>&courseid=<?php echo $courseid ?>.'&quizid=<?php echo $quizid ?>'&events_page=<?php echo $page ?>"><?php echo $page ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $last_page ? 'disabled' : '' ?>">
                                <a class="page-link" <?php echo $last_page ? '' : 'href="'. EPROCTORING_URL . '?action=session&session_id='. $session_id .'&courseid='.$courseid.'&quizid='.$quizid.'&events_page=' . $next_page .'"' ?>>Next</a>
                            </li>
                        </ul>
                    </nav>        
                                   
                    <div class="d-flex mb-3">
                        <p class="mb-0 font-weight-bold mr-5">Hour</p>
                        <p class="mb-0 font-weight-bold">Type</p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <?php foreach($events as $event): ?> 
                        <li class="list-group-item p-0 py-3 d-flex border-bottom">
                            <p class="mb-0 mr-5"><?php echo date('H:i', strtotime($event['date'])) ?></p>
                            <p class="mb-0"><?php echo get_string_manager()->string_exists('EVENT_' . $event['type'], 'quizaccess_edusyncheproctoring') ? get_string('EVENT_' . $event['type'], 'quizaccess_edusyncheproctoring') : $event['type'] ?></p>
                        </li>
                        <?php endforeach; ?> 
                    </ul>

                    <nav class="mt-3">
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php echo is_null($prev_page) ? 'disabled' : '' ?>">
                                <a class="page-link" <?php echo is_null($prev_page) ? '' : 'href="'. EPROCTORING_URL . '?action=session&session_id='. $session_id .'&courseid='.$courseid.'&quizid='.$quizid.'&events_page=' . $prev_page .'"' ?>>Previous</a>
                            </li>
                            <?php for($page = 1; $page <= $total_pages; $page++): ?>
                            <li class="page-item <?php echo $page == $events_page ? 'active' : '' ?>"><a class="page-link" href="<?php echo EPROCTORING_URL ?>?action=session&session_id=<?php echo $session_id?>&courseid=<?php echo $courseid ?>.'&quizid=<?php echo $quizid ?>'&events_page=<?php echo $page ?>"><?php echo $page ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $last_page ? 'disabled' : '' ?>">
                                <a class="page-link" <?php echo $last_page ? '' : 'href="'. EPROCTORING_URL . '?action=session&session_id='. $session_id .'&courseid='.$courseid.'&quizid='.$quizid.'&events_page=' . $next_page .'"' ?>>Next</a>
                            </li>
                        </ul>
                    </nav> 
                    <?php else: ?>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> There are no events for this session</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-weight-bold">Screen Archive</h4>
                </div>
                <div class="card-body">
                    <?php if (count($photos)): ?>
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php for($i = 0; $i < count($photos); $i++): ?> 
                            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i ?>" <?php echo $i == 0 ? 'class="active"' : ''?>></li>
                            <?php endfor; ?> 
                        </ol>
                        <div class="carousel-inner">
                            <?php for($i = 0; $i < count($photos); $i++): ?> 
                            <div class="carousel-item <?php echo $i == 0 ? 'active' : '' ?>">
                                <img src="<?php echo $photos[$i]['photo']['url'] ?>"
                                    class="d-block w-100" alt="<?php echo $photos[$i]['photo_type'] ?>">
                            </div>
                            <?php endfor; ?>                             
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </button>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> There are no screens for this session</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
</script>