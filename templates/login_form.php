<?php
    $title = 'Авторизация';
    include 'header.php';
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <h1 class="text-center">Авторизация</h1>
                <?php if(!isset($logout)): ?>
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input class="form-control" type="text" id="login" name="login" value="<?php echo isset($_POST['login']) ? htmlspecialchars($_POST['login']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input class="form-control" type="password" id="password" name="password" value="">
                        </div>
                        <button class="btn btn-primary btn-block btn-lg" name="act" value="reg">Войти</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-success">Вы вышли</div>
                    <p class="text-center"><a href="index.php">На главную</a></p>
                <?php endif; ?>
        </div>
    </div>
<?php include 'footer.php' ?>
