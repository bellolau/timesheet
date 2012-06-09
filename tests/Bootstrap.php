<?php

error_reporting(E_ALL);

define('DOCUMENT_ROOT', realpath(dirname(__FILE__) . "/.."));
define('APPLICATION_ENV', 'testing');

require_once DOCUMENT_ROOT . '/public/index.php';
