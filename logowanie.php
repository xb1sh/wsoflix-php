<?php
 
	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: index.php');
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
					<li><a href="index.php">WSOFLIX</a></li>
					<li><a href="rejestracja.php">Rejestracja</a></li>
				</ul>
			</nav>
					<!-- Info -->
			    <article id="top">
				<div class="container">
					<div class="row">
						<div class="medium">
						<br/>
						
							<div class="form">
							<form action="logphp.php" method="post">
								Login: <br /> <input id="nick" class="input" type="text" name="login" /> <br />
								Hasło: <br /> <input id="password" class="input" type="password" name="haslo" /> <br />
								<input class="submit" type="submit" value="Zaloguj się" />
							</form>
							</div>
						
			</div>
				</div>
					</div>
				</article>
			<footer> Stronę opracowal: Dawid Walczak </footer>
		</body>
		</html>
