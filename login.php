<?php
    include_once 'classes/User.php';
        
    try {
        $user = new User();
        $login = $user->getLogin();
        $act = filter_input(INPUT_GET, 'act', FILTER_DEFAULT);
        if($act == 'logout') {
            $logout = $user->logout();
            unset($login);
            if(!$logout) {
                header('Location: index.php');
            }
        }
        elseif($user->getUserID()) {
            header('Location: index.php');
        }
    }
    catch(Exception $e) {
        $success = false;
        $error = $e->getMessage();
    }
    
    include 'templates/login_form.php';
