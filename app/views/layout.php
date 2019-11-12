<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $this->e($title) ?></title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
                    Chat-MVC
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <?php if ($_SESSION['auth_logged_in']) : ?>
                            <div class="dropdown">
                                <button onclick="myFunction()" class="dropbtn"><?php echo "Привет, " . $_SESSION['auth_username'] . " !"; ?></button>
                                <div id="myDropdown" class="dropdown-content">
                                <?php if ($_SESSION['auth_roles'] == 1) { ?>
                                    <a href="/admin">Админка</a>
                                <?php } ?>
                                    <a href="/profile">Профиль</a>
                                    <a href="/logout">Выход</a>
                                </div>
                            </div>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Вход</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/register">Регистрация</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?= $this->section('content') ?>
    </div>
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/main.js"></script>
</body>

</html>