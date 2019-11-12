<?php

namespace app;

use app\Model;
use app\View;

abstract class Controller {
	protected $model;
	protected $view;
	
	public function __construct(Model $model, View $view)
	{
		$this->model = $model;
		$this->view = $view;
	}
}