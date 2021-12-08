<?php

include 'autoload.php';
function var_dumper($stmt) {
    echo "<pre>";
    var_dump($stmt);
    echo "</pre>";
}

$connection = Connection::connect();
Database::createTable($connection);
$tableData = Database::checkTableData();
$postsCount = Posts::addPosts($connection);
$commentsCount = Comments::addComments($connection);


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-4">
            <div class="card">
                <?php if ($tableData == false):  ?>
                <form action="" method="POST">
                    <p>Загрузить посты и комментарии в бд</p>
                    <button name="addBtn" class="btn btn-primary">Загрузить</button>
                </form>
                <?php else: ?>
                <p>Данные загружены в базу</p>
                <p>
                    <?php
                    if ($postsCount && $commentsCount) {
                        echo "Загружено $postsCount записей и $commentsCount комментариев";
                    }
                    ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <p>Поиск по тексту комментариев</p>
                <?php $searchedComments = Comments::searchComments($connection); ?>
                <form action="" method="POST">
                    <input type="text" name="search">
                    <button name="searchBtn" class="btn btn-primary">Найти</button>
                </form>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</div>

<div class="container">
    <table class="table">
        <tr>
            <th>Имя</th>
            <th>Комментарий</th>
        </tr>

        <?php
        if ($searchedComments == true)
            foreach($searchedComments as $searchedComment) {
                echo '<tr>';
                echo '<td>' . $searchedComment['name'] . '</td>';
                echo '<td>' . $searchedComment['body'] . '</td>';
                echo '</tr>';
            }

        ?>
    </table>
</div>



</body>
</html>