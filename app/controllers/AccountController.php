<?php

namespace app\controllers;

use app\Controller;

class AccountController extends Controller
{

	public function profileAction()
	{
		$getUserInfo = $this->model->getUserInfo();
		$userImage = $getUserInfo['image'];
		$name = htmlentities(trim($_POST['name']));
		$email = htmlentities(trim($_POST['email']));
		$image = $_FILES['image'];
		$password_current = htmlentities(trim($_POST['password_current']));
		$password = htmlentities(trim($_POST['password']));
		$password_confirm = htmlentities(trim($_POST['password_confirm']));

		if (!empty($_POST)) {

			if (!empty($name) || !empty($email) || !empty($image['name'])) {
				if ($this->model->changeName()) {
					$this->view->message('Имя успешно обновлено', 'success');
				}
				if (!empty($email) && ($email != $_SESSION['auth_email'])) {
					if (!$this->model->validate(['email'], $_POST)) {
						$this->view->message('E-mail адрес указан неверно', 'error');
					} elseif ($this->model->checkEmailExists($_POST['email'])) {
						$this->view->message('Этот E-mail уже используется', 'error');
					} else {
						if ($this->model->changeEmail()) {
							$this->view->message('E-mail успешно изменён, требуется его подтверждение', 'success');
						} else {
							$this->view->message($this->model->error, 'error');
						}
					}
				}
				if (!empty($image['name'])) {
					if ($this->model->changeImage()) {
						$this->view->message('Картинка успешно обновлена', 'success');
					} else {
						$this->view->message($this->model->error, 'error');
					}
				}

				$this->view->redirect('/profile');
			} elseif (!empty($password_current) && !empty($password) && !empty($password_confirm)) {
				if (!$this->model->validate(['password'], $_POST)) {
					$this->view->message('Новый пароль указан неверно (разрешены только латинские буквы и цифры от 6 до 10 символов', 'error');
				} elseif (!$this->model->checkPassword($_POST['password'], $_POST['password_confirm'])) {
					$this->view->message('Пароли должны совпадать', 'error');
				} else {
					if ($this->model->changePassword()) {
						$this->view->message('Пароль успешно обновлен', 'success');
					} else {
						$this->view->message($this->model->error, 'error');
					}
				}
			}
		}
		$this->view->profile($userImage);
	}
}
