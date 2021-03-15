<?php

namespace Controllers\Dashboard\Post;
use \Djaravel\Controllers\Generics\DetailController;
use \Models\Congreso;
// use \Models\Pagina;

class PostEditController extends DetailController
{
    protected $model = Congreso::class;
    // private $subModel = Pagina::class;
    protected $template = 'dashboard/post/post_edit.html';

    function getContextData(...$args){
        $context = parent::getContextData(...$args);
        $context['userObject'] = $context['user']->userObject;
        return $context;
    }
}