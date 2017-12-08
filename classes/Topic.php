<?php
    include_once 'DB.php';
    include_once 'User.php';
    
    class Topic {
        private $db;
        private $topic_id = null;
        private $title = null;
        private $datetime = null;
        private $moderator = null;
        
        public function __construct(User $user = null) {
            $this->db = DB::getInstance()->connect();
            
            if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $topic_id = filter_input(INPUT_POST, 'topic_id', FILTER_VALIDATE_INT);
            }
            else {
                $topic_id = filter_input(INPUT_GET, 'topic_id', FILTER_VALIDATE_INT);
            }
            
            if($user === null && $topic_id) {
                $query = 'SELECT topic_id, title, datetime, login FROM topics INNER JOIN users USING(user_id) WHERE topic_id = ?';
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('i', $topic_id);
                $stmt->execute();
                $stmt->bind_result($this->topic_id, $this->title, $this->datetime, $this->moderator);
                $stmt->fetch();
                $stmt->close();
            }
            elseif($user !== null && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $user_id = $user->getUserID();
                $rights = $user->getRights();
                
                if(!$user_id) {
                    throw new Exception('Для выполнения этой операции вам необходимо авторизоваться');
                }
                if($rights != 'MODERATOR') {
                    throw new Exception('Только модераторы могут создавать новые темы');
                }
                
                $title = filter_input(INPUT_POST, 'title', FILTER_DEFAULT);
                if(!$title) {
                    throw new Exception('Не заполнено поле Название темы');
                }
                
                $query = 'INSERT INTO topics (title, datetime, user_id) VALUES (?, NOW(), ?)';
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('si', $title, $user_id);
                if(!$stmt->execute()) {
                    $stmt->close();
                    throw new Exception('Неизвестная ошибка');
                }
                
                $this->topic_id = $this->db->insert_id;
                $stmt->close();
                $query = 'SELECT title, datetime, login FROM topics INNER JOIN users USING(user_id) WHERE topic_id = ?';
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('i', $this->topic_id);
                $stmt->execute();
                $stmt->bind_result($this->title, $this->datetime, $this->moderator);
                $stmt->fetch();
                $stmt->close();
            }
        }
        
        public function getTopicID() {
            return $this->topic_id;
        }
        
        public function getTitle() {
            return $this->title;
        }
        
        public function getDateTime() {
            return $this->datetime;
        }
        
        public function getModerator() {
            return $this->moderator;
        }
        
        public static function getTopicsList() {
            $db = DB::getInstance()->connect();
            $query = 'SELECT topic_id, title, DATE_FORMAT(datetime, "%d.%m.%Y %h:%i:%s") AS datetime, login FROM topics INNER JOIN users USING(user_id) ORDER BY datetime DESC';
            $result = $db->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        public function getPosts() {
            $query = 'SELECT post_id, text, DATE_FORMAT(datetime, "%d.%m.%Y %h:%i:%s") AS datetime, login FROM posts INNER JOIN users USING(user_id) WHERE topic_id = ? ORDER BY datetime ASC';
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $this->topic_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        public function addPost(User $user) {
            $user_id = $user->getUserID();
            if(!$user_id) {
                throw new Exception('Для выполнения этой операции вам необходимо авторизоваться');
            }
            
            $text = filter_input(INPUT_POST, 'text', FILTER_DEFAULT);
            if(!$text) {
                throw new Exception('Не заполнено поле Текст');
            }
            $query = 'INSERT INTO posts (text, datetime, user_id, topic_id) VALUES (?, NOW(), ?, ?)';
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sii', $text, $user_id, $this->topic_id);
            if(!$stmt->execute()) {
                $stmt->close();
                throw new Exception('Неизвестная ошибка');
            }
            $stmt->close();
        }
        
        public function deleteTopic(User $user) {
            $rights = $user->getRights();
            if($rights != 'MODERATOR') {
                throw new Exception('Только модераторы могут удалять темы');
            }
            
            $query = 'DELETE FROM topics WHERE topic_id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $this->topic_id);
            if(!$stmt->execute()) {
                $stmt->close();
                throw new Exception('Неизвестная ошибка');
            }
            $stmt->close();
        }
        
        public static function deletePost(User $user) {
            $rights = $user->getRights();
            if($rights != 'MODERATOR') {
                throw new Exception('Только модераторы могут удалять сообщения');
            }
            
            $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
            if(!$post_id) {
                throw new Exception('Неизвестная ошибка');
            }
            $db = DB::getInstance()->connect();
            $query = 'DELETE FROM posts WHERE post_id = ?';
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $post_id);
            if(!$stmt->execute()) {
                $stmt->close();
                throw new Exception('Неизвестная ошибка');
            }
            $stmt->close();
        }
    }


