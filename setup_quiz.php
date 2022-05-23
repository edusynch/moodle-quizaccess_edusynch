<?php 
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */
require_once(__DIR__ . '/../../../../config.php');

global $CFG;

require_login();
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
        window.location.href = '<?php echo $CFG->wwwroot ?>/mod/quiz/accessrule/edusyncheproctoring/start_quiz.php';
    }
}, 500);    
</script>
</html>
