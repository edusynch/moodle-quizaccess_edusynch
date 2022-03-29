<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

function quizaccess_edusyncheproctoring_render_navbar_output() {
    global $PAGE, $CFG;

    $context = context_system::instance();

    if (!is_siteadmin()) {
        return '';
    }

    $title = "EduSynch E-Proctoring";
    $url = new \moodle_url('/mod/quiz/accessrule/edusyncheproctoring/index.php');
    $icon = new \pix_icon('i/hide', '');
    $node = navigation_node::create($title, $url, navigation_node::TYPE_CUSTOM, null, null, $icon);
    $PAGE->flatnav->add($node);

    return '';
}

function quizaccess_edusyncheproctoring_before_footer()
{

}
