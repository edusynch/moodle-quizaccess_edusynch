<nav>
    <ul class="pagination justify-content-end">
        <li class="page-item <?php echo is_null($prev_page) ? 'disabled' : '' ?>">
            <a class="page-link"
                <?php echo is_null($prev_page) ? '' : 'href="'. EPROCTORING_URL . '?action=sessions&courseid='.$courseid.'&quizid='.$quizid.'&page=' . $prev_page .'"' ?>><?php echo get_string('misc:btn_prev', 'quizaccess_edusynch') ?></a>
        </li>

        <form method="GET" action="" class="form-pagination form-inline">
            <input type="hidden" name="action" value="sessions">
            <input type="hidden" name="courseid" value="<?php echo $courseid ?>">
            <input type="hidden" name="quizid" value="<?php echo $quizid ?>">

            <select name="page" class="form-control ml-1 mr-1" onChange="this.parentNode.submit();">
            <?php for($page = 1; $page <= $total_pages; $page++): ?>        
                <option value="<?php echo $page ?>" <?php echo $current_page == $page ? ' selected' : '' ?>><?php echo $page ?></option>
            <?php endfor; ?>

            </select> 
            <span><?php echo get_string('misc:label_total_pages', 'quizaccess_edusynch', $total_pages) ?></span>
        </form>


        <li class="page-item <?php echo $last_page ? 'disabled' : '' ?>">
            <a class="page-link"
                <?php echo $last_page ? '' : 'href="'. EPROCTORING_URL . '?action=sessions&courseid='.$courseid.'&quizid='.$quizid.'&page=' . $next_page .'"' ?>><?php echo get_string('misc:btn_next', 'quizaccess_edusynch') ?></a>
        </li>
    </ul>
</nav>