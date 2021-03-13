<?php 

require_once 'Djaravel/Bootstrap.php';

$router = new \Bramus\Router\Router();

$router->set404('\Controllers\NotFoundController@dispatch');

$router->get('/', '\Controllers\LandingController@dispatch');

$router->mount('/dashboard', function() use ($router) {
    
    $router->get('/', '\Controllers\Dashboard\DashboardIndexController@dispatch');
    
    $router->get('/profile', '\Controllers\Dashboard\Admin\AdminProfileController@dispatch');

    $router->get('/logout/', '\Controllers\Dashboard\LogoutController@dispatch');
    
    $router->match('GET|POST', '/login', '\Controllers\Dashboard\DashboardLoginController@dispatch');
    
    $router->mount('/admins', function() use ($router) {
        $router->get('/', '\Controllers\Dashboard\Admin\AdminListController@dispatch');
        if($_ENV['DEBUG']){
            // This will ensure we can only acces the admin registration on local
            $router->match('GET|POST', '/register', '\Controllers\Dashboard\Admin\AdminRegisterController@dispatch');
        }
    });

});


$router->run();

