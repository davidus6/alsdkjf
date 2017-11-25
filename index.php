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

			$('#myModal').on('show.bs.modal', function(e) {
				var id = $(e.relatedTarget).data('id');
				document.cookie = "udalost="+id;
							});
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
						<li class="active"><a href="index.php">Domů</a></li>
						<li><a href="udalosti.php">Události</a></li>
						<li><a href="interpreti.php">Interpreti</a></li> 
						<li><a href="uzivatele.php" class="<?php if (!isset($_SESSION['admin'])) echo hidden?>">Správa uživatelů</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Registrovat</a></li>
						<li><a href="#" id="loginPopover" data-toggle="popover" title="Přihlášení" data-placement="bottom" data-html="true" data-content='<?=$loginForm?>'><span class="glyphicon glyphicon-log-in"></span> Přihlásit</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right <?php if (!isset($_SESSION['uzivatel'])) echo hidden?>">
						<li><?php if(isset($_SESSION['uzivatel'])) echo"<a href='profil.php?login=" .$_SESSION['uzivatel']. "'>" .$_SESSION['uzivatel']. "</a></li>
						<li><a href='?logout'> Odhlásit se</a>"?></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container">
			<div class="row">
				<div class="col-12 col-md-7">
					<h1 class="text-center">Zprávy ze světa hudby</h1>


					<div class="row">
						<div class="col-12 col-md-4">
							<br>
							<img src="images/reputation.png" class="news_pic" class="img-responsive">
						</div>
						<div class="col-12 col-md-8">
							<h3>Reputation, nové album od Taylor Swift</h3>
							<p class="article">Reputation (česky reputace) je již šesté studiové album této americké popové zpěvačky. Bylo vydáno 10.listopadu, ale některé z celkem 15 písniček si fanoušci mohli vyslechnout už dříve. Na nahrávce "End Game" se podílel Ed Sheeran a rapper Future. Album si mezi kritiky vede poměrně dobře a mezi fanoušky ještě lépe.</p>
						</div>
					</div>
					<br>

					<div class="row">
						<div class="col-12 col-md-4">
							<br>
							<img src="images/koncert.PNG" class="news_pic" class="img-responsive">
						</div>
						<div class="col-12 col-md-8">
							<h3>RECENZE: Kousek Valkýry, trocha hlasů. Svátek v Národním</h3>
							<p class="article">Národní divadlo provedlo část Wagnerovy Valkýry. Lákalo na „nejlepšího wagnerovského tenora současnosti“. Přehánělo, ale aspoň se pod jeho hlavičkou daly také jednou slyšet skutečné hlasy, což je vlastně neskutečné.          <a href="https://kultura.zpravy.idnes.cz/valkyra-forum-karlin-05f-/hudba.aspx?c=A171117_115143_hudba_era">Celý článek čtěte ZDE.</a></p>
						</div>
					</div>
					<br>

					<div class="row">
						<div class="col-12 col-md-4">
							<br>
							<img src="images/wabi.PNG" class="img-responsive">
						</div>
						<div class="col-12 col-md-8">
							<h3>Zemřel písničkář Wabi Daněk</h3>
							<p class="article">Po dlouhé nemoci ve věku 70 let zemřel Wabi Daněk, folkový písničkář, autor a původní interpret neoficiální trampské hymny Rosa na kolejích. V posledních letech nahrával a koncertoval s kapelou Ďáblovo stádo, jejich společná tvorba byla velmi ceněná.          <a href="https://kultura.zpravy.idnes.cz/wabi-danek-zemrel-smrt-067-/hudba.aspx?c=A171116_165733_hudba_ane">Celý článek čtěte ZDE.</a></p>
						</div>
					</div>
					<br>
				</div>


				<div class="col-12 col-md-5">
					<h2 class="text-center">Nadcházející události</h2>
					<?php
						if (isset($_POST['buy'])){
							if(isset($_SESSION['uzivatel'])){
								$sql = "SELECT * FROM udalost WHERE nazev='".$_POST['buy']."'";
								if ($result = $conn->query($sql)){
									$row = $result->fetch_assoc();
									$sql = "INSERT INTO vstupenka(cena, login, typ, udalost, dat_zac) VALUES('".$row['cena']."', '".$_SESSION['uzivatel']."', '".$row['typ']."', '".$_POST['buy']."', '".$row['dat_zac']."')";
									if ($conn->query($sql) != false){
										echo "Vstupenka zakoupena.";
									}
									else{
										echo "Chyba1 databáze při nákupu vstupenky.";
									}
								}
								else{
									echo "Chyba2 databáze při nákupu vstupenky.";
								}
							}
							else{
								echo "Nákup je možný pouze pro přihlášené uživatele.";
							}
						}
						$sql = "SELECT * FROM udalost ORDER BY dat_zac";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) { ?>
							<table class='table table-hover'>
								<thead>
									<tr>
										<th></th>
										<th>Datum</th>
										<th>Město</th>
										<th>Cena[Kč]</th>
										<th></th>
									</tr>
								</thead>
								<tbody>

								<? $limit = 5;
								 while($row = $result->fetch_assoc()) {
									if($limit == 0)
										break;
									if ($row["dat_zac"] < date("Y-m-d"))
										continue; ?>
									<tr>
									<td><span style='font-weight:bold'> <?echo $row["nazev"]?> </span></td>
									<td><?echo $row["dat_zac"]?></td>
									<td><?echo $row["misto_konani"]?></td>
									<td><?echo $row["cena"]?></td>
									<td><button type="button" class="btn btn-default" data-id="<?echo $row['nazev']?>" data-toggle="modal" data-target="#myModal">Koupit lístek</button></td>
								
									</tr>
									<? $limit--; } ?>
								</tbody>
							</table>
						<? } ?>
				</div>

				<div id="myModal" class="modal fade" role="dialog">
					<div class="modal-dialog modal-sm">

					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Potvrzení nákupu</h4>
						</div>
						<div class="modal-body">
							<p>Opravdu si přejete vstupenku zakoupit?</p>
						</div>
						<div class="modal-footer">
							<form action='' method='post'><button type='submit' name='buy' value='<?echo $_COOKIE["udalost"]?>' class='btn btn-default pull-left'>Koupit</button></form>
							<button type="button" class="btn btn-default" data-dismiss="modal">Zavřít</button>
						</div>
					</div>

					</div>
				</div>		
			</div>
		</div>
	</body>
</html>