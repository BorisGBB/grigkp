<?php
    $title = 'Создание новой темы';
    include 'header.php';
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h1 class="text-center">Создание новой темы</h1>
                <?php if(isset($success) && $success): ?>
                    <div class="alert alert-success">Тема создана</div>
                    <p class="text-center"><a href="index.php">На главную</a></p>
                <?php else: ?>
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form action="new_topic.php" method="post">
                    <div class="form-group">
                        <label for="title">Название темы</label>
                        <input class="form-control" type="text" id="title" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
                    </div>
                    <button class="btn btn-primary btn-block btn-lg">Создать тему</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php include 'footer.php' ?>
