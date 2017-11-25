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
			if (<?php echo $loginFail ?>){
				$('#loginPopover').popover('show');
				$('#loginLabel').removeAttr('hidden');
			}
		});
		</script>
		<style>
		<?php include 'style.css'; ?>
		</style>
		
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
						<li class="active"><a href="interpreti.php">Interpreti</a></li>
						<li><a href="uzivatele.php" class="<?php if (!isset($_SESSION['admin'])) echo hidden?>">Správa uživatelů</a></li> 
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Registrovat</a></li>
						<li><a href="#" id="loginPopover" data-toggle="popover" title="Přihlášení" data-placement="bottom" data-html="true" data-content='<?=$loginForm?>'><span class="glyphicon glyphicon-log-in"></span> Přihlásit</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (!isset($_SESSION['uzivatel'])) echo hidden?>">
						<li>
							<? if(isset($_SESSION['uzivatel'])){?> 
							<a href='profil.php?login=<?echo $_SESSION["uzivatel"]?>' ><?echo $_SESSION['uzivatel']?></a>
						</li>
						<li>
							<a href='?jmeno=<?echo $_GET["jmeno"]?>&logout'> Odhlásit se</a>
						</li>
						<? } ?>
					</ul>
				</div>
			</div>
		</nav>

		<?php 
			$sql = "SELECT * FROM interpret WHERE jmeno = '".$_GET["jmeno"]."'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$majitel = $row['jmeno'];

			if (isset($_POST["removeAlbum"])){
				$sql = "DELETE FROM album WHERE nazev = '" .$_POST["removeAlbum"]. "'";
				$conn->query($sql);
			}

			if (isset($_POST["addAlbum"])){
				$sql = "INSERT INTO album VALUES ('" .$_POST["addNazevAlba"]. "','" .$_POST["addRVAlba"]. "','" .$_POST["addZanrAlba"]. "','" .$majitel. "')";
				$conn->query($sql);
			}
		?>

		<div class='container'>
			<div class='row'>
				<div class='col-12 col-md-4'>
					<br>
					<img src='images/band.png' class='profile_pic' class='img-responsive'>
					<br>
				</div>
				<div class='col-12 col-md-6'>
					<?if(!isset($_POST['edit'])){
						echo "<h1>" .$row["jmeno"]. "</h1>";
					}
					?>
					<br>

					<?if (!isset($_POST['edit'])){?>
							<h3>Žánr: </h3><h4><?echo $row["zanr"]?></h4>
							<br><br>
							<h3>Datum vzniku: </h3><h4><?echo $row["dat_vzniku"]?></h4>
							<br><br>
							<h3>Datum rozpuštění: </h3><h4><?echo $row["dat_rozpusteni"]?></h4>
							<br><br>
							<h3>Label: </h3><h4><?echo $row["label"]?></h4>
						<?} else {

						}
					?>
					<br><br><br>
					
					<?php if (!isset($_POST['edit'])) { ?>
					
					
					<? } else { ?>
					
					<? } ?>
				</div>
			</div>
		</div>

		<br>
		<div class="container">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#vystoupeni">Vystoupení</a></li>
				<li><a data-toggle="tab" href="#clenove">Členové</a></li>
				<li><a data-toggle="tab" href="#alba">Alba</a></li>
			</ul>

		 	<div class="tab-content">
				<div id="vystoupeni" class="tab-pane fade in active">
					<table class='table table-hover table-condensed'>
						<thead>
							<tr>
								<th>Událost</th>
								<th>Od</th>
								<th>Do</th>
							</tr>
						</thead>
						<?php
							$sql = "SELECT * FROM interpret_udalost WHERE interpret='".$majitel."' ORDER BY 'od'";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
						?>
						<tbody>
							<?while($row = $result->fetch_assoc()) {?>
							<tr>
								<td><a href='udalost.php?u=<?echo $row["udalost"]?>'><?echo $row["udalost"]?></a></td>
								<td><?echo $row["od"]?></td>
								<td><?echo $row["do"]?></td>
							</tr>
							<?}?>
						<?}?>
						</tbody>
					</table>
				</div>
				<div id="clenove" class="tab-pane fade">
					<table class='table table-hover table-condensed'>
						<thead>
							<tr>
								<th>Jméno</th>
								<th>Datum narození</th>
								<th>Datum úmrtí</th>
							</tr>
						</thead>
						<?php
							$sql = "SELECT * FROM umelec WHERE jm_interpreta='".$majitel."' ORDER BY 'jmeno'";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
						?>
						<tbody>
							<?while($row = $result->fetch_assoc()) {?>
							<tr>
								<td><?echo $row["jmeno"]?></td>
								<td><?echo $row["dat_narozeni"]?></td>
								<td><?echo $row["dat_umrti"]?></td>
							</tr>
							<?}?>
						<?}?>
						</tbody>
					</table>
				</div>
				<div id="alba" class="tab-pane fade">
					<table class='table table-hover table-condensed'>
						<thead>
							<tr>
								<th>Název</th>
								<th>Rok vydání</th>
								<th>Žánr</th>
								<?if (isset($_SESSION['admin'])){ echo "<th></th>"; } ?>
							</tr>
						</thead>
						<?php
							$sql = "SELECT * FROM album WHERE autor='".$majitel."' ORDER BY rok_vydani DESC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
						?>
						<tbody>
							<?while($row = $result->fetch_assoc()) {?>
							<tr>
								<td><?echo $row["nazev"]?></td>
								<td><?echo $row["rok_vydani"]?></td>
								<td><?echo $row["zanr"]?></td>
								<?if (isset($_SESSION['admin'])){?>
								<td><form method="post"><button class="form-control" type="submit" name="removeAlbum" title= "Odstranit" value="<?echo $row["nazev"]?>"><span class='glyphicon glyphicon-remove text-danger'></span></button></form></td>
								<? } ?>
							</tr>
							<? } }
							if (isset($_SESSION['admin'])){?>
							<tr>
								<form action="" method="post">
									<td><input class="form-control" type="text" name="addNazevAlba"/></td>
									<td><input class="form-control" type="text" name="addRVAlba"/></td>
									<td><input class="form-control" type="text" name="addZanrAlba"/></td>
									<td><button class="form-control" type="submit" name="addAlbum" title="Přidat"><span class='glyphicon glyphicon-plus text-success'></span></button></td>
								</form>
							</tr>
							<? } ?>
						</tbody>
					</table>
				</div>
		  </div>
		</div>
	</body>
</html>