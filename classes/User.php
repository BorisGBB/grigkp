<?php
    include_once 'DB.php';
    include_once __DIR__ . '/../config/fields.php';
    class User {
        private $db;
        private $user_id = null;
        private $login = null;
        private $rights = null;
        
        public function __construct($auth = true) {
            $this->db = DB::getInstance()->connect();
            
            if($auth) {
                session_start();
                if(isset($_SESSION['user_id'])) {
                    $this->user_id = $_SESSION['user_id'];
                    $query = 'SELECT login, rights FROM users WHERE user_id = ?';
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('i', $this->user_id);
                    $stmt->execute();
                    $stmt->bind_result($this->login, $this->rights);
                    $stmt->fetch();
                    $stmt->close();
                    if($this->login === null) {
                        $this->user_id = null;
                        session_destroy();
                    }
                    
                }
                elseif(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                    $this->login = filter_input(INPUT_POST, 'login', FILTER_DEFAULT);
                    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
                    $hash = '';
                    $query = 'SELECT password, user_id, login, rights FROM users WHERE login = ?';
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('s', $this->login);
                    $stmt->execute();
                    $stmt->bind_result($hash, $this->user_id, $this->login, $this->rights);
                    $stmt->fetch();
                    $stmt->close();
                    if(!password_verify($password, $hash)) {
                        throw new Exception('Неверный логин или пароль');
                    }
                    $_SESSION['user_id'] = $this->user_id;
                }
            }
            elseif(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $values = array();
                $invalid_fields = array();
                
                foreach(REG_FORM as $field => $info) {
                    $val[$field] = filter_input(INPUT_POST, $field, $info['filter']);
                    if(!$val[$field]) {
                        $invalid_fields[] = $info['name'];
                    }
                }
                
                if(!empty($invalid_fields)) {
                    throw new Exception('Неверно заполнены следующие поля: ' . implode(', ', $invalid_fields));
                }
                
                $query = 'SELECT user_id FROM users WHERE login = ?';
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('s', $val['login']);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows > 0) {
                    $stmt->close();
                    throw new Exception('Пользователь с таким логином уже существует');
                }
                $stmt->close();
                
                $val['password'] = password_hash($val['password'], PASSWORD_DEFAULT);
                $query = 'INSERT INTO users (name, surname, phone, email, login, password) VALUES(?, ?, ?, ?, ?, ?)';
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ssssss', $val['name'], $val['surname'], $val['phone'], $val['email'], $val['login'], $val['password']);
                if(!$stmt->execute()) {
                    $stmt->close();
                    throw new Exception('Неизвестная ошибка');
                }
                $stmt->close();
                
                $this->user_id = $this->db->insert_id;
                $query = 'SELECT login, rights FROM users WHERE user_id = ?';
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('i', $this->user_id);
                $stmt->execute();
                $stmt->bind_result($this->login, $this->rights);
                $stmt->fetch();
                $stmt->close();
                if(!$this->login) {
                    throw new Exception('Неизвестная ошибка');
                }
            }
        }
        
        public function getLogin() {
            return $this->login;
        }
        
        public function getRights() {
            return $this->rights;
        }
        
        public function getUserID() {
            return $this->user_id;
        }
        
        public function logout() {
            if($this->user_id) {
                $this->user_id = null;
                $this->login = null;
                $this->rights = null;
                session_destroy();
                return true;
            }
            else {
                return false;
            }
        }
    }
