<?php

namespace Controllers\Dashboard\Admin;
use \Djaravel\Controllers\Generics\BaseController;

class AdminProfileController extends BaseController
{
    protected $template = 'dashboard/admin/profile.html';

    function getContextData(...$args){
        $context = parent::getContextData(...$args);
        $context['userObject'] = $context['user']->userObject;
        return $context;
    }

}