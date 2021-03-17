<?php

// ToDo: add duplicate email constraint

namespace Controllers\Dashboard\Admin;
use \Djaravel\Controllers\Generics\CreateController;
use \Djaravel\Utils\ModelFactory;
use \Djaravel\Utils\Shortcuts;
use \Djaravel\Auth\Traits\RequestAccessTrait;
use \Models\Usuario;
use \Models\Admin;

class AdminRegisterController extends CreateController
{
    // use RequestAccessTrait;

    // public $loginUrl = '/dashboard/login/';
    protected $template = 'auth/admin_register.html';

    protected $model = Usuario::class;
    protected $success_url;
    private $subModel = Admin::class;

    function __construct(){
        parent::__construct();
        $this->success_url = '/'.$_ENV['BASE_DIR'].'/dashboard/admins/';
    }
    

    function post(...$args){
        $newUser = ModelFactory::fromArray($this->model, $_POST);
		$errors = $this->validator->validate($newUser);
		if (count($errors) > 0){
			// If there are any errors go back to the form and print them
            $this->get(...$args);
			die();
		}
		if($newUser->save()){
            $adminValues = [
                'contrasena' => $this->createPassword($_POST['contrasena']),
                'usuario' => $newUser->id,
            ];
            $newAdmin = ModelFactory::fromArray($this->subModel, $adminValues);
            $errors = $this->validator->validate($newAdmin);
            if(count($errors) > 0){
                // Sadly we can only print one model error list at a time
                $this->get(...$args);
                die();
            }
            if($newAdmin->save()){
                $success_url = $this->getSuccessUrl();
                Shortcuts::redirect($success_url);
            }else{
    			throw new \Exception('Something went wrong creating the admin');
            }
			
		}else{
			throw new \Exception('Something went wrong creating the user');
		}
    }

    function getContextData(...$args){
        $context = parent::getContextData(...$args);
        $context['userObject'] = $context['user']->userObject;
        return $context;
    }

    private function createPassword($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }

    function hasPermission(){
        if($_ENV['DEBUG']){
            return true;    
        }
        $user = $_SESSION['user'];
        return $user->userObject->tipo_de_usuario == Usuario::ADMIN;
    }
}