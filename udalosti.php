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
						<li class="active"><a href="udalosti.php">Události</a></li>
						<li><a href="interpreti.php">Interpreti</a></li>
						<li><a href="vyhledavani.php">Vyhledávání</a></li>
						<li><a href="uzivatele.php" class="<?php if (!isset($_SESSION['admin'])) echo hidden?>">Správa uživatelů</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Registrovat</a></li>
						<li><a href="#" id="loginPopover" data-toggle="popover" title="Příhlášení" data-placement="bottom" data-html="true" data-content='<?=$loginForm?>'><span class="glyphicon glyphicon-log-in"></span> Přihlásit</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (!isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><?php if(isset($_SESSION['uzivatel'])) echo "<a href='profil.php?login=" .$_SESSION['uzivatel']. "'>" .$_SESSION['uzivatel']. "</a></li>
						<li><a href='?logout'> Odhlásit se</a>"?></li>
					</ul>
				</div>
			</div>
		</nav>

		<? if (isset($_SESSION['admin'])) { ?>
			<a href="novaUdalost.php" class="btn btn-default pull-right"><span class='glyphicon glyphicon-plus text-success'></span> Přidat událost</a>
		<? } ?>
		<div class="container">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#festivaly">Festivaly</a></li>
				<li><a data-toggle="tab" href="#koncerty">Koncerty</a></li>
			</ul>

			<div class="tab-content">
				<div id="festivaly" class="tab-pane fade in active">
					<?php 
					$sql = "SELECT * FROM udalost WHERE typ='festival' ORDER BY dat_zac";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) { ?>
						<table class='table table-hover'>
							<thead>
								<tr>
									<th>Jméno</th>
									<th>Ročník</th>
									<th>Žánr</th>
									<th>Datum začátku</th>
									<th>Datum konce</th>
									<th>Místo konání</th>
								</tr>
							</thead>
							<tbody>
							<? while($row = $result->fetch_assoc()) { 
								$sourceOd = $row["dat_zac"];
								$dateOd = new DateTime($sourceOd);
								$sourceDo = $row["dat_kon"];
								$dateDo = new DateTime($sourceDo);
							?>
								<tr>
								<td> <a href='udalost.php?u=<?echo $row["nazev"]?>'><?echo $row["nazev"]?></a></td>
								<td> <?echo $row["rocnik"]?> </td>
								<td> <?echo $row["zanr"]?> </td>
								<td> <?echo $dateOd->format('d.m.Y')?> </td>
								<td> <?echo $dateDo->format('d.m.Y')?> </td>
								<td> <?echo $row["misto_konani"]?> </td>
								</tr>
							<? } ?>
							</tbody>
						</table>
					<? } ?>
				</div>
				<div id="koncerty" class="tab-pane fade">
					<?php 
					$sql = "SELECT * FROM udalost WHERE typ='koncert' ORDER BY dat_zac";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) { ?>
						<table class='table table-hover'>
							<thead>
								<tr>
									<th>Jméno</th>
									<th>Žánr</th>
									<th>Datum</th>
									<th>Kapacita</th>
									<th>Místo konání</th>
								</tr>
							</thead>
							<tbody>
							<? while($row = $result->fetch_assoc()) { 
								$sourceDate = $row["dat_zac"];
								$dateDate = new DateTime($sourceDate);
							?>
								<tr>
								<td> <a href='udalost.php?u=<?echo $row["nazev"]?>'><?echo $row["nazev"]?></a></td>
								<td> <?echo $row["zanr"]?> </td>
								<td> <?echo $dateDate->format('d.m.Y')?> </td>
								<td> <?echo $row["kapacita"]?> </td>
								<td> <?echo $row["misto_konani"]?> </td>
								</tr>
							<? } ?>
							</tbody>
						</table>
					<? } ?>
				</div>
			</div>
		</div>
	</body>
</html>