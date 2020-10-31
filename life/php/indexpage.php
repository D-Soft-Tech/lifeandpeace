<?php

    class most_recent_event{

        public function get_DB()
        {
            $host = "localhost";
            $user = "d-SoftTech";
            $password = "oloyede0828";
            $db_name = "life_and_peace";
    
            $dsn = "mysql:host=$host;dbname=$db_name";
    
            function uncaughts(){
                echo "The page is presently unavailable, please try again later <br>";
                file_put_contents("error.txt", date("l F jS, Y (g:ia)", time()) . ":- ". "An uncaught error just occured" . PHP_EOL . PHP_EOL, FILE_APPEND);
            }
    
            try {
                set_exception_handler('uncaughts');
                $conn = new PDO($dsn, $user, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                return $conn;
            } catch (PDOException $e) {
                echo "error loading the page, please try again later <br>";
                file_put_contents("error.txt", date("l F jS, Y (g:ia)", time()) . ":- ". $e->getMessage(). PHP_EOL, FILE_APPEND);
            }
           
        }


        public function __construct()
        {
            $this->conn = get_DB();;
        }


        public function upcoming()
        {
            $sql = "
                    SELECT * FROM event ORDER BY event_id DESC LIMIT 1
                    
                    ";

            $result = $this->conn->query($sql);

            while($results = $result->fetch(PDO::FETCH_ASSOC)){
                echo '"'. $results['theme']. '"' . " - " . $results['anchor'];
            }
        } 

        
        public function call_sermon()
        {
            $sql = "
                        SELECT id, title, ext, ext2, sermon_by, details FROM message WHERE type = 'audio' ORDER BY id DESC LIMIT 3
                    ";
        
            $featured_sermon = $this->conn->query($sql);
            return $featured_sermon;
        }


        public function prog_and_events()
        {
            $sql = "
                        SELECT * FROM event ORDER BY event_id DESC LIMIT 11
                    ";
            
            $event = $this->conn->query($sql);
            return $event;
        }

        public function articles()
        {
            $sql = "
                        SELECT * FROM articles ORDER BY articles_id DESC LIMIT 2
                    ";
            
            $article = $this->conn->query($sql);
            return $article;
        }

        public function message()
        {    
            $sql = "
                        SELECT * FROM message ORDER BY id DESC LIMIT 4
                    ";
        
            $sermon = $this->conn->query($sql);
            return $sermon;
        }

        public function donation()
        {
            $sql = "
                        SELECT * FROM donation WHERE status = 'on_going' ORDER BY id DESC LIMIT 1
                    ";
            
            $donation = $this->conn->query($sql);
            return $donation;
        }

        public function gallery()
        {
            $sql = "
                        SELECT * FROM gallery ORDER BY gallery_id DESC LIMIT 8
                    ";

            $gallery = $this->conn->query($sql);
            return $gallery;
        }

        public function quotes(){
            $sql = "
                        SELECT * FROM quote ORDER BY quote_id DESC LIMIT 10
                    ";

            $quotes = $this->query($sql);
            return $quotes;
        }

        public function db_conn()
        {
            return $this->conn;
        }
        
    }

?>