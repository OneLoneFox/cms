<?php

namespace Controllers\Dashboard;
use \Djaravel\Controllers\Generics\BaseController;
use \Djaravel\Auth\Traits\RequestAccessTrait;

class DashboardIndexController extends BaseController
{
    // use RequestAccessTrait;
    // protected $permissionRequired = 0;
    // protected $loginUrl = '/dashboard/login/';
    
    protected $template = 'dashboard/index.html';
}