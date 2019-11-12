<?php

namespace app;

use League\Plates\Engine;
use JasonGrimes\Paginator;

class View
{
	public $templates;
	public $paginator;

	public $totalItems;
	public $itemsPerPage = 8;
	public $currentPage;
	public $urlPattern = '?page=(:num)';
	
	public function __construct(Engine $engine)
	{
		$this->templates = $engine;
		$this->currentPage = $_GET['page'] ?? 1;
		
	}

	public function home($posts)
	{ 
		$this->paginator = new Paginator($this->totalItems, $this->itemsPerPage, $this->currentPage, $this->urlPattern);
		echo $this->templates->render('main/main', ['comments' => $posts, 'paginator' => $this->paginator]);
	}

	public function confirm($bool)
	{ 
		echo $this->templates->render('main/confirm', ['bool' => $bool]);
	}

	public function register()
	{
		echo $this->templates->render('main/register');
	}
	public function login()
	{
		echo $this->templates->render('main/login');
	}
	public function profile($image)
	{
		echo $this->templates->render('account/profile', ['image' => $image]);
	}
	public function admin($posts)
	{
		$this->paginator = new Paginator($this->totalItems, $this->itemsPerPage, $this->currentPage, $this->urlPattern);
		echo $this->templates->render('admin/comments', ['comments' => $posts, 'paginator' => $this->paginator]);
	}

	public function redirect($url = '/')
	{
		header('location:' . $url);
		exit;
	}

	public static function errorCode($code)
	{
		http_response_code($code);
		$path = '../app/views/errors/' . $code . '.php';
		if (file_exists($path)) {
			require $path;
		}
		exit;
	}

	public function message($message, $type = 'info')
	{
		flash()->message($message, $type);
	}
}
