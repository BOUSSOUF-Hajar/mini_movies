<?php
session_start();

require './config/config.php';
require './core/database.php';
require './core/csrf.php';
require './core/Router.php';

$router = new Router();

$router->get('login', 'AuthController@login');
$router->post('login', 'AuthController@login');

$router->get('logout', 'AuthController@logout');

$router->dispatch();
