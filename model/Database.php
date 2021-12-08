<?php

class Database
{
    public static function createTable($connection) {
        if (isset($_POST['addBtn'])) {
            $sql = "CREATE TABLE IF NOT EXISTS posts (
            userId INT(6) NOT NULL,
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(50) NOT NULL,
            body LONGTEXT
        );
                CREATE TABLE IF NOT EXISTS comments (
            postId INT(6) NOT NULL,
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            email VARCHAR(50) NOT NULL,
            body LONGTEXT
        )";

            try {
                $connection->query($sql);
            } catch (PDOException $e) {
                echo "Ошибка создания таблицы: " . $e->getMessage();
            }
        }
    }

    public static function checkTableData() {
        $connection = Connection::connect();
        $sql = "SHOW TABLES IN tz";

        $result = $connection->query($sql);
        $rows = $result->rowCount();

        return $rows > 0;
    }
}