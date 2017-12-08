<?php
    include 'header.php';
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <?php if(isset($message)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                    <p class="text-center"><a href="index.php">На главную</a></p>
                <?php else: ?>
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <h1><?php echo $title; ?></h1>
                    <h4>Модератор: <?php echo htmlspecialchars($moderator); ?></h4>
                    <?php if(isset($posts) && !empty($posts)): ?>
                        <?php foreach($posts as $post): ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p><?php echo nl2br(htmlspecialchars($post['text'])); ?></p>
                                    <p><small>Пользователь: <?php echo htmlspecialchars($post['login']); ?><br />
                                    Дата и время: <?php echo htmlspecialchars($post['datetime']); ?></small></p>
                                    <?php if(isset($rights) && $rights == 'MODERATOR'): ?>
                                        <form action="topic.php" method="post">
                                            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                                            <button type="submit" name="act" value="delete_post" class="btn btn-danger"
                                                onclick="return confirm('Удалить сообщение от пользователя <?php echo htmlspecialchars($post['login']); ?>?');">Удалить сообщение</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="text-center">В этой теме пока нет ни одного сообщения</h3>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($login)): ?>
                    <form action="topic.php" method="post">
                        <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                        <div class="form-group">
                            <textarea rows="5" class="form-control" id="text" name="text" placeholder="Введите сообщение"></textarea>
                        </div>
                        <button type="submit" name="act" value="add_post" class="btn btn-default btn-lg pull-right">Отправить</button>
                    </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php' ?>
