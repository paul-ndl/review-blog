<?php
// MySQL details
$DATABASE_HOST = 'localhost'; //sql.free.fr
$DATABASE_USER = 'root'; //blog.pripri
$DATABASE_PASS = ''; //Pripri1902
$DATABASE_REVIEW_NAME = 'phpreviews';
$DATABASE_COMMENTS_NAME = 'phpcomments';

// Connect to database
try {
    $pdo_review = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_REVIEW_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    $pdo_comments = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_COMMENTS_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} catch (PDOException $exception) {
    exit('Failed to connect to database!');
}

function show_posts($posts, $pdo_comments) {
    $html = '';
    foreach ($posts as $post) {
        $stmt = $pdo_comments->prepare('SELECT COUNT(*) AS total_comments FROM comments WHERE page_id = ?');
        $stmt->execute([ $post['id'] ]);
        $comments_info = $stmt->fetch(PDO::FETCH_ASSOC);
        $html .= '
        <div class="postBox">
            <div class="imgBx">
                <img src="'. $post['img'] .'" class="cover">
            </div>
            <div class="textBx">
                <h1>'. $post['title'] .'</h1>
                <h2>'. $post['author'] .'</h2>
                <h3>'. substr($post['content'], 0, 100) .'...</h3>
                <a href="review.php?id=' . $post['id'] .'" class="btn">Lire plus</a>
                <div class="info">
                    <img src="resources/com.png">'. $comments_info['total_comments'] .'
                </div>
            </div>
        </div>';
    }
    return $html;
}



$stmt = $pdo_review->prepare('SELECT * FROM reviews ORDER BY submit_date DESC');
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$posts = array_slice($posts, 0, 3);

?>

<?=show_posts($posts, $pdo_comments)?>

