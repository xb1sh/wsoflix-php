<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: zalogowany.php');
		exit();
	}

?>
<!DOCTYPE html>
<head>
		<meta charset="UTF-8">
		<title>WSOFLIX</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="shortcut icon" href="img/favicon.png"/>
		<link rel="stylesheet"  href="style.css"/>
		</head>
		<body>
		<!--Nawigacja-->
			<nav id="nav">
				<ul class="container">
					<li><a href="rejestracja.php">Rejestracja</a></li>
					<li><a href="logowanie.php">Logowanie</a></li>
				</ul>
			</nav>
					<!-- Info -->
			    <article id="top">
				<div class="container">
					<div class="row">
						<div class="medium">							
							<span class="tekst tekst-rej">Zajerestruj sie teraz aby ogladac filmys</span>
							<div class = "link link-rej">
								<a href="rejestracja.php" class="link">Rejestracja - załóż darmowe konto!</a>
							</div>
				<?php
					if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
				?>
			</div>
				</div>
					</div>
				</article>
			<footer class="footer"> Stronę opracowal: Dawid Walczak </footer>
		</body>
		</html>
