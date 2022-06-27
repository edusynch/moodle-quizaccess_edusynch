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
 * Start quiz page
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../../../config.php');
require_login();

global $PAGE, $DB, $SESSION;

$userid = $SESSION->userid;
$quizid = $SESSION->quizid;

$attemptid = required_param('attemptid', PARAM_INT);
$cmid      = required_param('cmid', PARAM_INT);
$page      = required_param('page', PARAM_INT);
?>
<html>
    <head>
        <title>E-Proctoring check</title>
    </head>

    <body>
    <?php 
        $session_details = \quizaccess_edusynch\session::create($userid, $quizid);

        // Student session
        if($session_details['success']):
            $SESSION->edusynch_started   = true;        
            $SESSION->edusynch_sessionid = $session_details['session_id'];        
            $SESSION->edusynch_token     = $session_details['token'];        
            $start_event = \quizaccess_edusynch\session::create_event_for($session_details['token'], $session_details['session_id'], 'START_SIMULATION');

            $js = "$('button').trigger('click');";
        ?>    
        <form action="<?php echo "$CFG->wwwroot/$SESSION->edusynch_redirect" ?>" data-proctoring="form" method="GET">
            <input type="hidden" name="attempt" value="<?php echo $attemptid ?>">
            <input type="hidden" name="cmid" value="<?php echo $cmid ?>">
            <input type="hidden" name="page" value="<?php echo $page ?>">
            <button data-proctoring="start" data-id="<?php echo $session_details['session_id'] ?>" data-token="<?php echo $session_details['token'] ?>" type="submit" style="display: none"></button>
        </form>      
    <?php else: 
        $SESSION->edusynch_started   = true;     
        $js = " window.location.href = '$CFG->wwwroot/$SESSION->edusynch_redirect';";           
    endif; ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>   
        <script type="text/javascript">
        setTimeout(function() {
            <?php echo $js; ?>
        }, 1000);
    </script>        
    
    </body>
</html>
