<?php

namespace Controllers\Dashboard\Post;
use \Djaravel\Controllers\Generics\ListController;
use \Models\Congreso;

class PostListController extends ListController {
    protected $template = 'dashboard/post/post_list.html';
    protected $model = Congreso::class;

    function getContextData(...$args){
        $context = parent::getContextData(...$args);
        $context['userObject'] = $context['user']->userObject;
        return $context;
    }

}