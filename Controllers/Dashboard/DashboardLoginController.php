<?php

namespace Controllers\Dashboard;
use \Models\Usuario;
use \Models\Admin;
use \Djaravel\Controllers\Generics\BaseController;
use \Djaravel\Core\Exceptions\UnsuportedMethodException;

class DashboardLoginController extends BaseController
{
    protected $template = 'auth/admin_login.html';

    function post(...$args){

        $adminToAuth = Admin
            ::where('usuario', 10)
            ->getQuery();

        // var_dump($adminToAuth);
        // die();

        $email = $_POST['correo'];
        $password = $_POST['contrasena'];
        $userToAuth = Usuario
            ::where('correo', $email)
            ->getQuery();
        var_dump($userToAuth);
        die();
        if(count($userToAuth) === 1){
            if($userToAuth[0]->tipo_de_usuario == Usuario::ADMIN){
                $adminToAuth = Admin
                    ::where('usuario', $userToAuth[0]->id)
                    ->getQuery();
                if(password_verify($password, $adminToAuth[0]->contrasena)){
                    die('auth succesful');
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
}