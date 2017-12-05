<?php
    include_once 'classes/User.php';
    
    if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
        $success = true;
        try {
            $new_user = new User(false);
        }
        catch(Exception $e) {
            $success = false;
            $error = $e->getMessage();
        }
    }
    else {
        $user = new User();
        $login = $user->getLogin();
    }
    include 'templates/reg_form.php';
