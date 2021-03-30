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
        $router->match('GET|POST', '/register', '\Controllers\Dashboard\Admin\AdminRegisterController@dispatch');
        if($_ENV['DEBUG']){
            // This will ensure we can only acces the admin registration on local
            // test create Authors
            $router->match('GET|POST', '/registerAuthor', '\Controllers\Dashboard\Author\AuthorRegisterController@dispatch');
        }
    });
    $router->get('/authors', '\Controllers\Dashboard\Author\AuthorListController@dispatch');

    $router->mount('/posts', function() use ($router) {
        $router->get('/', '\Controllers\Dashboard\Post\PostListController@dispatch');
        $router->match('GET|POST', '/create', '\Controllers\Dashboard\Post\PostCreateController@dispatch');
        # ToDo: missing implementation
        // $router->get('/(\d+)/preview', '\Controllers\Dashboard\Post\PostPreviewController@dispatch');
        $router->get('/(\d+)/edit', '\Controllers\Dashboard\Post\PostEditController@dispatch');
        $router->match('GET|POST', '/(\d+)/delete', '\Controllers\Dashboard\Post\PostDeleteController@dispatch');

    });

});

$router->mount('/api', function() use ($router){
    $router->mount('/tabs', function() use ($router){
        $router->get('/(\d+)', '\Controllers\Api\Tab\TabDetailEndpoint@dispatch');
        $router->patch('/(\d+)', '\Controllers\Api\Tab\TabUpdateEndpoint@dispatch');
        $router->post('/', '\Controllers\Api\Tab\TabCreateEndpoint@dispatch');
        $router->post('/(\d+)/delete', '\Controllers\Api\Tab\TabDeleteEndpoint@dispatch');
        $router->post('/images', '\Controllers\Api\Tab\TabImageUploadEndpoint@dispatch');
    });

    $router->mount('/authors', function() use ($router){
        // ToDo: missing implementation
        $router->patch('/(\d+)', '\Controllers\Api\Author\AuthorUpdateEndpoint@dispatch');
    });
    
    $router->mount('/posts', function() use ($router){
        $router->get('/(\d+)/tabs', '\Controllers\Api\Tab\TabListEndpoint@dispatch');
        $router->get('/(\d+)/authors', '\Controllers\Api\Author\AuthorListEndpoint@dispatch');
    });
});


$router->run();
