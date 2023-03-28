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
					<li><a href="logowanie.php">Logowanie</a></li>
				</ul>
			</nav>
					<!-- Info -->
			    <article id="top">
				<div class="container">
					<div class="row">
						<div class="medium">
						<br/>
						
							<?php
							include('pdo.php');
							session_start();
							
											
								if (isset($_POST['email']))
								{
									
									$test=true;
									
									//Sprawdź poprawność nickname'a
									$login = $_POST['login'];
									
									//Sprawdzenie długości nicka
									if ((strlen($login)<3) || (strlen($login)>20))
									{
										$test=false;
										$_SESSION['e_nick']="Login musi posiadać od 3 do 20 znaków!";
									}
									
									if (ctype_alnum($login)==false)
									{
										$test=false;
										$_SESSION['e_nick']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
									}
									
									// Sprawdzanie czy email jest poprawny
									$email = $_POST['email'];
									$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
									
									if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
									{
										$test=false;
										$_SESSION['e_email']="Podaj poprawny adres e-mail!";
									}
									
									// Sprawdzanie czy haslo jest poprawne
									$haslo1 = $_POST['haslo1'];
									$haslo2 = $_POST['haslo2'];
									
									if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
									{
										$test=false;
										$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
									}
									
									if ($haslo1!=$haslo2)
									{
										$test=false;
										$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
									}	

									$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
									
									//Czy zaakceptowano regulamin?
									if (!isset($_POST['regulamin']))
									{
										$test=false;
										$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
									}				
										
									
									//Zapamiętaj wprowadzone dane
									$_SESSION['fr_nick'] = $login;
									$_SESSION['fr_email'] = $email;
									$_SESSION['fr_haslo1'] = $haslo1;
									$_SESSION['fr_haslo2'] = $haslo2;
									if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
									
									require_once "pdo.php";
									mysqli_report(MYSQLI_REPORT_STRICT);
									
									// sprawdzanie czy podany e-mail jest w bazie
									$result = $PDO->query("select * from logon where email='$email';");
									
										if($result->rowCount() > 0)
									{
										$test=false;
										$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
										header('Location: rejestacja.php');
															
									}
													
									// sprawdzanie czy podany login jest w bazie
									$result = $PDO->query("select * from logon where login='$login';");							
									//print_r($result);
									
										if($result->rowCount() > 0)
									{
												
										$test=false;
										$_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
										header('Location: rejestracja.php');
									}
									
									// dodawanie uzytkownika do bazy
										if ($test==true)
										{
										
											if ($PDO->query("INSERT INTO logon (email,login,password,role,due_date,film) VALUES ('$email', '$login', '$haslo_hash','member',now(),'0');"))
											{
												$_SESSION['udanarejestracja']=true;
												header('Location: arej.php');
											}
												else
											{
													throw new Exception($PDO->error);
											}
												
										}
											
											$PDO->close();
									}	
							
							?>
							<form class="form" method="post">
								<div class="title">Witaj</div>
								<div class="subtitle">Stwórz konto, aby cieszyć się darmowymi filmami!</div>
								Login: <br /> <input id="nick" class="input" type="text" value="<?php
									if (isset($_SESSION['fr_nick']))
									{
										echo $_SESSION['fr_nick'];
										unset($_SESSION['fr_nick']);
									}
								?>" name="login" /><br />
								
								<?php
									if (isset($_SESSION['e_nick']))
									{
										echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
										unset($_SESSION['e_nick']);
									}
								?>
								
								E-mail: <br /> <input id="email" class="input" type="text" value="<?php
									if (isset($_SESSION['fr_email']))
									{
										echo $_SESSION['fr_email'];
										unset($_SESSION['fr_email']);
									}
								?>" name="email" /><br />
								
								<?php
									if (isset($_SESSION['e_email']))
									{
										echo '<div class="error">'.$_SESSION['e_email'].'</div>';
										unset($_SESSION['e_email']);
									}
								?>
								
								Twoje hasło: <br /> <input id="password" class="input" type="password"  value="<?php
									if (isset($_SESSION['fr_haslo1']))
									{
										echo $_SESSION['fr_haslo1'];
										unset($_SESSION['fr_haslo1']);
									}
								?>" name="haslo1" /><br />
								
								<?php
									if (isset($_SESSION['e_haslo']))
									{
										echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
										unset($_SESSION['e_haslo']);
									}
								?>		
								
								Powtórz hasło: <br /> <input id="password" class="input" type="password" value="<?php
									if (isset($_SESSION['fr_haslo2']))
									{
										echo $_SESSION['fr_haslo2'];
										unset($_SESSION['fr_haslo2']);
									}
								?>" name="haslo2" /><br />
								
								<label>
									<input type="checkbox" name="regulamin" <?php
									if (isset($_SESSION['fr_regulamin']))
									{
										echo "checked";
										unset($_SESSION['fr_regulamin']);
									}
										?>/> Akceptuję regulamin
								</label>
								
								<?php
									if (isset($_SESSION['e_regulamin']))
									{
										echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
										unset($_SESSION['e_regulamin']);
									}
								?>	
								
								<br />
								
								<input type="submit" class="submit" value="Zarejestruj się" />
		
						</form>
								

			</div>
				</div>
					</div>
				</article>
			<footer> Stronę opracowal: Dawid Walczak </footer>
		</body>
		</html>
