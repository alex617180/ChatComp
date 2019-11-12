<?php $this->layout('layout', ['title' => 'Admin Panel']); ?>
<?php if ($_SESSION['auth_roles'] == 1) : ?>
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Админ панель</h3>
                        </div>

                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Аватар</th>
                                        <th>Имя</th>
                                        <th>Дата</th>
                                        <th>Комментарий</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($comments as $user) : ?>
                                        <tr>
                                            <td>
                                                <img src="img/<?php echo $user["image"]; ?>" alt="" class="img-fluid" width="64" height="64">
                                            </td>
                                            <td><?php echo   $user["name"]; ?></td>
                                            <td><?php echo  date('d/m/Y', strtotime($user["date"])); ?></td>
                                            <td><?php echo   $user["text"]; ?></td>
                                            <td>
                                                <?php if ($user["skip"] == 1) : ?>
                                                    <form action="/admin" method="post">
                                                        <button type="submit" name="show" value="<?php echo $user["id"]; ?>" class="btn btn-success">Показано</button>
                                                    </form>
                                                <?php else : ?>
                                                    <form action="/admin" method="post">
                                                        <button type="submit" name="skip" value="<?php echo $user["id"]; ?>" class="btn btn-warning">Скрыто</button>
                                                    </form>
                                                <?php endif; ?><form action="/admin" method="post">
                                                    <button onclick="return confirm('are you sure?')" type="submit" name="del" value="<?php echo $user["id"]; ?>" class="btn btn-danger">Удалить</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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

                    </div>
                </div>
            </div>
        </div>
    </main>
<?php else :
    echo 'В ДОСТУПЕ ОТКАЗАНО!';
endif; ?>