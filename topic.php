<?php
    include 'classes/User.php';
    include 'classes/Topic.php';
    
    $user = new User();
    $login = $user->getLogin();
    $rights = $user->getRights();
    $topic = new Topic();
    $topic_id = $topic->getTopicID();
    $title = $topic->getTitle();
    $moderator = $topic->getModerator();
    
    if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
        $success = true;
        $action = filter_input(INPUT_POST, 'act', FILTER_DEFAULT);
        try {
            switch($action) {
                case 'add_post':
                    $topic->addPost($user);
                    $message = 'Сообщение отправлено';
                    break;
                    
                case 'delete_topic':
                    $topic->deleteTopic($user);
                    header('Location: index.php');
                    exit;
                    break;
                    
                case 'delete_post':
                    Topic::deletePost($user);
                    $message = 'Сообщение удалено';
                    break;
            }
            
        }
        catch(Exception $e) {
            $success = false;
            $error = $e->getMessage();
        }
        $posts = $topic->getPosts();
    }
    else {
        if(!$topic->getTopicID()) {
            header('Location: index.php');
            exit;
        }
        $posts = $topic->getPosts();
    }
    
    include 'templates/posts.php';
?>
