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
        try {
            $topic->addPost($user);
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
