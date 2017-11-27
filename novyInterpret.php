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
		$("#pwdcon").keyup(checkPasswordMatch);
		if (<?php echo $loginFail ?>){
			$('#loginPopover').popover('show');
			$('#loginLabel').removeAttr('hidden');
		}
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
					<li><a href="vyhledavani.php">Vyhledávání</a></li>
					<li><a href="uzivatele.php" class="<?php if (!isset($_SESSION['admin'])) echo hidden?>">Správa uživatelů</a></li> 
				</ul>
				<ul class="nav navbar-nav navbar-right <?php if (isset($_SESSION['uzivatel'])) echo hidden?>">
					<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Registrovat</a></li>
					<li><a href="#" id="loginPopover" data-toggle="popover" title="Přihlášení" data-placement="bottom" data-html="true" data-content='<?=$loginForm?>'><span class="glyphicon glyphicon-log-in"></span> Přihlásit</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right <?php if (!isset($_SESSION['uzivatel'])) echo hidden?>">
					<li><?php if(isset($_SESSION['uzivatel'])) echo "<a href='profil.php?login=" .$_SESSION['uzivatel']. "'>" .$_SESSION['uzivatel']. "</a></li>
					<li><a href='?logout'> Odhlásit se</a>"?></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<?php
	//registrace uzivatela	---NEJDE DIAKRITIKA ---PORAD NEJDE ---UZ JO
		if(isset($_POST['register'])){
			//$hesloH = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
			$sql = "SELECT * FROM interpret WHERE jmeno = '".$_POST["name"]."'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    echo "Interpret už existuje<br/>";
			    $registerFail = TRUE;
			} else {
				$sql = "INSERT INTO interpret (jmeno, zanr, dat_vzniku, dat_rozpusteni, label)
				VALUES ('".$_POST["name"]."','".$_POST["genre"]."','".$_POST["dat_from"]."','".$_POST["dat_to"]."','".$_POST["label"]."')";

				if ($conn->query($sql) === TRUE) {				
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
		}
		/*
		jmeno
		zanr
		datum vzniku
		datum rozpusteni
		label
		*/
	?>

		<div class="container">
			<form action="novyInterpret.php" class="form-horizontal" method="post">
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="name">Jméno:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="name" value="<?php echo ($registerFail)?$_POST['name']:'';?>"  name="name" autofocus>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="genre">Žánr:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="genre" value="<?php echo ($registerFail)?$_POST['genre']:'';?>" name="genre">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="dat_from">Datum vzniku:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="dat_from" value="<?php echo ($registerFail)?$_POST['dat_from']:'';?>" name="dat_from" placeholder="formát: RRRR-MM-DD" pattern="^\d{4}-\d{2}-\d{2}$">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="dat_to">Datum rozpuštění:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="datˇ_to" value="<?php echo ($registerFail)?$_POST['dat_to']:'';?>" name="dat_to" placeholder="formát: RRRR-MM-DD" pattern="^\d{4}-\d{2}-\d{2}$">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="label">Label:</label>
					<div class="col-sm-4"> 
						<input type="text" class="form-control" id="label" value="<?php echo ($registerFail)?$_POST['label']:'';?>" name="label">
					</div>
				</div>  
				<div class="form-group row"> 
					<div class="col-sm-offset-5 col-sm-10">
						<button type="submit" class="btn btn-default" id="register" name="register"><span class='glyphicon glyphicon-ok text-success'></span> Přidat</button>
						<a href="interpreti.php" class='btn btn-default'><span class='glyphicon glyphicon-remove text-danger'></span> Zrušit</a>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>