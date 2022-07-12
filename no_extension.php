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
 * No extension installed view
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../../../config.php');

require_login();

global $SESSION;

$SESSION->edusynch_started   = null;        
$SESSION->edusynch_sessionid = null;        
$SESSION->edusynch_token     = null;   
$SESSION->userid = null;
$SESSION->quizid = null;
?>
<html>
<head>
<title><?php echo get_string('pluginname', 'quizaccess_edusynch') ?></title>
</head>

<body>
</body>
<script type="text/javascript">
window.location.href = '<?php echo "$CFG->wwwroot/$SESSION->edusynch_redirect" ?>';
</script>
</html>
