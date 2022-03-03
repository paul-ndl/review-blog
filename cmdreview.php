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

function show_review($post) {
    $html = '
            <form>
            <div class="reviewData">
                <img class="imgInput" src="resources/post'. $post['id'] .'.jpg">
                <br>
                Titre :
                <br>
                <input name="title" class="smallInput" type="text" value="'. $post['title'] .'" required>
                <br>
                Auteur : 
                <br>
                <input name="author" class="smallInput" type="text" value="'. $post['author'] .'" required>
                <br>
                Date : 
                <br>
                <input name="date" class="smallInput" type="text" value="'. $post['date'] .'" required>
                <br>
                Type : 
                <br>
                <input name="type" class="smallInput" type="text" value="'. $post['type'] .'" required>
                <br>
                Contenu :
                <br>
                <textarea name="content" class="bigInput" required>'. $post['content'] .'</textarea>
                <br>
                <input name="submit_date" class="smallInput" type="date" value='. $post['submit_time'] .' required>
                <br>
                <input name="submit_time" class="smallInput" type="time" value='. substr($post['submit_time'], 11) .' step="2" required>
            </div>
            </form>';
    return $html;
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM reviews WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    exit('ID non reconnu!');
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The first moment is now</title>
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
        <button class="add modify" onclick="modifyReview();">Modifier la review</button>
        <a class="add delete" onclick="deleteReview();">Supprimer une review</a>
    <div>

    <br>
    <br>

    <script type="text/javascript">
        function modifyReview() {
            if (confirm("Es-tu sûre de vouloir modifier cette review?")) {
                element = new FormData(document.querySelector("form"));
                title = element.get('title');
                author = element.get('author');
                date = element.get('date');
                type = element.get('type');
                content = element.get('content');
                submit_date = element.get('submit_date');
                submit_time = element.get('submit_time');
                fetch("modifyReview.php?id=<?=$_GET['id']?>&title=" + title + "&author=" + author + "&date=" + date + "&type=" + type + "&content=" + content + "&submit_time=" + submit_date + " " + submit_time)
                .then(() => document.location.href = "gestion.php");
                return false;
            }
        }

        function deleteReview() {
            if (confirm("Es-tu sûre de vouloir supprimer cette review?")) {
                fetch("deleteReview.php?id=<?=$_GET['id']?>").then(() => document.location.href = "gestion.php");
                return false;
            }
        }
    </script>
    
</body>
</html>