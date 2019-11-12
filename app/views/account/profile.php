<?= $this->layout('layout', ['title' => 'Profile']); ?>
<?php if ($_SESSION['auth_logged_in']) : ?>
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Профиль пользователя</h3>
                        </div>

                        <div class="card-body">
                        <?php echo flash()->display(); ?>
                            <form action="/profile" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                                            <input type="text" maxlength="20" class="form-control" name="name" id="exampleFormControlInput1" value="<?php echo $_SESSION['auth_username']; ?>" required>

                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
                                            <input type="email" maxlength="30" class="form-control" name="email" id="exampleFormControlInput1" value="<?php echo $_SESSION['auth_email']; ?>" required>

                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Аватар</label>
                                            <input type="file" class="form-control" name="image" id="exampleFormControlInput1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <img src="img/<?php echo $image; ?>" alt="" class="img-fluid">
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-warning">Edit profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header">
                            <h3>Безопасность</h3>
                        </div>

                        <div class="card-body">
                            <form action="/profile" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Current password</label>
                                            <input type="password" maxlength="20" name="password_current" class="form-control" id="exampleFormControlInput1" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">New password</label>
                                            <input type="password" maxlength="20" name="password" class="form-control" id="exampleFormControlInput1" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password confirmation</label>
                                            <input type="password" maxlength="20" name="password_confirm" class="form-control" id="exampleFormControlInput1" required>
                                        </div>

                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php endif; ?>