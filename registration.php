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

	function checkPasswordMatch() {
	    var password = $("#pwd").val();
	    var confirmPassword = $("#pwdcon").val();

	    if (password != confirmPassword){
	        $("#pwdlabel").html("<span class='glyphicon glyphicon-remove text-danger'> NESHODA</span>");
	    	$("#register").prop("disabled", true);
	    }
	    else {
	        $("#pwdlabel").html("<span class='glyphicon glyphicon-ok text-success'> SHODA</span>");
	    	$("#register").prop("disabled", false);
	    }
	}

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
			$sql = "SELECT * FROM uzivatel WHERE login = '".$_POST["username"]."'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    echo "Uživatel již existuje! Zvolte jiný login.<br/>";
			    $registerFail = TRUE;
			} else {
				$sql = "INSERT INTO uzivatel (login, heslo, jmeno, email, tel_cislo)
				VALUES ('".$_POST["username"]."','".$_POST["pwd"]."','".$_POST["name"]."','".$_POST["email"]."','".$_POST["phone"]."')";

				if ($conn->query($sql) === TRUE) {
					echo "Registrace proběhla úspěšně.";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
		}
	?>

		<div class="container">
			<form action="registration.php" class="form-horizontal" method="post">
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="username">* Login:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="username" name="username" placeholder="" required autofocus>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="name">* Jméno:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="name" value="<?php echo ($registerFail)?$_POST['name']:'';?>"  name="name" placeholder="" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="phone">Město:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="city" value="<?php echo ($registerFail)?$_POST['city']:'';?>" name="city" placeholder="">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="email">* E-mail:</label>
					<div class="col-sm-4">
						<input type="email" class="form-control" id="email" value="<?php echo ($registerFail)?$_POST['email']:'';?>" name="email" placeholder="" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="phone">Telefon:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="phone" value="<?php echo ($registerFail)?$_POST['phone']:'';?>" name="phone" placeholder="formát: XXX XXX XXX" pattern="^\d{3} \d{3} \d{3}$">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="pwd">* Heslo:</label>
					<div class="col-sm-4"> 
						<input type="password" class="form-control" id="pwd" value="<?php echo ($registerFail)?$_POST['pwd']:'';?>" name="pwd" placeholder="" required>
					</div>
				</div>  
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="pwdcon">* Heslo znovu:</label>
					<div class="col-sm-4"> 
						<input type="password" class="form-control" id="pwdcon" value="<?php echo ($registerFail)?$_POST['pwdcon']:'';?>" name="pwdcon" placeholder="" required>
					</div>
					<div class="col-sm-2">
						<label class="control-label" id="pwdlabel"></label>
					</div>
				</div>
				<div class="form-group row"> 
					<div class="col-sm-offset-2 col-sm-10">
						<label class="control-label col-sm-2 col-sm-offset-2">* - Povinné pole</label>
					</div>
				</div>
				<div class="form-group row"> 
					<div class="col-sm-offset-5 col-sm-10">
						<button type="submit" class="btn btn-default" id="register" name="register">Zaregistrovat</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>