<?php
namespace Controllers\Dashboard\Author;
use \Djaravel\Controllers\Generics\CreateController;
use \Djaravel\Utils\ModelFactory;
use \Djaravel\Utils\Shortcuts;
use \Models\Usuario;
use \Models\Autor;
    
class AuthorRegisterController extends CreateController
{
    protected $template = 'auth/author_register.html';
    protected $model = Usuario::class;
    protected $success_url;
    private $subModel = Autor::class;

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
            $authorValues = [
                'contrasena' => $this->createPassword($_POST['contrasena']),
                'articulo' => $_POST['articulo'],
                'status' => $_POST['status'],
                'usuario' => $newUser->id,
                
            ];
            $newAuthor = ModelFactory::fromArray($this->subModel, $authorValues);
            $errors = $this->validator->validate($newAuthor);
            if(count($errors) > 0){
                // Sadly we can only print one model error list at a time
                $this->get(...$args);
                die();
            }
            if($newAuthor->save()){
                $success_url = $this->getSuccessUrl();
                Shortcuts::redirect($success_url);
            }else{
    			throw new \Exception('Something went wrong creating the admin');
            }
			
		}else{
			throw new \Exception('Something went wrong creating the user');
		}
    }
    private function createPassword($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
?>