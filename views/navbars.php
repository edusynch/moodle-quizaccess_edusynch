<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */
?>
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link <?php echo $action == 'settings' ? 'active' : '' ?>" href="<?php echo $CFG->wwwroot ?>/mod/quiz/accessrule/edusynch/index.php?action=settings"><?php get_string('navbar_menu:settings', 'quizaccess_edusynch') ?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo in_array($action, ['session','sessions']) ? 'active' : '' ?>" href="<?php echo $CFG->wwwroot ?>/mod/quiz/accessrule/edusynch/index.php?action=sessions"><?php get_string('navbar_menu:sessions', 'quizaccess_edusynch') ?></a>
  </li>
</ul>