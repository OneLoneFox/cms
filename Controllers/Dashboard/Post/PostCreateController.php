<?php

namespace Controllers\Dashboard\Post;
use \Djaravel\Controllers\Generics\CreateController;
use \Djaravel\Utils\ModelFactory;
use \Djaravel\Utils\Shortcuts;
use \Models\Congreso;

class PostCreateController extends CreateController
{
    protected $model = Congreso::class;
    protected $template = 'dashboard/post/post_create.html';

    function getContextData(...$args){
        $context = parent::getContextData(...$args);
        $context['userObject'] = $context['user']->userObject;
        return $context;
    }

    function post(...$args){
        // Sets the "created by" field to the current user
        $_POST['admin'] = $_SESSION['user']->id;
        
        $newPost = ModelFactory::fromArray($this->model, $_POST);
		$errors = $this->validator->validate($newPost);
		if (count($errors) > 0){
			parent::get(...$args);
			die();
		}
		if($newPost->save()){
			$success_url = '/dashboard/posts/'.$newPost->id.'/edit/';
			Shortcuts::redirectBase($success_url);
		}else{
			throw new \Exception('Object creation failed');
		}
    }
}