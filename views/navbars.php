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
 * Navbars view
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
?>
<?php if (is_siteadmin()): ?>
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link <?php echo $action == 'settings' ? 'active' : '' ?>" href="<?php echo $CFG->wwwroot ?>/mod/quiz/accessrule/edusynch/index.php?action=settings"><?php echo get_string('navbar_menu:settings', 'quizaccess_edusynch') ?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo in_array($action, ['session','sessions']) ? 'active' : '' ?>" href="<?php echo $CFG->wwwroot ?>/mod/quiz/accessrule/edusynch/index.php?action=sessions"><?php echo get_string('navbar_menu:sessions', 'quizaccess_edusynch') ?></a>
  </li>
</ul>
<?php endif; ?>
