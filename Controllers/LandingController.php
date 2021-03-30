<?php 

namespace Controllers;
use \Djaravel\Controllers\Generics\BaseController;
use \Models\Congreso;

class LandingController extends BaseController
{
	protected $template = 'landing.html';

	function getContextData(...$args){
		$context = parent::getContextData(...$args);
		$context['posts'] = Congreso::all();
		return $context;
	}
}