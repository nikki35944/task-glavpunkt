<?php

class Comments
{
    public static function addComments($connection) {
        $comments = self::getDecodedComments();

        if (isset($_POST['addBtn'])) {
            $commentsCount = 0;
            foreach($comments as $comment) {
                $postId = $comment['postId'];
                $id = $comment['id'];
                $name = $comment['name'];
                $email = $comment['email'];
                $body = $comment['body'];


                $STH = $connection->prepare("INSERT INTO comments (postId, id, name, email, body) 
                                values (:postId, :id, :name, :email, :body)");
                $STH->bindParam(":postId", $postId);
                $STH->bindParam(":id", $id);
                $STH->bindParam(":name", $name);
                $STH->bindParam(":email", $email);
                $STH->bindParam(":body", $body);
                $STH->execute();
                $commentsCount++;
            }
        }
        return $commentsCount;
    }

    public static function searchComments($connection) {
        if (isset($_POST['searchBtn'])) {
            $query = $_POST['search'];
            $count = strlen(trim(strval($query)));
//            проверка есть ли данные в базе
            if (Database::checkTableData() == false) {
                echo 'Данные в базе отсутствуют';

                return false;
            } elseif ($count > 2) {
                $query = "%$query%";
                $STH = $connection->prepare("SELECT name, body FROM comments
                                    WHERE body LIKE :query");
                $STH->bindParam(':query',$query);
                $STH->execute();
                $searchedComments = $STH->setFetchMode(PDO::FETCH_ASSOC);
                $searchedComments = $STH->fetchAll();

                return $searchedComments;
            } elseif ($count < 3) {
                echo 'Введите более 3х знаков для поиска';

                return false;
            }  else {
                return false;
            }
        }
    }

    private static function getDecodedComments() {
        $jsonComments = file_get_contents('https://jsonplaceholder.typicode.com/comments');
        $comments = json_decode($jsonComments, true);

        return $comments;
    }
}
