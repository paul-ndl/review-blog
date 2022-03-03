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

function show_reviews($posts) {
    $html = '<table>
                <tr>
                    <th>id</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Contenu</th>
                    <th>Date de création</th>
                    <th>Modifier</th>
                </tr>';
    foreach ($posts as $post) {
        $html .= '
            <tr>
                <td>'. $post['id'] .'</td>
                <td>'. $post['title'] .'</td>
                <td>'. $post['author'] .'</td>
                <td>'. $post['date'] .'</td>
                <td>'. $post['type'] .'</td>
                <td>'. substr($post['content'], 0, 100) .'...</td>
                <td>'. $post['submit_time'] .'</td>
                <td><a href="cmdreview.php?id='. $post['id'] .'">Modifier</a></td>
            </tr>';
    }
    $html.='</table>';
    return $html;
}



$stmt = $pdo->prepare('SELECT * FROM reviews ORDER BY submit_time ASC');
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <?=show_reviews($posts)?>
        <br>
        <a class="add" href="newReview.php">Ajouter une review</a>
    <div>

    <br>
    <br>
    
</body>
</html>