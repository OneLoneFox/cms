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

    $router->mount('/posts', function() use ($router) {
        $router->get('/', '\Controllers\Dashboard\Post\PostListController@dispatch');
        $router->match('GET|POST', '/create', '\Controllers\Dashboard\Post\PostCreateController@dispatch');
        # ToDo: missing implementation
        // $router->get('/(\d+)/preview', '\Controllers\Dashboard\Post\PostPreviewController@dispatch');
        $router->get('/(\d+)/edit', '\Controllers\Dashboard\Post\PostEditController@dispatch');
        $router->match('GET|POST', '/(\d+)/delete', '\Controllers\Dashboard\Post\PostDeleteController@dispatch');

    });

});


$router->run();

