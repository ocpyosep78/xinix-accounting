<?php
$path_to_root = '..';
include_once($path_to_root . '/includes/session.inc');
include_once($path_to_root . '/themes/'.user_theme().'/mobile_helper.php');

Controller::execute();
?>
