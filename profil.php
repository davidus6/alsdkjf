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
						<li class="active"><?php if(isset($_SESSION['uzivatel'])) echo "<a href='profil.php?login=" .$_SESSION['uzivatel']. "'>" .$_SESSION['uzivatel']. "</a></li>
						<li><a href='index.php?logout'> Odhlásit se</a>"?></li>
					</ul>
				</div>
			</div>
		</nav>

		<?php 

		if (isset($_POST['confirm'])){
			$sql = "UPDATE uzivatel SET jmeno='" .$_POST["name"]. "' WHERE login= '".$_POST["confirm"]."'";
			$conn->query($sql);
			$sql = "UPDATE uzivatel SET email='" .$_POST["email"]. "' WHERE login= '".$_POST["confirm"]."'";
			$conn->query($sql);
			$sql = "UPDATE uzivatel SET tel_cislo='" .$_POST["phone"]. "' WHERE login= '".$_POST["confirm"]."'";
			$conn->query($sql);
			$sql = "UPDATE uzivatel SET mesto='" .$_POST["city"]. "' WHERE login= '".$_POST["confirm"]."'";
			$conn->query($sql);
		}

		if (isset($_POST['remove'])){
			$sql = "DELETE FROM vstupenka WHERE login='" .$_POST['remove'] ."'";
			$conn->query($sql);
			$sql = "DELETE FROM uzivatel WHERE login ='" . $_POST['remove'] . "'";
			$conn->query($sql);
			header("Location: index.php?logout");
		}


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
						<?php if(!isset($_POST['edit'])){
							echo "<h1>" .$row["jmeno"]. "</h1>";
						}
						?>
						<br>

						<?php if (!isset($_POST['edit'])){
								echo "<h3>Email: </h3><h4>" .$row["email"]. "</h4>";
								echo "<br><br>";
								echo "<h3>Telefon: </h3><h4>" .$row["tel_cislo"]. "</h4>";
								echo "<br><br>";
								echo "<h3>Město: </h3><h4>" .$row["mesto"]. "</h4>";
							} else {
								echo "<form action='' class='form-horizontal' method='post'>";
								echo "<h3>Jmeno: </h3><input type='text' class='form-control' name='name' value='" .$row["jmeno"]. "' required>";
								echo "<h3>Email: </h3><input type='email' class='form-control' name='email' value='" .$row["email"]. "' required>";
								echo "<h3>Telefon: </h3><input type='text' class='form-control' name='phone' value='" .$row["tel_cislo"]. "' pattern='^\d{3} \d{3} \d{3}$' placeholder='formát: XXX XXX XXX'>";
								echo "<h3>Město: </h3><input type='text' class='form-control' name='city' value='" .$row["mesto"]. "'>";
							}
						?>
						<br><br><br>
						
						<?php if (!isset($_POST['edit'])) { ?>
						
						<form action='' method='post'><button type='submit' name='edit' value='true' class='btn btn-default'><span class="glyphicon glyphicon-pencil"></span> Upravit profil</button>
						<form action='' method='post'><button type='submit' name='remove' value=<?php echo $row["login"];?> class='btn btn-default'><span class='glyphicon glyphicon-off text-danger'></span> Deaktivovat účet</button>
						
						<? } else { ?>
						
						<button type='submit' name='confirm' value=<?php echo $row["login"];?> class='btn btn-default'><span class='glyphicon glyphicon-ok text-success'></span> Potvrdit změny</button>
						<a href="profil.php?login=<?php echo $row["login"];?>" class='btn btn-default'><span class='glyphicon glyphicon-remove text-danger'></span> Zrušit</a>
						</form>
						
						<? } ?>
					</div>
				</div>
			</div>
	</body>
</html>