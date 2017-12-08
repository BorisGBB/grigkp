<?php
    define('REG_FORM', array(
        'name'      =>  array('name' => 'Имя',              'filter' => FILTER_DEFAULT,         'type' => 'text'),
        'surname'   =>  array('name' => 'Фамилия',          'filter' => FILTER_DEFAULT,         'type' => 'text'),
        'phone'     =>  array('name' => 'Номер телефона',   'filter' => FILTER_VALIDATE_REGEXP, 'type' => 'tel', 'options' => array('regexp' => '/^[0-9]+$/')),
        'email'     =>  array('name' => 'Email',            'filter' => FILTER_VALIDATE_EMAIL,  'type' => 'email'),
        'login'     =>  array('name' => 'Логин',            'filter' => FILTER_DEFAULT,         'type' => 'text'),
        'password'  =>  array('name' => 'Пароль',           'filter' => FILTER_DEFAULT,         'type' => 'password')
    ));
