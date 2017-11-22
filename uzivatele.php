<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>IIS proj</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
						<li class="active"><a href="uzivatele.php" class="<?php if (!isset($_SESSION['admin'])) echo hidden?>">Správa uživatelů</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Registrovat</a></li>
						<li><a href="#" data-toggle="popover" title="Přihlášení" data-placement="bottom" data-html="true" data-content='<?=$loginForm?>'><span class="glyphicon glyphicon-log-in"></span> Přihlásit</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (!isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><?php if(isset($_SESSION['uzivatel'])) echo "<a href='profil.php?login=" .$_SESSION['uzivatel']. "'>" .$_SESSION['uzivatel']. "</a></li>
						<li><a href='index.php?logout'> Odhlásit se</a>"?></li>
					</ul>
				</div>
			</div>
		</nav>

		<?php 
			if (isset($_POST['remove'])){
				$sql = "DELETE FROM uzivatel WHERE login ='" . $_POST['remove'] . "'";
				if ($conn->query($sql) != false)
					echo "Uživatel úspěšně smazán";
				else{
					echo "Chyba databáze při mazání uživatele";
				}
			}
			$sql = "SELECT * FROM uzivatel ORDER BY login";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo "<table class='table table-hover'>";
				echo "<thead><tr><th>Login</th><th>Jméno</th><th>Práva</th></tr></thead>";
				echo "<tbody>";
				while($row = $result->fetch_assoc()) {
				echo "<tr>";
				echo "<td><a href='profil.php?login=" . $row["login"] . "'>" . $row["login"] . "</a></td>";
				echo "<td>" . $row["jmeno"] . "</td>";
				echo "<td>" . $row["prava"] . "</td>";
				echo "<td>" . "" . "</td>";
				echo "<td>" . "Upravit" . "</td>";
				echo "<td><form action='' method='post'><button type='submit' name='remove' value='" . $row["login"] . "' class='btn btn-default'><span class='glyphicon glyphicon-remove text-danger'></span> Odstranit</button></form></td>";
				echo "<td>" . "" . "</td>";
				echo "<td>" . "" . "</td>";
				echo "</tr>";
				}
				echo "</tbody>";
				echo "</table>";
			}
		?>
