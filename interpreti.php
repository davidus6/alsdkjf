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
						<li><?php if(isset($_SESSION['uzivatel'])) echo "<a href='profil.php?login=" .$_SESSION['uzivatel']. "'>" .$_SESSION['uzivatel']. "</a></li>
						<li><a href='?logout'> Odhlásit se</a>"?></li>
					</ul>
				</div>
			</div>
		</nav>
		
		<? if (isset($_SESSION['admin'])) { ?>
		<a href="novyInterpret.php" class="btn btn-default pull-right"><span class='glyphicon glyphicon-plus text-success'></span> Přidat interpreta</a>
		<? } ?>
		<?php 
		if (isset($_SESSION['uzivatel'])){
			$sql = "SELECT * FROM oblibenec WHERE login='" .$_SESSION['uzivatel']. "'";
			$favResult = $conn->query($sql);
			$favorites = array();
			while($fRow = $favResult->fetch_assoc()){
			  array_push($favorites, $fRow['interpret']);
			}
		}?>

		<div class="container">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#kapely">Seznam kapel</a></li>
				<li><a data-toggle="tab" href="#hudebnici">Seznam hudebníků</a></li>
			</ul>

			<div class="tab-content">
				<div id="kapely" class="tab-pane fade in active">
				<?
				$sql = "SELECT jmeno FROM interpret ORDER BY jmeno";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) { ?>
					<table class='table table-hover'>
						<thead>
							<tr>
								<? if (isset($_SESSION['uzivatel'])){?>
								<th></th>
								<? } ?>
								<th>Jméno</th>
							</tr>
						</thead>
						<tbody>
							<? while($row = $result->fetch_assoc()) { ?>
							<tr>
								<? if (isset($_SESSION['uzivatel'])){ ?>
								<? if (in_array($row['jmeno'], $favorites)) {?>
								<td class="fit"><form action="interpreti.php" method="post"><button type="submit" class="btn btn-link" name="unsetFavorite" value="<?echo $row["jmeno"]?>" ><span class='glyphicon glyphicon-star star'></span></button></form></td>
								<? } else { ?>
								<td class="fit"><form action="interpreti.php" method="post"><button type="submit" class="btn btn-link" name="setFavorite" value="<?echo $row['jmeno']?>" ><span class='glyphicon glyphicon-star-empty star-empty'></span></button></form></td>
								<? } }?>
								<td><a class="btn btn-link" href='kapela.php?jmeno=<?echo $row["jmeno"]?>'> <?echo $row["jmeno"]?> </a></td>
							</tr>
							<? } ?>
						</tbody>
					</table>
				<? } ?>
				</div>
				<div id="hudebnici" class="tab-pane fade">
					<?
					$sql = "SELECT * FROM umelec ORDER BY jmeno";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) { ?>
						<table class='table table-hover'>
							<thead>
								<tr>
									<th>Jméno</th>
									<th>Datum narození</th>
									<th>Datum úmrtí</th>
									<th>Kapela</th>
								</tr>
							</thead>
							<tbody>
								<? while($row = $result->fetch_assoc()) { 
									$sourceNar = $row["dat_narozeni"];
									$dateNar = new DateTime($sourceNar);
								?>
								<tr>
									<td class="fit"><?echo $row['jmeno']?></td>
									<td class="fit"><?echo $dateNar->format('d.m.Y')?></td>
									<td class="fit"><?echo $row['dat_umrti']?></td>
									<td><a class="btn btn-link" href='kapela.php?jmeno=<?echo $row["jm_interpreta"]?>'> <?echo $row["jm_interpreta"]?> </a></td>
								</tr>
								<?}?>
							<?}?>
							</tbody>
						</table>
				</div>
			</div>
		</div>
	</body>
</html>