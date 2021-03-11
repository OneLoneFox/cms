<?php

namespace Controllers\Dashboard;
use \Models\Usuario;
use \Models\Admin;
use \Djaravel\Controllers\Generics\BaseController;
use \Djaravel\Core\Exceptions\UnsuportedMethodException;
use \Djaravel\Utils\Shortcuts;

class DashboardLoginController extends BaseController
{
    protected $template = 'auth/admin_login.html';

    function post(...$args){
        $email = $_POST['correo'];
        $password = $_POST['contrasena'];
        $userToAuth = Usuario
            ::where('correo', $email)
            ->first();
        if($userToAuth){
            if($userToAuth->tipo_de_usuario == Usuario::ADMIN){
                $authAdmin = Admin
                    ::where('usuario', $userToAuth->id)
                    ->first();
                if(password_verify($password, $authAdmin->contrasena)){
                    $_SESSION['user'] = $authAdmin;
                    $success_url = $this->getSuccessUrl();
                    Shortcuts::redirect($success_url);
                    // Redirect
                }else{
                    // ToDo: handle properly
                    die('invalid password');
                }
            }else{
                // ToDo: handle properly
                die('not an admin');
            }
        }else{
            // ToDo: handle properly
            die('no user');
        }
    }

    function get(...$args){
        parent::dispatch(...$args);
    }

    function dispatch(...$args){
        switch($_SERVER['REQUEST_METHOD']){
			case 'POST':
				$this->post(...$args);
				break;
			case 'GET':
				# render the remplate with the given context
				$this->get(...$args);
				break;
			default:
				http_response_code(405);
				throw new UnsuportedMethodException('This controller must handle POST and GET requests only.');
				break;
		}
    }

    private function authenticate($user){
        return false;
    }

    function getSuccessUrl(){
        // obtain next GET
        return $_GET['next'] ?? $this->getDefaultSuccessUrl();
    }

    function getDefaultSuccessUrl(){
        return '/'.$_ENV['BASE_DIR'].'/dashboard/';
    }
}