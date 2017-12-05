<?php
    include 'classes/User.php';
    include 'classes/Topic.php';
    
    $user = new User();
    $login = $user->getLogin();
    $rights = $user->getRights();
    
    if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
        $success = true;
        try {
            $topic = new Topic($user);
        }
        catch(Exception $e) {
            $success = false;
            $error = $e->getMessage();
        }
    }
    include 'templates/new_topic_form.php';
?>
