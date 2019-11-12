<?php

namespace app\controllers;

use app\Controller;


class MainController extends Controller
{	
	public function indexAction()
	{
		$itemsPerPage = $this->view->itemsPerPage;
		$currentPage = $this->view->currentPage;		
		$totalItems = $this->model->getAll('comments');		
		$this->view->totalItems = count($totalItems);	
		$comments = $this->model->getAllComments($itemsPerPage, $currentPage);				
		$this->view->home($comments);
	}
	public function sendCommentAction()
	{
		$text = trim($_POST['text']);
		if (!empty($text)) {
		$this->model->sendComment();
		$this->view->message('Комментарий успешно добавлен', 'success');
		$this->view->redirect();
		}
	}
	// Регистрация
	public function registerAction()
	{
		$name = htmlentities(trim($_POST['name']));
		$email = htmlentities(trim($_POST['email']));
		$password = htmlentities(trim($_POST['password']));
		$password_confirm = htmlentities(trim($_POST['password_confirm']));
		if (!empty($_POST)) {
			if (!empty($name) && !empty($email) && !empty($password) && !empty($password_confirm)) {
				if (!$this->model->validate(['email', 'password'], $_POST)) {
					$this->view->message($this->model->error, 'error');
				} elseif ($this->model->checkEmailExists($_POST['email'])) {
					$this->view->message('Этот E-mail уже используется', 'error');
				} elseif (!$this->model->checkPassword($_POST['password'], $_POST['password_confirm'])) {
					$this->view->message('Пароли должны совпадать', 'error');
				} else {
					if ($this->model->register()) {
						$this->view->message('Регистрация завершена, подтвердите свой E-mail', 'success');
						$this->view->redirect('/login');
					} else
						$this->view->message($this->model->error, 'error');
				}
				$this->view->redirect('/register');
			} else {
				$this->view->message('Заполните все поля', 'error');
				$this->view->redirect('/register');
			}
		}
		$this->view->register();
	}
	// Вход
	public function loginAction()
	{
		if ($_POST) {
			if ($this->model->login()) {
				$this->view->redirect();
			} else {
				$this->view->message($this->model->error, 'error');
				$this->view->redirect('/login');
			}
		}
		$this->view->login();
	}
	public function logoutAction()
	{
		$this->model->logout();
		$this->view->redirect('/login');
	}
	public function verificationEmailAction()
	{
		if ($this->model->verificationEmail()) {
			$this->view->message('Email-адресс подтверждён  ', 'success');
			$this->view->confirm(true);
		} else {
			$this->view->message($this->model->error, 'error');
			$this->view->confirm(false);
		}
	}
}
