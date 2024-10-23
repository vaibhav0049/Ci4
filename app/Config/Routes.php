<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'Auth::login');
 $routes->post('/auth/authenticate', 'Auth::authenticate');
 $routes->get('/auth/logout', 'Auth::logout');
 $routes->get('/articles/list', 'ArticleController::list');
 $routes->get('/articles/form/(:num)', 'ArticleController::form/$1');
 $routes->get('/articles/form', 'ArticleController::form');
 $routes->post('/articles/save', 'ArticleController::save');
 $routes->get('/articles/delete/(:num)', 'ArticleController::delete/$1');
 $routes->get('upload-form', 'FileUploadController::index');
 $routes->post('upload-file', 'FileUploadController::uploadFile');
