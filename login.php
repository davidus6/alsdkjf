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
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<a class="navbar-brand" href="index.php">WebSiteName</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#">Page 1</a></li>
					<li><a href="#">Page 2</a></li> 
					<li><a href="#">Page 3</a></li> 
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
					<li><a href="#" data-toggle="popover" title="Login" data-placement="bottom" data-content="jmeno heslo a tak dale"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
							<form action="index.php" class="form-horizontal" method="post">
								<div class="form-group row">
									<label class="control-label col-sm-2" for="username">Login:</label>
								</div>
								<div class="form-group row">
									<div class="col-sm-3">
										<input type="text" class="form-control" id="login" name="login" placeholder="Enter login" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="control-label col-sm-2" for="pwd">Heslo:</label>
								</div>
								<div class="form-group row">
									<div class="col-sm-3"> 
										<input type="password" class="form-control" id="pwdlogin" name="pwdlogin" placeholder="Enter password" required>
									</div>
								</div>  
								<div class="form-group row"> 
									<div class="col-sm-10">
										<button type="submit" class="btn btn-default" name="login">Prihlasit:</button>
									</div>
								</div>
							</form>
						</div>
	</body>
</html>