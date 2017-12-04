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
			$("#genreKapela").keyup(searchInterpret);
			$("#nameKapela").keyup(searchInterpret);
			$("#nameHudebnik").keyup(searchPerson);
			$("#kapelaHudebnik").keyup(searchPerson);
			$("#nameKoncert").keyup(searchKoncert);
			$("#genreKoncert").keyup(searchKoncert);
			$("#placeKoncert").keyup(searchKoncert);
			$("#dateKoncert").keyup(searchKoncert);
			$("#nameFestival").keyup(searchFestival);
			$("#genreFestival").keyup(searchFestival);
			$("#placeFestival").keyup(searchFestival);
			$("#dateFestival").keyup(searchFestival);
		});

		function searchInterpret() {
		    var nazev = $("#nameKapela").val();
		    var zanr = $("#genreKapela").val();
		    $.ajax({
				url:"search.php",
				type:"POST",
				data: {nazev:nazev,zanr:zanr,searchKapela:true},
				success:function processResponse(data) {
					//console.log("data= "+ data);
					var html = '<table class="table table-hover"><thead><tr><th>Jméno</th></tr></thead><tbody>';
					for (var i = 0; i < data.length; i++){
						html += '<tr><td><a href="kapela.php?jmeno=' + data[i] + '">' + data[i] + '</a></td></tr>';
					}
					html += '</tbody></table>';
					$("#resultKapela").html(html);
				},
				dataType:"json"
			})
		}

		function searchPerson() {
			var jmeno = $("#nameHudebnik").val();
		    var kapela = $("#kapelaHudebnik").val();
		    $.ajax({
				url:"search.php",
				type:"POST",
				data: {jmeno:jmeno,kapela:kapela,searchHudebnik:true},
				success:function processResponse(data) {
					var html = '<table class="table table-hover"><thead><tr><th>Jméno</th><th>Datum narození</th><th>Datum úmrtí</th><th>Kapela</th></tr></thead><tbody>';
					for (var i = 0; i < data.length; i++){
						html += '<tr><td>' + data[i].jmeno + '</td>';
						html += '<td>' + data[i].dat_narozeni + '</td>';
						if(data[i].dat_umrti != null){
							html += '<td>' + data[i].dat_umrti + '</td>';
						} else {
							html += '<td></td>';
						}
						html += '<td>' + data[i].jm_interpreta + '</td></tr>';
					}
					html += '</tbody></table>';
					$("#resultHudebnik").html(html);
				},
				dataType:"json"
			})
		}

		function searchKoncert() {
			var nazev = $("#nameKoncert").val();
			var zanr = $("#genreKoncert").val();
			var misto = $("#placeKoncert").val();
			var datum = $("#dateKoncert").val();
			$.ajax({
				url:"search.php",
				type:"POST",
				data: {nazev:nazev,zanr:zanr,misto:misto,datum:datum,searchKoncert:true},
				success:function processResponse(data) {
					//console.log("data= "+ data);
					var html = '<table class="table table-hover"><thead><tr><th>Název</th></tr></thead><tbody>';
					for (var i = 0; i < data.length; i++){
						html += '<tr><td><a href="udalost.php?u=' + data[i].nazev + '&d=' + data[i].dat_zac +  '">' + data[i].nazev + '</a></td></tr>';
					}
					html += '</tbody></table>';
					$("#resultKoncert").html(html);
				},
				dataType:"json"
			})
		}

		function searchFestival() {
			var nazev = $("#nameFestival").val();
			var zanr = $("#genreFestival").val();
			var misto = $("#placeFestival").val();
			var datum = $("#dateFestival").val();
			$.ajax({
				url:"search.php",
				type:"POST",
				data: {nazev:nazev,zanr:zanr,misto:misto,datum:datum,searchFestival:true},
				success:function processResponse(data) {
					//console.log("data= "+ data);
					var html = '<table class="table table-hover"><thead><tr><th>Název</th></tr></thead><tbody>';
					for (var i = 0; i < data.length; i++){
						html += '<tr><td><a href="udalost.php?u=' + data[i].nazev + '&d=' + data[i].dat_zac + '">' + data[i].nazev + '</a></td></tr>';
					}
					html += '</tbody></table>';
					$("#resultFestival").html(html);
				},
				dataType:"json"
			})
		}
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
						<li><a href="interpreti.php">Interpreti</a></li> 
						<li class="active"><a href="vyhledavani.php">Vyhledávání</a></li>
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

		<div class="container">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#kapely">Vyhledavani kapel</a></li>
				<li><a data-toggle="tab" href="#hudebnici">Vyhledavani hudebniku</a></li>
				<li><a data-toggle="tab" href="#koncerty">Vyhledavani koncertu</a></li>
				<li><a data-toggle="tab" href="#festivaly">Vyhledavani festivalu</a></li>
			</ul>

			<div class="tab-content">
				<div id="kapely" class="tab-pane fade in active">
					<br>
					<form id="formKapela" method="post">
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="nameKapela">Název:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="nameKapela" name="nameKapela" autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="genreKapela">Žánr:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="genreKapela" name="genreKapela">
							</div>
						</div>
					</form>
					<div id="resultKapela">
					</div>
				</div>

				<div id="hudebnici" class="tab-pane fade">
					<br>
					<form id="formHudebnik" method="post">
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="nameHudebnik">Jméno:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="nameHudebnik" name="nameHudebnik" autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="kapelaHudebnik">Kapela:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="kapelaHudebnik" name="kapelaHudebnik">
							</div>
						</div>
					</form>
					<div id="resultHudebnik">
					</div>
				</div>

				<div id="koncerty" class="tab-pane fade">
					<br>
					<form id="formKoncert" method="post">
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="nameKoncert">Název:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="nameKoncert" name="nameKoncert" autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="genreKoncert">Žánr:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="genreKoncert" name="genreKoncert">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="placeKoncert">Místo konání:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="placeKoncert" name="placeKoncert">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="dateKoncert">Datum začátku:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="dateKoncert" name="dateKoncert">
							</div>
						</div>
					</form>
					<div id="resultKoncert">
					</div>
				</div>

				<div id="festivaly" class="tab-pane fade">
					<br>
					<form id="formFestival" method="post">
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="nameFestival">Název:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="nameFestival" name="nameFestival" autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="genreFestival">Žánr:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="genreFestival" name="genreFestival">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="placeFestival">Místo konání:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="placeFestival" name="placeFestival">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-sm-2 col-sm-offset-2" for="dateFestival">Datum začátku:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="dateFestival" name="dateFestival">
							</div>
						</div>
					</form>
					<div id="resultFestival">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>