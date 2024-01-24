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
 * LTI view
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

?>
<link href="css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="container">
    <div class="row mt-3">
        <iframe class="row mt-3" style="width: 100%; height: 700px" src="<?php echo $lti_url_value ?>/launch?&user_id=<?php echo $user_id ?>&roles=Administrator&launch_presentation_return_url=<?php echo $domain ?>&custom_canvas_user_id=<?php echo $user_id ?>&tool_consumer_info_product_family_code=moodle"></iframe>
    </div>
</div>
<script src="js/session-view.js"></script>
<script src="js/bootstrap4-toggle.min.js"></script>

