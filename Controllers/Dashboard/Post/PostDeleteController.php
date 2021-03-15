<?php

namespace Controllers\Dashboard\Post;
use \Djaravel\Controllers\Generics\DeleteController;
use \Models\Congreso;

class PostDeleteController extends DeleteController
{
    protected $model = Congreso::class;
}