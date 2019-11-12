<?php

namespace app;

use app\lib\Db;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use SimpleMail;


class Model
{
    protected $pdo;
    protected $queryFactory;
    public $auth;
    public $error;

    public function __construct(Db $pdo, QueryFactory $QueryFactory, Auth $auth)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $QueryFactory;
        $this->auth = $auth;
    }

    public function validate($input, $post)
    {
        $rules = [
            'email' => [
                'pattern' => '#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#',
                'message' => 'E-mail адрес указан неверно',
            ],
            'password' => [
                'pattern' => '#^[a-z0-9]{6,10}$#',
                'message' => 'Пароль указан неверно (разрешены только латинские буквы и цифры от 6 до 10 символов',
            ],
        ];
        foreach ($input as $val) {
            if (!isset($post[$val]) or !preg_match($rules[$val]['pattern'], $post[$val])) {
                $this->error = $rules[$val]['message'];
                return false;
            }
        }
        return true;
    }

    public function register()
    {
        try {
            $this->auth->register($_POST['email'], $_POST['password'], $_POST['name'], function ($selector, $token) {
                SimpleMail::make()
                    ->setTo($_POST['email'], $_POST['name'])
                    ->setFrom('admin@bloginfoprog.ru', 'Admin')
                    ->setSubject('Confirmation Emal')
                    ->setMessage('https://www.chat.bloginfoprog.ru/verification?selector=' . \urlencode($selector) . '&token=' . \urlencode($token))
                    ->send();;
            });
            $name = htmlentities(trim($_POST['name']));
            $user_id = $this->getIDvorEmail('users', $_POST['email']);
            $this->insert('userscom', ['name' => $name, 'user_id' => $user_id['id']]);
            return true;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->error = 'E-mail адрес указан неверно';
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->error = 'Пароль указан неверно';
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->error = 'Данное имя занято';
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->error = 'Слишком много попыток регистрации';
        }
        return false;
    }

    public function login()
    {
        try {
            if ($_POST['remember'] == 1) {
                // keep logged in for one year
                $rememberDuration = (int) (60 * 60 * 24 * 365.25);
            } else {
                // do not keep logged in after session ends
                $rememberDuration = null;
            }
            $this->auth->login($_POST['email'], $_POST['password'], $rememberDuration);
            return true;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->error = 'E-mail адрес указан неверно';
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->error = 'Пароль указан неверно';
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this->error = 'E-mail адрес не подтверждён';
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->error = 'Слишком много попыток авторизации';
        }
        return false;
    }

    public function logout()
    {
        $this->auth->logOut();
        $this->auth->destroySession();
    }

    public function checkPassword($password, $passwordConfirm)
    {
        if ($password == $passwordConfirm)
            return true;
        return false;
    }

    public function checkEmailExists($email)
    {
        $params = $this->getIDvorEmail('users', $email);
        return $params;
    }

    public function verificationEmail()
    {
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);
            return true;
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            $this->error = 'неверный токен';
        } catch (\Delight\Auth\TokenExpiredException $e) {
            $this->error = 'токен просрочен';
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->error = 'Адрес электронной почты уже существует';
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->error = 'Слишком много попыток подтверждения Email';
        }
        return false;
    }

    public function changePassword()
    {
        try {
            $this->auth->changePassword($_POST['password_current'], $_POST['password']);
            return true;
        } catch (\Delight\Auth\NotLoggedInException $e) {
            $this->error = 'Не авторизован';
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->error = 'Старый пароль указан неверно';
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->error = 'Слишком много попыток смены пароля';
        }
        return false;
    }

    public function changeName()
    {
        $name = htmlentities(trim($_POST['name']));

        if ($name && ($name != $_SESSION['auth_username'])) {
            $getUserInfo = $this->getUserInfo();
            $user_id = $getUserInfo['user_id'];
            $this->update('users', ['username' => $name], $_SESSION['auth_user_id']);



            $this->updateUsersCom('userscom', ['name' => $name], $user_id);
            //Изменение в сессии имени пользователя:
            $_SESSION['auth_username'] = $name;
            return true;
        }
        return false;
    }

    public function changeEmail()
    {
        try {
            $this->auth->changeEmail($_POST['email'], function ($selector, $token) {
                SimpleMail::make()
                    ->setTo($_POST['email'], $_SESSION['auth_username'])
                    ->setFrom('admin@bloginfoprog.ru', 'Admin')
                    ->setSubject('Confirmation Emal')
                    ->setMessage('https://www.chat.bloginfoprog.ru/verification?selector=' . \urlencode($selector) . '&token=' . \urlencode($token))
                    ->send();;
            });
            return true;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->error = 'E-mail адрес указан неверно';
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->error = 'Адрес электронной почты уже существует';
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this->error = 'Аккаунт не подтверждён';
        } catch (\Delight\Auth\NotLoggedInException $e) {
            $this->error = 'Пользователь не авторизован';
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->error = 'Слишком много попыток смены E-mail';
        }
        return false;
    }

    public function changeImage()
    {
        $image = $_FILES['image'];
        $getUserInfo = $this->getUserInfo();
        $userImage = $getUserInfo['image'];
        $user_id = $getUserInfo['user_id'];
        
        if (!empty($image['name'])) {
            $uploadDir = 'img/';
            $availableExtension = ['jpg', 'svg', 'png', 'gif'];
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
            $imageName = uniqid() . '.' . $extension;
            $uploadImage = $uploadDir . $imageName;
            if (!in_array($extension, $availableExtension)) {
                $this->error = 'Используйте поддерживаемое расширение: ' . implode(', ', $availableExtension);
                return false;
            } elseif ($image['size'] > 1024 * 1024) {
                $this->error = 'Размер загружаемой картинки не должен превышать 1Мб';
                return false;
            } elseif ($_FILES['image']['error'] > 0) {
                $this->error = 'Ошибка загрузки файла';
                return false;
            } else {
                if ($userImage != 'no-user.jpg') {
                    unlink($uploadDir . $userImage);
                    move_uploaded_file($image['tmp_name'], $uploadImage);
                } else {
                    move_uploaded_file($image['tmp_name'], $uploadImage);
                }
                $this->updateUsersCom('userscom', ['image' => $imageName], $user_id);
                return true;
            }
            return false;
        }
    }

    public function sendComment()
    {
        $user_id = $_SESSION['auth_user_id'];
        $date = date("Y.m.d");
        $text = htmlentities(trim($_POST['text']));
        $this->insert('comments', ['date' => $date, 'text' => $text, 'user_id' => $user_id]);
    }

    public function showComment()
    {
        $this->update('comments', ['skip' => 0], $_POST['show']);
    }
    public function skipComment()
    {
        $this->update('comments', ['skip' => 1], $_POST['skip']);
    }
    public function deleteComment()
    {
        $this->delete('comments', $_POST['del']);
    }

    public function getUserInfo()
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from('userscom')
            ->where('user_id = :user_id')
            ->bindValue('user_id', $_SESSION['auth_user_id']);
        $sth = $this->pdo->db->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetch();
    }

    public function getAllComments($itemsPerPage, $currentPage)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(["comments.*", "userscom.image", "userscom.name"])
            ->from("comments")
            ->leftJoin('userscom', 'comments.user_id = userscom.user_id')
            ->orderBy(['id DESC'])
            ->setPaging($itemsPerPage)
            ->page($currentPage);
        $sth = $this->pdo->db->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll();
    }

    public function getIDvorEmail($table, $email)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(["id"])
            ->from($table)
            ->where('email = :email')
            ->bindValue('email', $email);
        $sth = $this->pdo->db->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetch();
    }

    public function updateUsersCom($table, $data, $user_id)
    {
        $update = $this->queryFactory->newUpdate();
        $update
            ->table($table)
            ->cols($data)
            ->where('user_id = :user_id')
            ->bindValue('user_id', $user_id);
        $sth = $this->pdo->db->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function getAll($table)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table);
        $sth = $this->pdo->db->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll();
        return $result;
    }

    public function getOne($table, $id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);
        $sth = $this->pdo->db->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetch();
    }

    public function insert($table, $data)
    {
        $insert = $this->queryFactory->newInsert();
        $insert
            ->into($table)
            ->cols($data);
        $sth = $this->pdo->db->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }

    public function update($table, $data, $id)
    {
        $update = $this->queryFactory->newUpdate();
        $update
            ->table($table)
            ->cols($data)
            ->where('id = :id')
            ->bindValue('id', $id);
        $sth = $this->pdo->db->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function delete($table, $id)
    {
        $delete = $this->queryFactory->newDelete();
        $delete->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);
        $sth = $this->pdo->db->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }

    public function lastInsertId()
    {
        return $this->pdo->db->lastInsertId();
    }
}
