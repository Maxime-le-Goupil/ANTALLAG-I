<?php
	session_start(); 
	if(isset($_GET['id']) AND $_GET['id']==! '')
	{
		$bdd = new PDO('mysql:host=localhost;dbname=antallagi;charset=utf8', 'root', 'root');
		session_start(); 
		
		if(!isset($_SESSION['ide']))
		{
			header('Location: ../check.php');
		}
		
		$ide=$_SESSION['ide'];
		$id=$_GET['id'];
	}
	else
	{
		header('Location: deco.php');
	}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8"/>
	<title>Voir la correction</title>
	<link rel="stylesheet" href="css/see.css" />
</head>
	<body>
		
		<nav>
			<div>
				<a href='language-select.php'/><h1 class="nav1">Demander une correction</h1></a>
			</div>
			<div class='profile'>
				<img src="images/avatar.jpg" alt="avatar" class='avatar' >
				<h3><?php if(isset($_SESSION['name']) AND $_SESSION['name']!=='')
							{
								echo $_SESSION['name'];
							}
						    else
							{
								//echo 'erreur';
								header('Location: ../login-etudiant.php?mdp=1');
							}
					?>
				</h3>			
			</div>
			
			<div class="buttonbox">
				<a href="deco.php" class="platforme">DECONNEXION</a>
			</div>	
		</nav>
		
		<section>
			<h1>Votre Correction</h1>
			<?php
				$reponse = $bdd->prepare('SELECT `id`,`num-correct`,`num-edu`,`consigne`,`devoir`,`status`,`correction`,`note` FROM `correction` WHERE `id`=? AND `num-edu`=?');
				$reponse->execute(array($id,$ide));	
				$data = $reponse->fetch();
			?>
			
			<h5>Status: <?php echo $data['status'];?></h5>
			<h2>Consigne</h2>
			<p><?php echo $data['consigne'];?></p>
			<h2>Devoir</h2>
			<p><?php echo $data['devoir'];?></p>
			<h2>Correction</h2>
			<p><?php echo $data['correction'];?></p>
		</section>
		
		<section>
			<h2>Notez votre correcteur</h2>
			<div class='marge'>
			<?php
				if($data['note']==0)
				{
					
					echo '<p></p><form method="post" action="noter.php">
					<label>Votre note</label> : <input type="number" id="note" name="note" min=0 max=20 required/> /20
					<input type="hidden" value="' .$data['id']. '"name="id" id="id"/>
					<input type="hidden" value="' .$data['num-correct']. '"name="num-correct" id="num-correct"/>
					<input type="submit" value="Envoyer" />
					</form></p>';
				}
				else
				{
					echo "<p>Vous avez déjà noté votre correcteur!</p>";
				}
			?>
			</div>
		</section>
		<?php
				$reponse->closeCursor();
			?>
	</body>
</html>
