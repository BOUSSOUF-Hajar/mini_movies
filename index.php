<?php
session_start();

require './config/config.php';
require './core/database.php';
require './core/csrf.php';
require './core/helpers.php';
require './core/Router.php';

$router = new Router();

$router->get('register', 'AuthController@showRegisterForm');
$router->post('register', 'AuthController@register');

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

//ADMIN
$router->get('admin/movies', 'AdminMovieController@index');
$router->get('admin/movies/create', 'AdminMovieController@create');
$router->post('admin/movies/create', 'AdminMovieController@store');
$router->get('admin/movies/(\d+)/edit', 'AdminMovieController@edit');
$router->post('admin/movies/(\d+)/edit', 'AdminMovieController@update');
$router->post('admin/movies/(\d+)/delete', 'AdminMovieController@delete');


$router->dispatch();
