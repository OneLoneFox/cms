<?php

namespace Controllers\Dashboard\Author;
use \Djaravel\Controllers\Generics\ListController;
use \Djaravel\Auth\Traits\RequestAccessTrait;
use \Djaravel\Serializers\ModelSerializer;
use \Models\Autor;
use \Models\Usuario;
use \Models\Congreso;

class AuthorListController extends ListController{
    use RequestAccessTrait;
    protected $loginUrl = '/dashboard/login/';
    protected $template = 'dashboard/authors/author_list.html';

    protected $model = Autor::class;

    function getContextData(...$args){
        $context = parent::getContextData(...$args);
        $users = array();
        foreach ($context['object_list'] as $k => $admin){
            $users[] = $admin->userObject;
        }
        $serializer = new ModelSerializer($users);
        $context['userObject'] = $context['user']->userObject;
        $context['serialized_users'] = $serializer->data;
        $context['posts'] = Congreso::all();
        return $context;
    }

    function hasPermission(){
        $user = $_SESSION['user'];
        return $user->userObject->tipo_de_usuario == Usuario::ADMIN;
    }
}

?>