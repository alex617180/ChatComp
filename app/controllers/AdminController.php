<?php

namespace app\controllers;

use app\Controller;

class AdminController extends Controller
{
	public function adminAction()
	{
		$itemsPerPage = $this->view->itemsPerPage;
		$currentPage = $this->view->currentPage;
		$totalItems = $this->model->getAll('comments');
		$this->view->totalItems = count($totalItems);
		$comments = $this->model->getAllComments($itemsPerPage, $currentPage);
		$this->view->admin($comments);
	}
	public function editAdminAction()
	{
		if ($_POST) {
			if (isset($_POST['show']))
				$this->model->showComment();
			if (isset($_POST['skip']))
				$this->model->skipComment();
			if (isset($_POST['del']))
				$this->model->deleteComment();
		}
		$this->view->redirect('/admin');
	}
}
