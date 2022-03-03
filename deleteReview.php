<?php

    // MySQL details
$DATABASE_HOST = 'localhost'; //sql.free.fr
$DATABASE_USER = 'firstmoment'; //blog.pripri
$DATABASE_PASS = 'pripri1902'; //Pripri1902
$DATABASE_REVIEW_NAME = 'blog';

// Connect to database
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_REVIEW_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} catch (PDOException $exception) {
    exit('Failed to connect to database!');
}


if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('DELETE FROM reviews WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
}

?>