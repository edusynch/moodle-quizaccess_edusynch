<?php 
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */
require_once(__DIR__ . '/../../../../config.php');

require_login();

global $SESSION;

$SESSION->edusyncheproctoring_started   = null;        
$SESSION->edusyncheproctoring_sessionid = null;        
$SESSION->edusyncheproctoring_token     = null;   
$SESSION->userid = null;
$SESSION->quizid = null;
?>
<html>
<head>
<title>E-Procotring check</title>
</head>

<body>
</body>
<script type="text/javascript">
window.location.href = '<?php echo "$CFG->wwwroot/$SESSION->edusyncheproctoring_redirect" ?>';
</script>
</html>
