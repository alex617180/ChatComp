<?php
// Start a Session
if( !session_id() ) @session_start();

// Initialize Composer Autoload
require_once '../vendor/autoload.php';

require '../app/Router.php';
$router = new Router;
$router->run();
