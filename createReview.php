<?php

    // MySQL details
$DATABASE_HOST = 'localhost'; //sql.free.fr
$DATABASE_USER = 'root'; //blog.pripri
$DATABASE_PASS = ''; //Pripri1902
$DATABASE_REVIEW_NAME = 'phpreviews';

// Connect to database
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_REVIEW_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} catch (PDOException $exception) {
    exit('Failed to connect to database!');
}


if (isset($_GET['title']) and isset($_GET['author']) and isset($_GET['date']) and isset($_GET['type']) and isset($_GET['content']) and isset($_GET['submit_time'])) {
    $stmt = $pdo->prepare('INSERT INTO reviews (id, title, author, date, type, content, submit_time) VALUES (NULL, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$_GET['title'], $_GET['author'], $_GET['date'], $_GET['type'], $_GET['content'], $_GET['submit_time']]);
} else {
    exit('Cette page n\'existe pas!');
}
?>