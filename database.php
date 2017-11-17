<html>
	<head>
		<title>IIS projekt</title>
	</head>
	<body>
		<?php	
			$servername = "localhost";
			$username = "xjirus01";
			$password = "o3dejive";
			$dbname = "xjirus01";
			 
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			/*$sql = "SELECT jmeno, prijmeni FROM testTable";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo "jmeno: " . $row["jmeno"]. " prijmeni: " . $row["prijmeni"]. "<br>";
				}
			}*/

			$loginForm = '<div class="container">
							<form action="index.php" class="form-horizontal" method="post">
								<div class="form-group row">
									<label class="col-sm-2" for="username">Login:</label>
								</div>
								<div class="form-group row">
									<div class="col-sm-2">
										<input type="text" class="form-control" id="login" name="login" placeholder="Enter login" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2" for="pwd">Heslo:</label>
								</div>
								<div class="form-group row">
									<div class="col-sm-2"> 
										<input type="password" class="form-control" id="pwdlogin" name="pwdlogin" placeholder="Enter password" required>
									</div>
								</div>  
								<div class="form-group row"> 
									<div class="col-sm-10">
										<button type="submit" class="btn btn-default" name="loginBtn">Prihlasit</button>
									</div>
								</div>
							</form>
						</div>';

			if(isset($_POST['loginBtn'])){
				$sql = "SELECT * FROM zakaznik WHERE login = '".$_POST["login"]."'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    $sql = "SELECT * FROM zakaznik WHERE heslo = '".$_POST["pwdlogin"]."'";
					$result = $conn->query($sql);
				    if ($result->num_rows > 0) {
				    	echo "Prihlaseni uspesne!<br/>";
				    } else {
				    	echo "spatne heslo: " .$_POST["pwdlogin"]. "<br/>";
				    }
				} else {
					echo "uzivatel neexistuje<br/>";
				}
			}
		?> 
	</body>
</html>