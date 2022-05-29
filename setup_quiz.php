<?php 
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
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
<title>E-Procotring check</title>
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
