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
	<script>
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover(); 
		});
	</script>
	<?php include 'database.php'; ?>
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
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Registrovat</a></li>
					<li><a href="#" data-toggle="popover" title="Login" data-placement="bottom" data-html="true" data-content='<?=$loginForm?>'><span class="glyphicon glyphicon-log-in"></span> Přihlásit</a></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<?php  include 'database.php';  ?>
	
	<?php
	//registrace zakaznika	---NEJDE DIAKRITIKA
		if(isset($_POST['register'])){
			//echo phpinfo();
			//$hesloH = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
			$sql = "SELECT * FROM zakaznik WHERE login = '".$_POST["username"]."'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    echo "User Already in Exists<br/>";
			} else {
				$sql = "INSERT INTO zakaznik (login, heslo, jmeno, email, tel_cislo)
				VALUES ('".$_POST["username"]."','".$_POST["pwd"]."','".$_POST["name"]."','".$_POST["email"]."','".$_POST["phone"]."')";

				if ($conn->query($sql) === TRUE) {
					/*echo "New record created successfully";
					$sql = "SELECT login, jmeno FROM zakaznik";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
							echo "login: " . $row["login"]. "<br/>jmeno: " . $row["jmeno"]. "<br>";
						}
					}*/
				} else {
					//osetreni spatneho loginu nebo tak..
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
		}
	?>

		<div class="container">
			<form action="registration.php" class="form-horizontal" method="post">
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="username">Username:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="name">Name:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="email">Email:</label>
					<div class="col-sm-4">
						<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="phone">Telefon:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number: XXX XXX XXX">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="pwd">Heslo:</label>
					<div class="col-sm-4"> 
						<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password" required>
					</div>
				</div>  
				<div class="form-group row">
					<label class="control-label col-sm-2 col-sm-offset-2" for="pwdcon">Heslo znovu:</label>
					<div class="col-sm-4"> 
						<input type="password" class="form-control" id="pwdcon" name="pwdcon" placeholder="Enter password" required>
					</div>
					<div class="col-sm-4">
						<label class="control-label col-sm-2 col-sm-offset-2">Stejny/jiny</label>
					</div>
				</div>
				<div class="form-group row"> 
					<div class="col-sm-offset-5 col-sm-10">
						<button type="submit" class="btn btn-default" name="register">Zaregistrovat</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>