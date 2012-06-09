<?php

// TODO: remove
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once 'init.php';

// Launch
$application->bootstrap();
if (APPLICATION_ENV !== 'testing') {
	$application->run();
}
