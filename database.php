<html>
	<head>
		<title>IIS projekt</title>
	</head>
	<body>
		<?php	
			$servername = "localhost";
			$username = "xjanec28";
			$password = "kumcor4a";
			$dbname = "xjanec28";
			 
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			if(!$conn->set_charset("utf8")){
				//printf("Error loading character set utf8: %s\n", $conn->error);
				exit();
			} else {
				//printf("Current character set: %s\n", $conn->character_set_name());
			}

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			session_start();
			if(isset($_GET['logout'])){
				unset($_SESSION['uzivatel']);
			}
			$loginFail = "false";
			if(isset($_POST['loginBtn'])){
				$sql = "SELECT * FROM uzivatel WHERE login = '".$_POST["login"]."' AND heslo = '".$_POST["pwdlogin"]."'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    $_SESSION['uzivatel'] = $_POST["login"];
				    //echo "prihlaseni uspesne pane " .$_POST["login"]. "<br/>";
				} else {
					$loginFail = "true";
					//echo "spatne prihlasovaci udaje<br/>";
				}
			}

			/*$sql = "SELECT jmeno, prijmeni FROM testTable";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo "jmeno: " . $row["jmeno"]. " prijmeni: " . $row["prijmeni"]. "<br>";
				}
			}*/
			$registerFail = FALSE;
			if ($loginFail == "true"){
				$loginForm = '<div class="container">
							<form action='.$_SERVER["PHP_SELF"].' class="form-horizontal" method="post">
								<div class="form-group row">
									<label class="col-sm-2" for="username">Login:</label>
								</div>
								<div class="form-group row">
									<div class="col-sm-2">
										<input type="text" class="form-control" id="login" name="login" required>
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
							<form action='.$_SERVER["PHP_SELF"].' class="form-horizontal" method="post">
								<div class="form-group row">
									<label class="col-sm-2" for="username">Login:</label>
								</div>
								<div class="form-group row">
									<div class="col-sm-2">
										<input type="text" class="form-control" id="login" name="login" required>
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