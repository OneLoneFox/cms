<?php

namespace Controllers\Dashboard\Admin;
use \Djaravel\Controllers\Generics\ListController;
use \Models\Admin;

class AdminListController extends ListController{
    protected $model = Admin::class;
}