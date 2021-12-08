<?php


class Connection
{

    public static function connect() {
        include 'config.php';

        try {
            $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $DBH;
        } catch(PDOException $e) {
            echo "Ошибка соединения: " . $e->getMessage();
        }
    }
}