<?php
    include 'classes/User.php';
    include 'classes/Topic.php';
    
    $user = new User();
    $login = $user->getLogin();
    $rights = $user->getRights();
    $topics = Topic::getTopicsList();
    include 'templates/topics_list.php';
?>
