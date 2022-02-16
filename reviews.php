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
                <img src="resources/post'. $post['id'] .'.jpg" class="cover">
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

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le blog de Pripri</title>
    <link rel="shortcut icon" href="resources/icon.png" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="functions.js"></script>
</head>

<body>
    <header>
        <a href="index.php#home" class="logo">Le blog de Pripri</a>
        <div class="menuToggle"></div>
    </header>

    <ul class="navigation">
        <li><a href="index.php#home" onclick="toggleMenu();">Accueil</a></li>
        <li><a href="index.php#about" onclick="toggleMenu();">A propos</a></li>
        <li><a href="index.php#post" onclick="toggleMenu();">Posts</a></li>
        <li><a href="index.php#contact" onclick="toggleMenu();">Contact</a></li>
    </ul>

    <!-- All Blog Post -->
    <section class="allPost" id="allPost">
        <div class="back">
			<a href="index.php#post">< Retour</a>
		</div>
        <div class="title">
            <h2>Tous Les Posts</h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facilis dicta possimus qui maxime cum corrupti
                iste! Voluptates modi distinctio non alias beatae fuga necessitatibus facere.</p>
        </div>
        <div class="contentBx">
            <?=show_posts($posts, $pdo_comments)?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <a href="index.php#home" class="logo">Le blog de Pripri</a>
        <ul class="footerMenu">
            <li><a href="index.php#home">Accueil</a></li>
            <li><a href="index.php#about">A propos</a></li>
            <li><a href="index.php#post">Posts</a></li>
            <li><a href="index.php#contact">Contact</a></li>
        </ul>
        <ul class="footerMenu2">
            <li><a href="https://www.facebook.com/" target="_blank"><img src="resources/fb.png" class="socialMedia"></a></li>
            <li><a href="https://www.instagram.com/" target="_blank"><img src="resources/insta.png" class="socialMedia"></a></li>
            <li><a href="https://twitter.com/" target="_blank"><img src="resources/twitter.png" class="socialMedia"></a></li>
        </ul>
        <p class="copyrightText">Copyright &#169; 2022. All right Reserved</p>
    </footer>

    <script>
        const menuToggle = document.querySelector('.menuToggle');
        const navigation = document.querySelector('.navigation');
        menuToggle.onclick = function () {
            menuToggle.classList.toggle('active');
            navigation.classList.toggle('active');
        }
        window.addEventListener('scroll', function () {
            const header = document.querySelector('header');
            header.classList.toggle('sticky', window.scrollY > 0);
        })

        function toggleMenu(){
            menuToggle.classList.remove('active');
            navigation.classList.remove('active');
        }
    </script>
</body>
</html>