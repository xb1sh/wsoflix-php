<?php
include('pdo.php');
	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: logowanie.php');
		exit();
	}

	require_once "pdo.php";
		
	if($PDO->connect_errno!=0)
	{
		echo"nie działa baza";
	}
	else
	{
		
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$result = $PDO->query("select * from logon where login='$login';");
	
					
				if($result->rowCount() > 0)
		
				{	
					$row = $result->fetch();
					if (password_verify($haslo, $row['password']))
					{
						//echo"dziala haslo";
						$_SESSION['zalogowany'] = true;
						$_SESSION['login'] = $row['login'];
						$_SESSION['email'] = $row['email'];
						
					
						unset($_SESSION['blad']);
						$result->free_result();
						header('Location: zalogowany.php');
					
					}
					else 
					{
						$_SESSION['blad'] = '<span style="color:#c94d4d">Nieprawidłowy login lub hasło!</span>';
						header('Location: logowanie.php');
						
					}
					
				}
				else {		
			
				
						$_SESSION['blad'] = '<span style="color:#c94d4d">Nieprawidłowy login lub hasło!</span>';
						header('Location: logowanie.php');
			}
		
		$PDO->close();
	}
		
	
?>
