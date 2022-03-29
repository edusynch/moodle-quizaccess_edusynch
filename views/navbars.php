<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */
?>
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link <?php echo $action == 'settings' ? 'active' : '' ?>" href="<?php echo $CFG->wwwroot ?>/mod/quiz/accessrule/edusyncheproctoring/index.php?action=settings">Settings</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo in_array($action, ['session','sessions']) ? 'active' : '' ?>" href="<?php echo $CFG->wwwroot ?>/mod/quiz/accessrule/edusyncheproctoring/index.php?action=sessions">Sessions</a>
  </li>
</ul>