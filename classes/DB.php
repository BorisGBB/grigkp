<?php

    include __DIR__ . '/../config/db.php';
    
    class DB {
        private static $instance = null;
        private $mysqli = null;
        private function __construct() {}
        private function __clone() {}
        private function __wakeup() {}
        
        public static function getInstance() {
            if(self::$instance === null) {
                self::$instance = new self;
            }
            return self::$instance;
        }
        
        public function connect() {
            if($this->mysqli === null) {
                $this->mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
                if($this->mysqli->connect_error) {
                    throw new Exception('Нет подключения к базе данных');
                }
            }
            return $this->mysqli;
        }
    }
