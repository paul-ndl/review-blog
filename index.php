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

$stmt = $pdo_review->prepare('SELECT * FROM reviews ORDER BY submit_date DESC LIMIT 3');
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
        <a href="#home" class="logo">Le blog de Pripri</a>
        <div class="menuToggle"></div>
    </header>

    <ul class="navigation">
        <li><a href="#home" onclick="toggleMenu();">Accueil</a></li>
        <li><a href="#about" onclick="toggleMenu();">A propos</a></li>
        <li><a href="#post" onclick="toggleMenu();">Posts</a></li>
        <li><a href="#contact" onclick="toggleMenu();">Contact</a></li>
    </ul>

    <!-- Banner -->
    <section class="banner" id="home">
        <img src="resources/banner.gif" class="cover">
        <div class="contentBx">
            <h2>Le Blog de Pripri</h2>
            <h4>Critiques litt&eacute;raires</h4>
            <a href="#about" class="btn">A propos</a>
        </div>
    </section>

    <!-- About -->
    <section class="about" id="about">
        <div class="title">
            <h2>A propos</h2>
        </div>
        <div class="contentBx">
            <div class="content">
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequuntur error dolorem sit, provident
                    nisi similique ad doloribus praesentium libero. Cupiditate error, nulla, ratione ullam iusto est,
                    neque culpa amet alias magnam quia? Rerum sequi rem hic libero, explicabo suscipit animi ipsum quae
                    impedit quis delectus eos quasi adipisci quos in! Impedit atque culpa corrupti, consectetur autem
                    repellendus quod quaerat expedita voluptas, sit enim iure laboriosam odit! Praesentium rerum
                    provident, doloremque aspernatur sint quidem architecto, facere id beatae consequatur quaerat quae
                    iste nostrum non qui omnis rem dolorem voluptas laborum cupiditate animi nulla.<br><br>Nemo
                    blanditiis,
                    eligendi minus similique officia adipisci, qui et earum cum corporis animi aut nam quaerat est,
                    beatae ratione nostrum ducimus ut! Beatae rem quos, quisquam fugit
                    molestias repudiandae odio quidem tempora at voluptatibus eaque, autem unde blanditiis, animi
                    voluptatum iure iste sequi deleniti ullam tempore. Iusto laboriosam voluptas officiis eaque
                    voluptatem enim repellendus. Nobis quos omnis quisquam labore est autem, nostrum, in officia odio
                    blanditiis architecto voluptates harum sequi error libero possimus obcaecati numquam porro
                    quibusdam.</p>
            </div>
            <div class="content">
                <div class="imageBx">
                    <img src="resources/img1.jpg" class="cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Blog Post -->
    <section class="post" id="post">
        <div class="title">
            <h2>Derniers Posts</h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facilis dicta possimus qui maxime cum corrupti
                iste! Voluptates modi distinctio non alias beatae fuga necessitatibus facere.</p>
        </div>
        <div class="contentBx">
            <?=show_posts($posts, $pdo_comments)?>
        </div>
        <div class="title">
            <a href="reviews.php" class="btn mgt60">Plus de posts</a>
        </div>
    </section>

    <!-- Contact -->
    <section class="contact" id="contact">
        <div class="title">
            <h2>Contact</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem aperiam incidunt iusto omnis,
                totam provident beatae quos eius animi esse commodi facilis necessitatibus voluptas fugiat.</p>
        </div>
        <div class="title">
            <a href="https://utip.io/" target="_blank" class="btn">Soutenez moi!</a>
        </div>
        <form class="contactForm" action='' method="post">
            <div class="row3">
                <a href="https://www.facebook.com/" target="_blank"><img src="resources/fb.png" class="socialMedia"></a>
                <a href="https://www.instagram.com/" target="_blank"><img src="resources/insta.png" class="socialMedia"></a>
                <a href="https://twitter.com/" target="_blank"><img src="resources/twitter.png" class="socialMedia"></a>
            </div>
            <div class="row">
                <input type="text" name="firstName" placeholder="Pr&eacute;nom" required>
                <input type="text" name="lastName" placeholder="Nom" required>
            </div>
            <div class="row">
                <input type="text" name="mail" placeholder="Adresse email" class="mail" required>
                <input type="text" name="phone" placeholder="Num&eacute;ro t&eacute;l&eacute;phone">
            </div>
            <div class="row2">
                <textarea name="message" placeholder="Message" required></textarea>
            </div>
            <div class="row2">
                <input type="submit" value="Envoyer" class="btn">
            </div>
        </form>

        <?php
			if (isset($_POST) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['mail'])
			&& !empty($_POST['message'])){
				extract($_POST);
				$destinataire ='nadal.paul@gmail.com';
				$expediteur = $firstName . ' ' . $lastName . ' <'.$mail.'>';
				$mail = mail($destinataire, "Nouveau message reçu de ton blog!", $message, $expediteur);
				if($mail)echo'Message envoyé avec succès!'; else echo'Echec Envoi!';
			};
		?>

    </section>

    <!-- Footer -->
    <footer>
        <a href="#home" class="logo">Le blog de Pripri</a>
        <ul class="footerMenu">
            <li><a href="#home">Accueil</a></li>
            <li><a href="#about">A propos</a></li>
            <li><a href="#post">Posts</a></li>
            <li><a href="#contact">Contact</a></li>
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
    </script>
</body>

</html>