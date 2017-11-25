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
						<li class="active"><a href="udalosti.php">Události</a></li>
						<li><a href="interpreti.php">Interpreti</a></li> 
						<li><a href="uzivatele.php" class="<?php if (!isset($_SESSION['admin'])) echo hidden?>">Správa uživatelů</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Registrovat</a></li>
						<li><a href="#" data-toggle="popover" title="Přihlášení" data-placement="bottom" data-html="true" data-content='<?=$loginForm?>'><span class="glyphicon glyphicon-log-in"></span> Přihlásit</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (!isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><?php if(isset($_SESSION['uzivatel'])) echo "<a href='profil.php?login=" .$_SESSION['uzivatel']. "'>" .$_SESSION['uzivatel']. "</a></li>
						<li><a href='index.php?logout'> Odhlásit se</a>"?></li>
					</ul>
				</div>
			</div>
		</nav>

		<?php
			$sql = "SELECT * FROM udalost WHERE nazev = '".$_GET["u"]."'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$sql = "SELECT * FROM stage_udalost WHERE udalost='".$row['nazev']."' AND dat_zac='".$row['dat_zac']."'";
			$result_stages = $conn->query($sql);
			$no_stages = $result_stages->num_rows;
			$sql = "SELECT * FROM interpret_udalost WHERE udalost='".$row['nazev']."' AND dat_zac='".$row['dat_zac']."'";
			$result = $conn->query($sql);
			$no_interpret = $result->num_rows;
			$row2 = $result->fetch_assoc();

			$names_array = array();
		?>


		<div class='container'>
			<div class='row'>
				<div class='col-12 col-md-4'>
					<br>
					<img src='images/event.jpeg' class='profile_pic' class='img-responsive'>
					<br><br>
					<p>Celkem kapel: <?echo $no_interpret?></p>
					<p>Celkem stage: <?echo $no_stages?></p>
					<br>
					<div class="container">
						<ul class="nav nav-tabs">
							<?
							for($i = 0; $i < $no_stages; $i++) {
								$row_stages = $result_stages->fetch_assoc();
								$names_array[$i] = $row_stages['stage'];
								if($i == 0){?>
									<li class="active"><a data-toggle="tab" href="#<?echo $i?>"><?echo $row_stages['stage']?></a></li>
								<?}
								else{?>
									<li><a data-toggle="tab" href="#<?echo $i?>"><?echo $row_stages['stage']?></a></li>
								<?}
							}?>
						</ul>
						<div class="tab-content">
							<?
							for($i = 0; $i < $no_stages; $i++) {
								$sql = "SELECT * FROM stage WHERE nazev='".$names_array[$i]."'";
								$result = $conn->query($sql);
								$stage_row = $result->fetch_assoc();
								if($i == 0){?>
									<div id="<?echo $i?>" class="tab-pane fade in active">
								<?}
								else{?>
									<div id="<?echo $i?>" class="tab-pane fade">
								<?}?>
									<p>Kapacita: <?echo $stage_row['kapacita_mist']?></p>
									<p>Plocha: <?echo $stage_row['plocha']?></p>
									<?
										$sql = "SELECT * FROM interpret_stage NATURAL JOIN stage_udalost WHERE udalost='".$row['nazev']."' AND dat_zac='".$row['dat_zac']."' AND stage='".$names_array[$i]."'";
										$result = $conn->query($sql);
										if ($result->num_rows > 0) {
									?>
									<table class='table table-hover'>
										<thead>
											<tr>
												<th>Interpret</th>
												<th>Jako</th>
												<th>Od</th>
												<th>Do</th>
											</tr>
										</thead>
										<tbody>
											<? while($ints_of_stage = $result->fetch_assoc()) { ?>
												<tr>
													<td> <?echo $ints_of_stage['interpret']?> </td>
													<td> <?echo $ints_of_stage['jako']?> </td>
													<td> <?echo $ints_of_stage['od']?> </td>
													<td> <?echo $ints_of_stage['do']?> </td>
												</tr>
											<?}?>
										</tbody>
									</table>
									<?}?>
								</div>
							<?}?>

						</div>
					</div>
					<br>
				</div>
				<div class='col-12 col-md-6'>
					<?if(!isset($_POST['edit'])){
						echo "<h1>" .$row["nazev"]. "</h1>";
					}
					?>
					<br>

					<?if (!isset($_POST['edit'])){?>
							<h3>Žánr: </h3><h4><?echo $row["zanr"]?></h4>
							<br><br>
							<h3>Místo konání: </h3><h4><?echo $row["misto_konani"]?></h4>
							<br><br>
							<h3>Datum: </h3><h4><?echo " od ".$row["dat_zac"]." do ".$row["dat_kon"]?></h4>
							<br><br>
							<h3>Cena: </h3><h4><?echo $row['cena']?> Kč</h4>
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

	</body>
</html>