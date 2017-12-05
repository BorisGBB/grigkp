<?php
    $title = 'Регистрация';
    include_once __DIR__ . '/' . '../config/fields.php';
    include 'header.php';
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <h1 class="text-center">Регистрация</h1>
                <?php if(isset($success) && $success): ?>
                    <div class="alert alert-success">Пользователь зарегистрирован</div>
                    <p class="text-center"><a href="index.php">На главную</a></p>
                <?php else: ?>
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form action="reg.php" method="post">
                    <?php foreach(REG_FORM as $key => $value): ?>
                        <div class="form-group">
                            <label for="<?php echo $key; ?>"><?php echo htmlspecialchars($value['name']); ?></label>
                            <input class="form-control" type="<?php echo htmlspecialchars($value['type']); ?>" id="<?php echo htmlspecialchars($key); ?>" name="<?php echo htmlspecialchars($key); ?>"
                                value="<?php echo isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : ''; ?>">
                        </div>
                    <?php endforeach; ?>
                    <button class="btn btn-primary btn-block btn-lg">Зарегистрировать</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php include 'footer.php' ?>
