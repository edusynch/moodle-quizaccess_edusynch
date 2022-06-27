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
 * Setup quiz page
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../../../config.php');
require_login();

global $CFG;

$attemptid = required_param('attemptid', PARAM_INT);
$cmid      = required_param('cmid', PARAM_INT);
$page      = required_param('page', PARAM_INT);
?>
<html>
<head>
<title>E-Proctoring check</title>
</head>

<body>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>   
<script type="text/javascript">
setTimeout(function() {
    var body = $('body');
    if (body.attr('data-eproctoring') != 'true') {                
        window.location.href = 'https://edusynch.com/install/extension';
    } else {
        window.location.href = '<?php echo $CFG->wwwroot . '/mod/quiz/accessrule/edusynch/start_quiz.php?attemptid=' . $attemptid . '&cmid=' . $cmid . '&page=' . $page ?>';
    }
}, 500);    
</script>
</html>
