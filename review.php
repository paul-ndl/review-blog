<?php
// MySQL details
$DATABASE_HOST = 'localhost'; //sql.free.fr
$DATABASE_USER = 'root'; //blog.pripri
$DATABASE_PASS = ''; //Pripri1902
$DATABASE_NAME = 'phpreviews';

// Connect to database
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} catch (PDOException $exception) {
    exit('Failed to connect to database!');
}

if (isset($_GET['id'])) {
    // Get all comments by the Page ID ordered by the submit date
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
	<title><?=$post['title']?>, <?=$post['author']?></title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<link href="comments.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="resources/icon.png" />
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

	<!-- Review -->

	<section class="postSection">
		<div class="back">
			<a href="javascript:history.go(-1)">< Retour</a>
			<a href="https://utip.io/" target="_blank">Soutenez moi!</a>
		</div>
		<div class="mainInfo">
			<div class="content">
				<h1><?=$post['title']?></h1>
				<h2><?=$post['author']?></h2>
				<h3><?=$post['date']?></h3>
				<br>
				<div class="etiquetteContent">
					<img src="resources/etiquette.png" class="etiquette">
					<p><?=$post['type']?></p>
				</div>
				<br>
				<img src="resources/post<?=$post['id']?>.jpg" class="mainPicture">
			</div>
			<div class="content">
				<?=$post['content']?>
			</div>
		</div>
	</section>

	<!-- Comments -->
	<div class="comments"></div>

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
			<li><a href="https://www.facebook.com/" target="_blank"><img src="resources/fb.png" class="socialMedia"></a>
			</li>
			<li><a href="https://www.instagram.com/" target="_blank"><img src="resources/insta.png"
						class="socialMedia"></a></li>
			<li><a href="https://twitter.com/" target="_blank"><img src="resources/twitter.png" class="socialMedia"></a>
			</li>
		</ul>
		<p class="copyrightText">Copyright &#169; 2022. All right Reserved</p>
	</footer>

	<script>
		fetch_comments(<?=$post['id']?>);
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