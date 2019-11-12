<?= $this->layout('layout', ['title' => 'Chat_MVC']); ?>
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Комментарии</h3>
                    </div>
                    <div class="card-body">
                        <?php echo flash()->display(); ?>
                    </div>
                    <?php
                    // вывод комментов:

                    foreach ($comments as $user) :
                        if ($user["skip"] == 1) :
                            ?>
                            <div class="media">
                                <img src='img/<?php echo $user["image"]; ?>' class='mr-3' alt='...' width='64' height='64'>
                                <div class='media-body'>
                                    <h5 class='mt-0'><?php echo   $user["name"]; ?></h5>
                                    <span><small><?php echo  date('d/m/Y', strtotime($user["date"])); ?></small></span>
                                    <p><?php echo   $user["text"]; ?></p>
                                </div>
                            </div>
                    <?php endif;
                    endforeach; ?>
                </div>
            </div>

            <!-- Пагинация: -->
            <div class="col-md-12 mt-3 ">
                <ul class="pagination justify-content-center">
                    <?php if ($paginator->getPrevUrl()) : ?>
                        <li class="page-item"><a class="page-link" href="<?php echo $paginator->getPrevUrl(); ?>">&laquo; Назад</a></li>
                    <?php endif; ?>

                    <?php foreach ($paginator->getPages() as $page) : ?>
                        <?php if ($page['url']) : ?>
                            <li class="page-item <?php echo $page['isCurrent'] ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo $page['url']; ?>"><?php echo $page['num']; ?></a>
                            </li>
                        <?php else : ?>
                            <li class="page-item disabled"><span><?php echo $page['num']; ?></span></li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($paginator->getNextUrl()) : ?>
                        <li class="page-item"><a class="page-link" href="<?php echo $paginator->getNextUrl(); ?>">Вперёд &raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="col-md-12" >
                <div class="card">
                    <div class="card-header">
                        <h3>Оставить комментарий</h3>
                    </div>
                    <?php if ($_SESSION['auth_logged_in']) : ?>

                        <div class="card-body">
                            <form action="/" method="post">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение </label>
                                    <textarea name="text" maxlength="200" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Отправить</button>

                            </form>
                        </div>
                    <?php else : ?>
                        <div class="card-body card__comment">
                            <p>Чтобы оставить комментарий, </p>
                            <a class="" href="/register">зарегистрируйтесь</a>
                            <p> или </p>
                            <a class="" href="/login">авторизуйтесь</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>