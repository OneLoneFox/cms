<?php

namespace Controllers\Dashboard;
use \Djaravel\Controllers\Generics\BaseController;
use \Djaravel\Utils\Shortcuts;

class LogoutController extends BaseController
{
    function dispatch(...$args){
        // cerrar la sesion (destruir)
        session_destroy();
        // reidreccionar a /dashboard/
        Shortcuts::redirectBase('/dashboard/');
    }
}