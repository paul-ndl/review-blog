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

function modify_review($post)
{
    echo "salut";
}

function show_review($post) {
    $html = '
            <div class="reviewData">
                <img class="imgInput" src="resources/post'. $post['id'] .'.jpg">
                <br>
                Titre :
                <br>
                <input name="title" class="smallInput" type="text" value="'. $post['title'] .'">
                <br>
                Auteur : 
                <br>
                <input name="author" class="smallInput" type="text" value="'. $post['author'] .'">
                <br>
                Date : 
                <br>
                <input name="date" class="smallInput" type="text" value="'. $post['date'] .'">
                <br>
                Type : 
                <br>
                <input name="type" class="smallInput" type="text" value="'. $post['type'] .'">
                <br>
                Contenu :
                <br>
                <textarea name="content" class="bigInput">'. $post['content'] .'</textarea>
            </div>';
    return $html;
}


$stmt = $pdo->prepare('SELECT * FROM reviews WHERE id = ?');
$stmt->execute([ $_GET['id'] ]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le blog de Pripri</title>
    <link rel="shortcut icon" href="resources/icon.png" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="gestion.css">
    <script src="functions.js"></script>
</head>

<body>
    <!-- List all reviews -->
    <div>
        <?=show_review($post)?>
        <br>
        <a class="add modify" onclick="modifyReview();">Modifier la review</a>
        <a class="add delete" href="gestion.php">Supprimer une review</a>
    <div>

    <br>
    <br>

    <script type="text/javascript">
        function modifyReview() {
            fetch("modifyReview.php").then(response => console.log(response['statusText']));
            return false;
        }
    </script>
    
</body>
</html>