<?php

    function get_DB()
    {
        $host = "localhost";
        $user = "d-SoftTech";
        $password = "ayomi0828";
        $db_name = "upload_image";

        $dsn = "mysql:host=$host;dbname=$db_name";

        function uncaught(){
            echo "The page is presently unavailable, please try again later <br>";
            file_put_contents("error.txt", date("l F jS, Y (g:ia)", time()) . ":- ". "An uncaught error just occured" . PHP_EOL . PHP_EOL, FILE_APPEND);
        }

        try {
            set_exception_handler('uncaught');
            $conn = new PDO($dsn, $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return $conn;
        } catch (PDOException $e) {
            echo "error loading the page, please try again later <br>";
            file_put_contents("error.txt", date("l F jS, Y (g:ia)", time()) . ":- ". $e->getMessage(). PHP_EOL, FILE_APPEND);
        }
       
    }
?>