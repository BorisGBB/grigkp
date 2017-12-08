<?php
    $title = 'Темы';
    include 'header.php';
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <h1 class="text-center">Темы</h1>
                <?php if(isset($topics) && !empty($topics)): ?>
                    <?php foreach($topics as $topic): ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3><a href="topic.php?topic_id=<?php echo $topic['topic_id']; ?>"><?php echo htmlspecialchars($topic['title']); ?></a></h3>
                                <p><small>Модератор: <?php echo htmlspecialchars($topic['login']); ?><br />
                                Дата и время: <?php echo htmlspecialchars($topic['datetime']); ?></small></p>
                                <?php if(isset($rights) && $rights == 'MODERATOR'): ?>
                                <form action="topic.php" method="post">
                                    <input type="hidden" name="topic_id" value="<?php echo $topic['topic_id']; ?>">
                                    <button type="submit" name="act" value="delete_topic" class="btn btn-danger"
                                        onclick="return confirm('Удалить тему «<?php echo htmlspecialchars($topic['title']); ?>»?');">Удалить тему</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="text-center">Пока не создано ни одной темы</h3>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(isset($rights) && $rights == 'MODERATOR'): ?>
                <form action="new_topic.php" method="get">
                    <button type="submit" class="btn btn-default btn-block btn-lg">Создать новую тему</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php' ?>
