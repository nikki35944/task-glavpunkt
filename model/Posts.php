<?php

class Posts
{

    public static function addPosts($connection) {
//        Получаем посты из json
        $posts = self::getDecodedPosts();

        if (isset($_POST['addBtn'])) {
            $postsCount = 0;
            foreach($posts as $post) {
                $userId = $post['userId'];
                $id = $post['id'];
                $title = $post['title'];
                $body = $post['body'];

                $STH = $connection->prepare("INSERT INTO posts (userId, id, title, body) values (:userId, :id, :title, :body)");
                $STH->bindParam(":userId", $userId);
                $STH->bindParam(":id", $id);
                $STH->bindParam(":title", $title);
                $STH->bindParam(":body", $body);
                $STH->execute();
                $postsCount++;
            }
        }

        return $postsCount;
    }


    private static function getDecodedPosts() {
        $jsonPosts = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        $posts = json_decode($jsonPosts, true);

        return $posts;
    }
}