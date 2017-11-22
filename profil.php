<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>IIS proj</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php include 'database.php'; ?>
		<script>
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover(); 
			});
		</script>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
					<a class="navbar-brand" href="index.php">Lambáda</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="index.php">Domů</a></li>
						<li><a href="udalosti.php">Události</a></li>
						<li><a href="interpreti.php">Interpreti</a></li> 
						<li><a href="uzivatele.php" class="<?php if (!isset($_SESSION['admin'])) echo hidden?>">Správa uživatelů</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Registrovat</a></li>
						<li><a href="#" data-toggle="popover" title="Přihlášení" data-placement="bottom" data-html="true" data-content='<?=$loginForm?>'><span class="glyphicon glyphicon-log-in"></span> Přihlásit</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (!isset($_SESSION['uzivatel'])) echo hidden?>">
						<li class="active"><?php if(isset($_SESSION['uzivatel'])) echo "<a href='#'>" .$_SESSION['uzivatel']. "</a></li>
						<li><a href='index.php?logout'> Odhlásit se</a>"?></li>
					</ul>
				</div>
			</div>
		</nav>

		<?php 
			$sql = "SELECT * FROM uzivatel WHERE login = '".$_GET["login"]."'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
		?>
			<div class='container'>
				<div class='row'>
					<div class='col-12 col-md-4'>
						<br>
						<img src='images/generic.png' class='profile_pic' class='img-responsive'>
						<br>
					</div>
					<div class='col-12 col-md-6'>
						<?php
							echo "<h1>" .$row["jmeno"]. "</h1>";
						?>
						<br>
						<style>
							h3, h4 {display:inline;}
						</style>
						<?php
							echo "<h3>Email: </h3><h4>" .$row["email"]. "</h4>";
							echo "<br><br>";
							echo "<h3>Telefon: </h3><h4>" .$row["tel_cislo"]. "</h4>";
							echo "<br><br>";
							echo "<h3>Město: </h3><h4>" .$row["mesto"]. "</h4>";
						?>
						<br><br><br>
						<form action='' method='post'><button type='submit' name='remove' value="'" . $row["login"] . "'" class='btn btn-default'>Upravit profil</button>
						<form action='' method='post'><button type='submit' name='remove' value="'" . $row["login"] . "'" class='btn btn-default'>Deaktivovat profil</button>
					</div>
					<div class='col-4'>
						</form>
					</div>
				</div>
			</div>

		

	</body>
</html>