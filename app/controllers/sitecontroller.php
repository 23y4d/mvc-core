<?php declare(strict_types=1);

namespace app\controllers;

use app\core\controller;

class sitecontroller extends controller 
{

	public function index()
	{

		return $this->render('index');
	}

	public function home($r)
	{
		$hi = $r->getParms(0,'str');
		return $this->render('home', [
			'welcome' => $hi
		]);
	}

}
