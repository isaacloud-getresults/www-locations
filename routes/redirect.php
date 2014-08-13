<?php 




/***************************** redirect  *****************************************/



$app->get('/room/dashboard', function () use ($app) {
    $app->response->redirect($app->urlFor('d'), 303); 
});


$app->get('/room/leaderboard', function () use ($app) {
    $app->response->redirect($app->urlFor('l'), 303); 
});


$app->get('/room/room', function () use ($app) {
    $app->response->redirect($app->urlFor('r'), 303); 
});


$app->get('/room/users', function () use ($app) {
    $app->response->redirect($app->urlFor('u'), 303); 
});


$app->get('/room/details', function () use ($app) {
    $app->response->redirect($app->urlFor('de'), 303); 
});

$app->get('/room/users/:x', function ($x) use ($app) {

   $a= $app->urlFor('u');
    $b="/";
     $y=$a.$b.$x;   
    $app->response->redirect($y, 303); 
});



$app->get('/room/ulogout', function () use ($app) {
    $app->response->redirect($app->urlFor('uo'), 303); 
});


$app->get('/users/dashboard', function () use ($app) {
    $app->response->redirect($app->urlFor('d'), 303); 
});


$app->get('/users/leaderboard', function () use ($app) {
    $app->response->redirect($app->urlFor('l'), 303); 
});


$app->get('/users/room', function () use ($app) {
    $app->response->redirect($app->urlFor('r'), 303); 
});


$app->get('/users/users', function () use ($app) {
    $app->response->redirect($app->urlFor('u'), 303); 
});


$app->get('/users/details', function () use ($app) {
    $app->response->redirect($app->urlFor('de'), 303); 
});


$app->get('/users/ulogout', function () use ($app) {
    $app->response->redirect($app->urlFor('uo'), 303); 
});


$app->get('/admin/ulogout', function () use ($app) {
    $app->response->redirect($app->urlFor('uo'), 303); 
});


$app->get('/admin/admin/dashboard', function () use ($app) {
    $app->response->redirect($app->urlFor('ad'), 303); 
});


$app->get('/admin/admin/www', function () use ($app) {
    $app->response->redirect($app->urlFor('ww'), 303); 
});

$app->get('/admin/admin/mobile', function () use ($app) {
    $app->response->redirect($app->urlFor('mo'), 303); 
});

$app->get('/admin/admin/setup', function () use ($app) {
    $app->response->redirect($app->urlFor('set'), 303); 
});


$app->get('/admin/user', function () use ($app) {
    $app->response->redirect($app->urlFor('d'), 303); 
});








 ?>