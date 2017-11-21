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
		<style>
		<?php include 'style.css'; ?>
		</style>
		
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
						<li class="active"><a href="udalosti.php">Události</a></li>
						<li><a href="interpreti.php">Interpreti</a></li> 
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Registrovat</a></li>
						<li><a href="#" data-toggle="popover" title="Příhlášení" data-placement="bottom" data-html="true" data-content='<?=$loginForm?>'><span class="glyphicon glyphicon-log-in"></span> Přihlásit</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (!isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><?php if(isset($_SESSION['uzivatel'])) echo "<a href='#'>" .$_SESSION['uzivatel']. "</a></li>
						<li><a href='?logout'> Odhlásit se</a>"?></li>
					</ul>
				</div>
			</div>
		</nav>

		<?php 
		$sql = "SELECT * FROM udalost ORDER BY dat_zac";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		// output data of each row
			echo "<table class='table table-hover'>";
			echo "<thead><tr><th>Jméno</th><th>Ročník</th><th>Žánr</th><th>Datum začátku</th><th>Datum konce</th><th>Místo konání</th></tr></thead>";
			echo "<tbody>";
			while($row = $result->fetch_assoc()) {
				echo iconv("CP1252", "UTF-8", $row["misto_konani"]);
				echo $row["misto_konani"];
				echo utf8_decode($row["misto_konani"]);
				echo utf8_encode($row["misto_konani"]);
				echo utf8_encode(utf8_encode($row["misto_konani"]));
				echo mb_convert_encoding($row["misto_konani"], "UTF-8");
				echo mb_convert_encoding($row["misto_konani"], "ISO-8859-1");
				echo mb_convert_encoding(utf8_decode($row["misto_konani"]), "ISO-8859-1");
				echo mb_convert_encoding(utf8_encode($row["misto_konani"]), "ISO-8859-1");
				echo "<tr>";
				echo "<td>" . utf8_decode($row["nazev"]) . "</td>";
				echo "<td>" . $row["rocnik"] . "</td>";
				echo "<td>" . $row["zanr"] . "</td>";
				echo "<td>" . $row["dat_zac"] . "</td>";
				echo "<td>" . $row["dat_kon"] . "</td>";
				echo "<td>" . utf8_decode($row["misto_konani"]) . "</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}
		?>
	</body>
</html>