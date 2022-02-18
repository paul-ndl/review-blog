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


if (isset($_GET['id']) and isset($_GET['title']) and isset($_GET['author']) and isset($_GET['date']) and isset($_GET['type']) and isset($_GET['content']) and isset($_GET['submit_time'])) {
    $stmt = $pdo->prepare('SELECT * FROM reviews WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($post['title'] != $_GET['title']) {
        $stmt = $pdo->prepare('UPDATE reviews SET title = ? WHERE id = ?');
        $stmt->execute([ $_GET['title'], $_GET['id'] ]);  
    }
    if ($post['author'] != $_GET['author']) {
        $stmt = $pdo->prepare('UPDATE reviews SET author = ? WHERE id = ?');
        $stmt->execute([ $_GET['author'], $_GET['id'] ]);  
    }
    if ($post['date'] != $_GET['date']) {
        $stmt = $pdo->prepare('UPDATE reviews SET date = ? WHERE id = ?');
        $stmt->execute([ $_GET['date'], $_GET['id'] ]);  
    }
    if ($post['type'] != $_GET['type']) {
        $stmt = $pdo->prepare('UPDATE reviews SET type = ? WHERE id = ?');
        $stmt->execute([ $_GET['type'], $_GET['id'] ]);  
    }
    if ($post['content'] != $_GET['content']) {
        $stmt = $pdo->prepare('UPDATE reviews SET content = ? WHERE id = ?');
        $stmt->execute([ $_GET['content'], $_GET['id'] ]);  
    }
    if ($post['submit_time'] != $_GET['submit_time']) {
        $stmt = $pdo->prepare('UPDATE reviews SET submit_time = ? WHERE id = ?');
        $stmt->execute([ $_GET['submit_time'], $_GET['id'] ]);  
    }
} else {
    exit('Cette page n\'existe pas!');
}
?>