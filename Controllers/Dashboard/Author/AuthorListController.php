<?php

namespace Controllers\Dashboard\Author;
use \Djaravel\Controllers\Generics\ListController;
use \Djaravel\Auth\Traits\RequestAccessTrait;
use \Models\Autor;
use \Models\Usuario;

class AuthorListController extends ListController{
    use RequestAccessTrait;
    protected $loginUrl = '/dashboard/login/';
    protected $template = 'dashboard/authors/author_list.html';

    protected $model = Autor::class;

    function hasPermission(){
        $user = $_SESSION['user'];
        return $user->userObject->tipo_de_usuario == Usuario::ADMIN;
    }
}

?>