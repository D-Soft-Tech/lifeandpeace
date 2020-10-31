<?php

    function get_DB()
    {
        $host = "us-cdbr-east-02.cleardb.com";
        $user = "b39783f939332b";
        $password = "021533dc36bd794";
        $db_name = "heroku_be5ce62eb396741";

        $dsn = "mysql:host=$host;dbname=$db_name";

        function uncaught(){
            echo "The page is currently unavailable, please try again later <br>";
            file_put_contents("error.txt", date("l F jS, Y (g:ia)", time()) . ":- ". "An uncaught error just occured" . PHP_EOL . PHP_EOL, FILE_APPEND);
        }
        try {
            //set_exception_handler('uncaught');
            $conn = new PDO($dsn, $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return $conn;
        } catch (PDOException $e) {
            echo "error loading the page, please try again later <br>";
            file_put_contents("error.txt", date("l F jS, Y (g:ia)", time()) . ":- ". $e->getMessage(). PHP_EOL, FILE_APPEND);
        }
       
    }
?>