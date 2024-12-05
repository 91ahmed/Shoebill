<?php
	ob_start();

	require('config.php');
	require('vendor\autoload.php');
	require('autoload.php');
	require('core\helpers\app.php');
	require('core\helpers\generator.php');
	require('core\helpers\sanitizer.php');
	require('app\routes.php');

	ob_end_flush();
?>