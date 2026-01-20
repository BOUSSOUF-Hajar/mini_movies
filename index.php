<?php
session_start();

require './config/config.php';
require './core/database.php';
require './core/csrf.php';
require './core/helpers.php';
require './core/Router.php';

$router = new Router();

$router->get('login', 'AuthController@login');
$router->post('login', 'AuthController@login');

$router->get('logout', 'AuthController@logout');

$router->get('movies', 'MovieController@index');
$router->get('movies/(\d+)', 'MovieController@show');

$router->get('profile', 'ProfileController@index');
$router->get('profile/edit', 'ProfileController@edit');
$router->post('profile/edit', 'ProfileController@update');

$router->post('movies/(\d+)/favorite', 'MovieController@favorite');
$router->post('movies/(\d+)/unfavorite', 'MovieController@unfavorite');

$router->dispatch();
