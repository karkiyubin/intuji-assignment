<?php
/*Route*/
$router = new \Bramus\Router\Router();

$router->setNamespace('Controller');

$router->get('/', 'HomeController@index');
$router->get('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/calendar/event/add', 'CalendarController@addEvent');
$router->get('/calendar/event/delete/{eventId}', 'CalendarController@confirmDeleteEvent');

$router->post('/calendar/event/add', 'CalendarController@insertEvent');
$router->post('/calendar/event/delete', 'CalendarController@deleteEvent');

$router->run();