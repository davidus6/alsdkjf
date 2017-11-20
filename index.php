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
		<?php include 'database.php'; ?>
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
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Registrovat</a></li>
						<li><a href="#" data-toggle="popover" title="Login" data-placement="bottom" data-html="true" data-content='<?=$loginForm?>'><span class="glyphicon glyphicon-log-in"></span> Přihlásit</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container">
			<div class="row">
				<div class="col-12 col-md-7">
					<h1 class="text-center">Zprávy ze světa hudby</h1>


					<div class="row">
						<div class="col-12 col-md-4" id="news_pic">
							<br>
							<img src="images/reputation.png" id="news_pic" class="img-responsive">
						</div>
						<div class="col-12 col-md-8">
							<h3>Reputation, nové album od Taylor Swift</h3>
							<p class="article">Reputation (česky reputace) je již šesté studové album této americké popové zpěvačky. Bylo vydáno 10.listopadu, ale některé z celkem 15 písniček si fanoušci mohli vyslechnout už dříve. Na nahrávce "End Game" se podílel Ed Sheeran a rapper Future. Album si mezi kritiky vede poměrně dobře a mezi fanoušky ještě lépe.</p>
						</div>
					</div>
					<br>

					<div class="row">
						<div class="col-12 col-md-4" id="news_pic">
							<br>
							<img src="images/koncert.PNG" id="news_pic" class="img-responsive">
						</div>
						<div class="col-12 col-md-8">
							<h3>RECENZE: Kousek Valkýry, trocha hlasů. Svátek v Národním</h3>
							<p class="article">Národní divadlo provedlo část Wagnerovy Valkýry. Lákalo na „nejlepšího wagnerovského tenora současnosti“. Přehánělo, ale aspoň se pod jeho hlavičkou daly také jednou slyšet skutečné hlasy, což je vlastně neskutečné.          <a href="https://kultura.zpravy.idnes.cz/valkyra-forum-karlin-05f-/hudba.aspx?c=A171117_115143_hudba_era">Celý článek čtěte ZDE.</a></p>
						</div>
					</div>
					<br>

					<div class="row">
						<div class="col-12 col-md-4" id="news_pic">
							<br>
							<img src="images/wabi.PNG" id="news_pic" class="img-responsive">
						</div>
						<div class="col-12 col-md-8">
							<h3>Zemřel písničkář Wabi Daněk</h3>
							<p class="article">Po dlouhé nemoci ve věku 70 let zemřel Wabi Daněk, folkový písničkář, autor a původní interpret neoficiální trampské hymny Rosa na kolejích. V posledních letech nahrával a koncertoval s kapelou Ďáblovo stádo, jejich společná tvorba byla velmi ceněná.          <a href="https://kultura.zpravy.idnes.cz/wabi-danek-zemrel-smrt-067-/hudba.aspx?c=A171116_165733_hudba_ane">Celý článek čtěte ZDE.</a></p>
						</div>
					</div>
					<br>
				</div>


				<div class="col-6 col-md-5">
					<h3>Nadcházející události</h3>
					<p>JMÉNO KDY KDE DO_KDY KDO_TAM_BUDE ODKAZ_NA_NÁKUP</p>
					<p>JMÉNO KDY KDE DO_KDY KDO_TAM_BUDE ODKAZ_NA_NÁKUP</p>
					<p>JMÉNO KDY KDE DO_KDY KDO_TAM_BUDE ODKAZ_NA_NÁKUP</p>
					<p>JMÉNO KDY KDE DO_KDY KDO_TAM_BUDE ODKAZ_NA_NÁKUP</p>
					<p>JMÉNO KDY KDE DO_KDY KDO_TAM_BUDE ODKAZ_NA_NÁKUP</p>
				</div>

			</div>
		</div>
	</body>
</html>