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
		<p>INTERPRETI</p>
		<table class="table table-hover">
		    <thead>
		      <tr>
		        <th>Firstname</th>
		        <th>Lastname</th>
		        <th>Email</th>
		      </tr>
		    </thead>
		    <tbody>
		      <tr>
		        <td>John</td>
		        <td>Doe</td>
		        <td>john@example.com</td>
		      </tr>
		      <tr>
		        <td>Mary</td>
		        <td>Moe</td>
		        <td>mary@example.com</td>
		      </tr>
		      <tr>
		        <td>July</td>
		        <td>Dooley</td>
		        <td>july@example.com</td>
		      </tr>
		    </tbody>
		  </table>

		<?php  include 'database.php';  ?>
		<?php 
		$sql = "SELECT jmeno FROM interpret";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		// output data of each row
			echo "<table class='table table-hover'>";
			echo "<thead><tr><th>Jmeno</th></tr></thead>";
			echo "<tbody>";
			while($row = $result->fetch_assoc()) {
				echo "<tr>";
				echo "<td>" . $row["jmeno"] . "</td>";
				echo "<td>neco dalsiho</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}

		?>

	</body>
</html>