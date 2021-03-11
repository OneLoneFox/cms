<?php

namespace Controllers\Dashboard;
use \Djaravel\Controllers\Generics\BaseController;
use \Djaravel\Auth\Traits\RequestAccessTrait;
use \Models\Admin;
use \Models\Usuario;

class DashboardIndexController extends BaseController
{
    use RequestAccessTrait;
    protected $loginUrl = '/dashboard/login/';
    
    protected $template = 'dashboard/index.html';

    function hasPermission(){
        $user = $_SESSION['user'];
        return $user->userObject->tipo_de_usuario == Usuario::ADMIN;
    }
}