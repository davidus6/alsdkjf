<html>
	<head>
		<title>IIS projekt</title>
	</head>
	<body>
		<?php	
			header("Content-Type: text/html; charset=utf-8");
			$servername = "localhost";
			$username = "xjanec28";
			$password = "kumcor4a";
			$dbname = "xjanec28";
			 
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			if(!$conn->set_charset("utf8")){
				exit();
			} else {}

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			session_start();
			if(isset($_GET['logout'])){
				unset($_SESSION['uzivatel']);
				unset($_SESSION['admin']);
			}
			$loginFail = "false";
			if(isset($_POST['loginBtn'])){
				$sql = "SELECT * FROM uzivatel WHERE login = '".$_POST["login"]."' AND heslo = '".$_POST["pwdlogin"]."'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
				    $_SESSION['uzivatel'] = $_POST["login"];
				    if($row["prava"] == "admin"){
				    	$_SESSION['admin'] = true;
				    }
				} else {
					$loginFail = "true";
				}
			}

			if(isset($_POST['setFavorite'])){
				$sql = "INSERT INTO oblibenec VALUES ('" .$_SESSION['uzivatel']. "','" .$_POST['setFavorite']. "')";
				$conn->query($sql);
			}

			if(isset($_POST['unsetFavorite'])){
				$sql = "DELETE FROM oblibenec WHERE login = '" .$_SESSION['uzivatel']. "' AND interpret = '" .$_POST['unsetFavorite']. "'";
				$conn->query($sql);
			}

			$registerFail = FALSE;
			if ($loginFail == "true"){
				$loginForm = '<div class="container">
							<form action="" class="form-horizontal" method="post">
								<div class="form-group row">
									<label class="col-sm-2" for="username">Login:</label>
								</div>
								<div class="form-group row">
									<div class="col-sm-2">
										<input type="text" class="form-control" id="login" name="login" required autofocus>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2" for="pwd">Heslo:</label>
								</div>
								<div class="form-group row">
									<div class="col-sm-2"> 
										<input type="password" class="form-control" id="pwdlogin" name="pwdlogin" required>
									</div>
								</div> 
								<div class="form-grouop row">
									<div class="col-sm-10">
										<label class="text-danger" id="loginLabel">Špatné přihlašovací údaje!</label>
									</div>
								</div> 
								<div class="form-group row"> 
									<div class="col-sm-10">
										<button type="submit" class="btn btn-default" name="loginBtn">Přihlásit</button>
									</div>
								</div>
							</form>
						</div>';
			} else {
				$loginForm = '<div class="container">
							<form action="" class="form-horizontal" method="post">
								<div class="form-group row">
									<label class="col-sm-2" for="username">Login:</label>
								</div>
								<div class="form-group row">
									<div class="col-sm-2">
										<input type="text" class="form-control" id="login" name="login" required autofocus>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2" for="pwd">Heslo:</label>
								</div>
								<div class="form-group row">
									<div class="col-sm-2"> 
										<input type="password" class="form-control" id="pwdlogin" name="pwdlogin" required>
									</div>
								</div>  
								<div class="form-group row"> 
									<div class="col-sm-10">
										<button type="submit" class="btn btn-default" name="loginBtn">Přihlásit</button>
									</div>
								</div>
							</form>
						</div>';
			}
		?> 
	</body>
</html>