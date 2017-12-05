<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo isset($title) ? htmlspecialchars($title) : ''; ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">Форум</a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if(isset($login)): ?>
                            <li class="navbar-text">Добрый день, <?php echo htmlspecialchars($login); ?></li>
                            <form class="navbar-form navbar-right" method="get">
                                <button type="submit" formaction="login.php" class="btn btn-default" name="act" value="logout">Выйти</button>
                            </form>
                        <?php else : ?>
                            <form class="navbar-form navbar-right" method="get">
                                <button type="submit" formaction="login.php" class="btn btn-default">Войти</button>
                                <button type="submit" formaction="reg.php" class="btn btn-default">Зарегистрироваться</button>
                            </form>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </header>
