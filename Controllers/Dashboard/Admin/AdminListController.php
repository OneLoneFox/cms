<?php

namespace Controllers\Dashboard\Admin;
use \Djaravel\Controllers\Generics\ListController;
use \Djaravel\Auth\Traits\RequestAccessTrait;
use \Djaravel\Serializers\ModelSerializer;
use \Models\Admin;
use \Models\Usuario;

class AdminListController extends ListController{
    use RequestAccessTrait;
    protected $loginUrl = '/dashboard/login/';
    protected $template = 'dashboard/admin/admin_list.html';

    protected $model = Admin::class;

    function hasPermission(){
        $user = $_SESSION['user'];
        return $user->userObject->tipo_de_usuario == Usuario::ADMIN;
    }

    function getContextData(...$args){
        $context = parent::getContextData($args);
        $users = array();
        foreach ($context['object_list'] as $k => $admin){
            $users[] = $admin->userObject;
        }
        $serializer = new ModelSerializer($users);
        $context['userObject'] = $context['user']->userObject;
        $context['serialized_users'] = $serializer->data;
        return $context;
    }
}