<?php

session_start();

define('AppName', 'SOP');

define('START_INDEX', true);
define('PATH_COMPONENT', './components');
define('PATH_CONTROLLER', './controllers');
define('PATH_TEMPLATE', './templates');
define('PATH_PARTIAL', PATH_TEMPLATE . '/partials');

include './connect.php';
include './functions.php';

define('USER', null);

// print_r( $_SERVER['REQUEST_URI'] );

include './config.php';
