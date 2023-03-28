<?php
	include('pdo.php');
	session_start();
	
	if (!isset($_SESSION['zalogowany']))
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
					<li><?php echo "<p style='color:white;'>Witaj ".$_SESSION['login'].'!'; ?></li>
					<li> <a href="wyloguj.php">Wyloguj się!</a> </p></li>
				</ul>
			</nav>
					<!-- Info -->
			    <article id="top">
				<div class="container">
					<div class="row">
						<div class="medium">					
					<?php
						$login = $_SESSION['login'];
						$result = $PDO->query("select role from logon where login='$login';");
						$row = $result->fetch();
						
						// print_r($row);
						$s="";
						$wybor=0;
						
						$fid=0;
							if($row['role']=="admin")
							{	
								if((isset($_GET['wybor'])))
								{
									$wybor=$_GET['wybor'];
								}; 
							
								echo "<center><br/><a href='zalogowany.php?wybor=1' class='submit'>Wyszukaj film</a></center>";
								echo"<center><a href='zalogowany.php?wybor=2' class='submit'>Dodaj inny film</a></center>";	
				 
					switch($wybor)
					{
						case 1:	
									
									
									$atom=0;
									if((isset($_POST['atom'])))
									{
										$atom=$_POST['atom'];
									};
							
								echo "
									<form name='dane' action='zalogowany.php?wybor=1&atom='$atom'' method='post'><br/>
									<center style='color:white;'>Wybierz film: <select name='atom'></center>";
							 
										$result = $PDO->query("select * from filmy order by fid asc;");
								     //$result = $PDO->query("select gatunek from filmy where gatunek='$gatunek'limit 1;");
										//$row = $result->fetchAll();
										$row=$result->fetchAll(PDO::FETCH_ASSOC);
										foreach($row as $row){
											
												$s="";
												if($row['fid']==$atom) {$s=" selected";};
												echo "<option value=$row[fid] $s>$row[tytul]</option>";
											}
											
									
								echo "</select><br/>
											   <input type='submit' value='Szukaj' />
											    </form><br/>";
					            echo "<center><table border='1'></center>
												<tr style='color:white;'>
												   
													<td>Gatunek</td>
													<td>Tytuł</td>
													<td>Premiera</td>
													<td><a class='ar'href='zalogowany.php?wybor=3&usun=$row[fid]'>Usuń</td>	
													
												</tr>";		
												$fid=$_POST['fid'];
											    $result= $PDO->query("select * from filmy where fid='$atom';");
												$row=$result->fetchAll(PDO::FETCH_ASSOC);
												foreach ($row as $row){
													
														echo "<tr>
														
														<td style='color:white;'>$row[gatunek]</td>
														<td style='color:white;'>$row[tytul]</td>
														<td style='color:white;'>$row[premiera]</td>
														</tr>";
													
													echo "</table>";
												}	
													break;
								case 2:
									include('pdo.php');
									echo"
										<form name='dane' action='zalogowany.php?wybor=2' method='post'><br/>
										<div class='tabela'>
										Gatunek: <input type='text' name='gatunek' class='input'/><br/>
										Tytuł: <input type='text' name='tytul' class='input'/><br/>
										Premiera: <input type='text' name='premiera' class='input'/><br/>
										<input type='submit' value='Dodaj' />
										</div>
										</form>"; 	
							    $tytul=$_POST['tytul'];
								$gatunek=$_POST['gatunek'];
								$premiera=$_POST['premiera'];
								if((isset($_POST['gatunek']))&&(isset($_POST['tytul']))&&(isset($_POST['premiera'])))
								{
									
										if ($PDO->query("INSERT INTO filmy (tytul,gatunek,premiera,cena) VALUES ('$tytul', '$gatunek', '$premiera','0')"))
										{
											echo "Dane zostały zaktualizowane";	
											print_r($gatunek);
										}
										
										else echo "Nie dodano danych";
										$result=$PDO->query("INSERT INTO filmy (tytul,gatunek,cena,premiera) VALUES ('$tytul','$gatunek','0','$premiera';");
										
											  echo "<a href='zalogowany.php?wybor=1'>Wróć!</a>";
									
								}
									
								$PDO->close();
								
								case 3:
									
							
								     if(isset($_GET['usun']))
											{
											$usun=$_GET['usun'];
											$result=$PDO->query("select * from filmy where fid='$usun' LIMIT 1;");
											$row = $result->fetch();
											$result= $PDO->query("delete from filmy where fid ='$usun';");
											
											}
												echo "Czy na pewno chcesz usunąć te dane?";
												echo "<form action='zalogowany.php?wybor=3&usun=$usun' method='post'>		
												Gatunek: <input type='text' value='$row[gatunek]' disabled /><br/> 
												Tytul: <input type='text' value='$row[tytul]' disabled /><br/>
												Premiera: <input type='text' value='$row[premiera]' disabled /><br/>
												<input type='submit' value='TAK' />
												<input type='button' value='NIE' OnClick=window.history.back() />
												</form>";
												
									//case 4:
									
								//     if(isset($_GET['dodaj']))
									//		{
										//	$dodaj=$_GET['dodaj'];
											//$result=$PDO->query("INSERT INTO logon (film) VALUES ('$dodaj';");
											
										//	$row = $result->fetch();
											//$result= $PDO->query("delete from filmy where fid ='$usun';");
											
											//}
												//echo "Czy na pewno chcesz wypożyczyć ten film?";
												//echo "<form action='zalogowany.php?wybor=4&usun=$usun' method='post'>		
												//Gatunek: <input type='text' value='$row[gatunek]' disabled /><br/> 
												//Tytul: <input type='text' value='$row[tytul]' disabled /><br/>
												//Premiera: <input type='text' value='$row[premiera]' disabled /><br/>
											//	<input type='submit' value='TAK' />
											//	<input type='button' value='NIE' OnClick=window.history.back() />
												//</form>";
											
											
							}	 					
	
												   
						    }
						    
						   elseif($row['role']=="member") {
							   if((isset($_GET['wybor'])))
								{
									$wybor=$_GET['wybor'];
								}; 
									
								 echo "<center><br/><a href='zalogowany.php?wybor=1' class='submit'>Wyszukaj film</a></center>";
					switch($wybor)
					{
						
						case 1:	
									
									include('pdo.php');
									$atom=0;
									if((isset($_POST['atom'])))
									{
										$atom=$_POST['atom'];
									};
							
								echo "
									<form name='dane1' action='zalogowany.php?wybor=1&atom='$atom'' method='post'><br/>
									<center style='color:white;'>Wybierz film: <select name='atom'></center>";
							 
										$result = $PDO->query("select * from filmy order by fid asc;");
										$row=$result->fetchAll(PDO::FETCH_ASSOC);
										foreach($row as $row){
											
												$s="";
												if($row['fid']==$atom) {$s=" selected";};
												echo "<option value=$row[fid] $s>$row[tytul]</option>";
											}
											
									
								echo "</select><br/>
											   <input type='submit' value='Szukaj' />
											    </form><br/>";
					            echo "<center><table border='1'></center>
												<tr style='color:white;'>
												   
													<td>Gatunek</td>
													<td>Tytuł</td>
													<td>Premiera</td>
													
													
												</tr>";		
												$fid=$_POST['fid'];
											    $result= $PDO->query("select * from filmy where fid='$atom';");
												$row=$result->fetchAll(PDO::FETCH_ASSOC);
												foreach ($row as $row){
													
														echo "<tr>
														
														<td style='color:white;'>$row[gatunek]</td>
														<td style='color:white;'>$row[tytul]</td>
														<td style='color:white;'>$row[premiera]</td>
														</tr>";
													
													echo "</table>";
												}	
													break;
													$PDO->close();
									
							    }
							}
					
					?>
						

			</div>
				</div>
					</div>
				</article>
			<footer> Stronę opracowal: Dawid Walczak</footer>
		</body>
		</html>




