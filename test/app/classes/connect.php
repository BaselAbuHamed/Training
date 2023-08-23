    <?php

    $MYSQL_ERRNO = '';
    $MYSQL_ERROR = '';

    function db_connect()
    {
        $host = 'localhost:3307';
        $username = 'root';
        $password = '';
        $dbname = 'quiz_db';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            // Handle the error or display an error message
            die("Database Error: " . $e->getMessage());
        }
    }
