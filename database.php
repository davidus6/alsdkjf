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
		?> 
	</body>
</html>