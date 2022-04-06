<div class="container">
    <h4 class="mt-3">Sessions list</h4>
    <div class="tab-content">

        <?php if (count($sessions_list) > 0): ?>
        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item <?php echo is_null($prev_page) ? 'disabled' : '' ?>">
                    <a class="page-link"
                        <?php echo is_null($prev_page) ? '' : 'href="'. EPROCTORING_URL . '?action=sessions&page=' . $prev_page .'"' ?>>Previous</a>
                </li>
                <?php for($page = 1; $page <= $total_pages; $page++): ?>
                <li class="page-item <?php echo $page == $current_page ? 'active' : '' ?>"><a class="page-link"
                        href="<?php echo EPROCTORING_URL ?>?action=sessions&page=<?php echo $page ?>"><?php echo $page ?></a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $last_page ? 'disabled' : '' ?>">
                    <a class="page-link"
                        <?php echo $last_page ? '' : 'href="'. EPROCTORING_URL . '?action=sessions&page=' . $next_page .'"' ?>>Next</a>
                </li>
            </ul>
        </nav>

        <div class="tab-pane fade show active" id="nav-sessions" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Date</th>
                        <th>Incident Level</th>
                        <th class="text-center">Actions</th>
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
                                    class="badge badge-<?php echo $session['incident_level'] == 'Low' ? 'success' : ($session['incident_level'] == 'Medium' ? 'warning' : 'danger') ?> session-status"><?php echo $session['incident_level']  ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo EPROCTORING_URL . '/?action=session&session_id=' . $session['id'] ?>"
                                    class="btn btn-primary"><i class="fa fa-history"></i> Log</a>
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
                        <?php echo is_null($prev_page) ? '' : 'href="'. EPROCTORING_URL . '?action=sessions&page=' . $prev_page .'"' ?>>Previous</a>
                </li>
                <?php for($page = 1; $page <= $total_pages; $page++): ?>
                <li class="page-item <?php echo $page == $current_page ? 'active' : '' ?>"><a class="page-link"
                        href="<?php echo EPROCTORING_URL ?>?action=sessions&page=<?php echo $page ?>"><?php echo $page ?></a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $last_page ? 'disabled' : '' ?>">
                    <a class="page-link"
                        <?php echo $last_page ? '' : 'href="'. EPROCTORING_URL . '?action=sessions&page=' . $next_page .'"' ?>>Next</a>
                </li>
            </ul>
        </nav>

        <?php else: ?>
        <div class="alert alert-info"><i class="fa fa-info-circle"></i> There are no sessions registered</div>
        <?php endif; ?>

    </div>
</div>