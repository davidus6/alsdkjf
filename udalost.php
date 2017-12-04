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
		
			$('#interpretModal').on('show.bs.modal', function(e) {
				var id = $(e.relatedTarget).data('id');
				document.cookie = "udalost="+id;
				var date = $(e.relatedTarget).data('date');
				document.cookie = "datum="+date;
				var stage = $(e.relatedTarget).data('stage');
				document.cookie = "stage="+stage;
			});

			$('#myModal').on('show.bs.modal', function(e) {
				var id = $(e.relatedTarget).data('id');
				document.cookie = "udalost="+id;
				var date = $(e.relatedTarget).data('date');
				document.cookie = "datum="+date;
				$.ajax({
					url:"udalostInfo.php",
					type:"POST",
					data: {id:id,date:date},
					success:function processResponse(data) {
						//console.log(data);
						window.udalostInfo = data;
						$('#celkCena').html("Celková cena: "+ data['cena_zaklad'] +" Kč");
					},
					dataType:"json"
				})
			});

			$('input[type=radio][name=type]').change(function() {
			 	if (this.value == "vip"){
			 		var cena1 = $('#pocet').val() * parseInt(udalostInfo['cena_vip']);
			 	} else {
			 		var cena1 = $('#pocet').val() * parseInt(udalostInfo['cena_zaklad']);
			 	}
			 	$('#celkCena').html("Celková cena: " + cena1 + " Kč");
			});

			 $('input[name=pocet]').bind('keyup mouseup', function() {
			 	if ($('#typ_vip').is(":checked")){
			 		var cena = $('#pocet').val() * parseInt(udalostInfo['cena_vip']);
			 	} else {
			 		var cena = $('#pocet').val() * parseInt(udalostInfo['cena_zaklad']);
			 	}
			 	$('#celkCena').html("Celková cena: " + cena + " Kč");
			 });
		});
		function printDiv(divId) {
			var forPrint = document.getElementById(divId).innerHTML;
			var normalPage = document.body.innerHTML;
			document.body.innerHTML = forPrint;
			window.print();
			document.body.innerHTML = normalPage;
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
						<li class="active"><a href="udalosti.php">Události</a></li>
						<li><a href="interpreti.php">Interpreti</a></li>
						<li><a href="vyhledavani.php">Vyhledávání</a></li>
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
			if (isset($_POST['buy'])){
							if(isset($_SESSION['uzivatel'])){
								$sql = "SELECT * FROM udalost WHERE nazev='".$_COOKIE['udalost']."' AND dat_zac='".$_COOKIE['datum']."'";
								if ($result = $conn->query($sql)){
									$row = $result->fetch_assoc();
									$cena = (($_POST['type']=='vip')?$row['cena_vip']:$row['cena_zaklad']);
									for ($i = 0; $i<$_POST['pocet'];$i++){
										$sql = "INSERT INTO vstupenka(cena, login, typ, udalost, dat_zac) VALUES('".$cena."', '".$_SESSION['uzivatel']."', '".$_POST['type']."', '".$_COOKIE['udalost']."', '".$row['dat_zac']."')";
										$r = $conn->query($sql);
									}
									if ($r != false){
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

			if(isset($_POST['confirm'])){
				$sql = "UPDATE udalost SET zanr='" .$_POST['zanr']. "' WHERE nazev='" .$_POST['confirm']. "'";
				$conn->query($sql);
				$sql = "UPDATE udalost SET misto_konani='" .$_POST['place']. "' WHERE nazev='" .$_POST['confirm']. "'";
				$conn->query($sql);
				$sql = "UPDATE udalost SET cena_zaklad='" .$_POST['price_zak']. "' WHERE nazev='" .$_POST['confirm']. "'";
				$conn->query($sql);
				$sql = "UPDATE udalost SET cena_vip='" .$_POST['price_vip']. "' WHERE nazev='" .$_POST['confirm']. "'";
				$conn->query($sql);
				if ($_POST['type'] == 'festival'){
					$sql = "UPDATE udalost SET dat_kon='" .$_POST['dat_to']. "' WHERE nazev='" .$_POST['confirm']. "'";
					$conn->query($sql);
				}
			}

			$sql = "SELECT * FROM udalost WHERE nazev = '".$_GET["u"]."'";	//TODO i datum zac
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();

			if(isset($_POST['addStage'])){
				$sql = "INSERT INTO stage VALUES ('" .$_POST['name']. "','" .$_POST['capacity']. "','" .$_POST['capacityInts']."','" .$_POST['area']. "')";
				$conn->query($sql);
				$sql = "INSERT INTO stage_udalost VALUES ('" .$_GET['u']. "','" .$row['dat_zac']. "','" .$_POST['name']. "')";
				$conn->query($sql);
			}

			if(isset($_POST['chooseStage'])){
				$sql = "INSERT INTO stage_udalost VALUES ('" .$_GET['u']. "','" .$row['dat_zac']. "','" .$_POST['stage_nazev']. "')";
				$conn->query($sql);
			}

			if(isset($_POST['addInterpret'])){
				$jako = (isset($_POST['jako']))?$_POST['jako']:NULL;
				$sql = "INSERT INTO interpret_stage VALUES ('" .$_POST['chooseInterpret']. "','" .$_COOKIE['stage']. "','" .$jako. "','" .$_POST['od']. "','" .$_POST['do']. "')";
				$conn->query($sql);
				$sql = "INSERT INTO interpret_udalost VALUES ('" .$_POST['chooseInterpret']. "','" .$_GET['u']. "','" .$_COOKIE['datum']. "','" .$jako. "','" .$_POST['od']. "','" .$_POST['do']. "')";
				$conn->query($sql);
			}

			$sql = "SELECT * FROM stage_udalost WHERE udalost='".$row['nazev']."' AND dat_zac='".$row['dat_zac']."'";
			$result_stages = $conn->query($sql);
			$no_stages = $result_stages->num_rows;
			$sql = "SELECT * FROM interpret_udalost WHERE udalost='".$row['nazev']."' AND dat_zac='".$row['dat_zac']."' ORDER BY jako";
			$result = $conn->query($sql);
			$no_interpret = $result->num_rows;

			$names_array = array();

		?>

		<div class='container'>
			<div class='row'>
				<div class='col-12 col-md-4'>
					<br>
					<img src='images/event.jpeg' class='profile_pic' class='img-responsive'>
					<br><br>
				</div>
				<div class="col-12 col-md-6">
					<?if(!isset($_POST['edit'])){
						echo "<h1>" .$row["nazev"]. "</h1>";
					}
					?>
					<?if (!isset($_SESSION['admin'])){?>
						<h3>Žánr: </h3><h4><?echo $row["zanr"]?></h4>
						<br><br>
						<h3>Místo konání: </h3><h4><?echo $row["misto_konani"]?></h4>
						<br><br>
						<?if ($row['typ'] == 'festival'){
							$sourceOd = $row["dat_zac"];
							$dateOd = new DateTime($sourceOd);
							$sourceDo = $row["dat_kon"];
							$dateDo = new DateTime($sourceDo);
							//echo $date->format('d.m.Y');
						?>
							<h3>Datum: </h3><h4><?echo " od ".$dateOd->format('d.m.Y')." do ".$dateDo->format('d.m.Y')?></h4>
						<?}
						else{
							$sourceOd = $row["dat_zac"];
							$dateOd = new DateTime($sourceOd);
							?>
							<h3>Datum: </h3><h4><?echo $dateOd->format('d.m.Y')?></h4>
						<?}?>
						<br><br>
						<h3>Cena: </h3><h4><?echo $row['cena_zaklad']?> Kč, VIP <?echo $row['cena_vip']?> Kč</h4>
						<br><br>
						<button type="button" class="btn btn-default" data-date="<?echo $row['dat_zac']?>" data-id="<?echo $row['nazev']?>" data-toggle="modal" data-target="#myModal">Koupit lístek</button>
						<br><br><br>
					<?} else { 
						$sourceOd = $row["dat_zac"];
						$dateOd = new DateTime($sourceOd);
					?>
						<form action='' class='form-horizontal' method='post'>
							<h3>Žánr: </h3><input type='text' class='form-control' name='zanr' value='<?echo $row["zanr"]?>' required>
							<h3>Místo konání: </h3><input type='text' class='form-control' name='place' value='<?echo $row["misto_konani"]?>'>
							<h3>Datum začátku: </h3><br><h4><?echo $dateOd->format('d.m.Y')?></h4><br>
							<? if($row['typ'] == 'festival'){ ?>
							<h3>Datum ukončení: </h3><input type='text' class='form-control' name='dat_to' value='<?echo $row["dat_kon"]?>'>
							<? } ?>
							<h3>Cena zaklad: </h3><input type='text' class='form-control' name='price_zak' value='<?echo $row["cena_zaklad"]?>'>
							<h3>Cena VIP: </h3><input type='text' class='form-control' name='price_vip' value='<?echo $row["cena_vip"]?>'>
							<input type='hidden' class='form-control' name='type' value='<?echo $row["typ"]?>'>
							<button type='submit' name='confirm' value='<?php echo $row["nazev"]?>' class='btn btn-default'><span class='glyphicon glyphicon-ok text-success'></span> Potvrdit změny</button>
						</form>
					<? } ?>
				</div>
			</div>
		</div>

		<?if($row['typ'] == 'koncert'){?>
		<div class="container">
			<p>Celkem kapel: <?echo $no_interpret?></p>
			<p>Kapacita: <?echo $row['kapacita']?></p>
			<br>
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#kapely">Kapely</a></li>
			</ul>
			<div class="tab-content">
				<div id="kapely" class="tab-pane fade in active">
					<?if($no_interpret > 0){?>
					<table class='table table-hover'>
						<thead>
							<tr>
								<th>Jméno</th>
								<th>Jako</th>
							</tr>
						</thead>
						<tbody>
							<? while($kapely = $result->fetch_assoc()) { ?>
								<tr>
									<td> <?echo "<a href = 'kapela.php?jmeno=" .$kapely['interpret']. "'>" .$kapely['interpret']. "</a>"; ?> </td>
									<td><?echo $kapely['jako']?></td>
								</tr>
							<?}?>
						</tbody>
					</table>
					<?}?>
				</div>
			</div>
		</div>
		<?} else {?>
		<div class="container">
		<p>Celkem kapel: <?echo $no_interpret?></p>
		<p>Celkem stage: <?echo $no_stages?></p>
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
			}
			if (isset($_SESSION['admin'])){ ?>
				<li><a href="#novaStage" data-toggle="tab" class="btn btn-link"><span class='glyphicon glyphicon-plus text-success'></span></a></li>
			<? } ?>
		</ul>
			<div class="tab-content">
				<?
				for($i = 0; $i < $no_stages; $i++) {
					$sql = "SELECT * FROM stage WHERE nazev='".$names_array[$i]."'";
					$result = $conn->query($sql);
					$stage_row = $result->fetch_assoc();
					if($i == 0){
						echo '<div id="'.$i.'" class="tab-pane fade in active">'?>
					<?}
					else{?>
						<div id="<?echo $i?>" class="tab-pane fade">
					<?
					}
					if (isset($_SESSION['admin'])){?>
						<button type="button" class="btn btn-default pull-right" data-stage="<?echo $names_array[$i]?>" data-date="<?echo $row['dat_zac']?>" data-id="<?echo $row['nazev']?>" data-toggle="modal" data-target="#interpretModal"><span class='glyphicon glyphicon-plus text-success'></span> Přidat interpreta</button>
					<? } ?>
						<br>
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
								<? while($ints_of_stage = $result->fetch_assoc()) { 
									$sInterpretOd = $ints_of_stage['od'];
									$sDateOd = new DateTime($sInterpretOd);
									$sInterpretDo = $ints_of_stage['do'];
									$sDateDo = new DateTime($sInterpretDo);
								?>
									<tr>
										<td> <?echo "<a href = 'kapela.php?jmeno=" .$ints_of_stage['interpret']. "'>" .$ints_of_stage['interpret']. "</a>"; ?> </td>
										<td> <?echo $ints_of_stage['jako']?> </td>
										<td> <?echo $sDateOd->format('d.m.Y')?> </td>
										<td> <?echo $sDateDo->format('d.m.Y')?> </td>
									</tr>
								<?}?>
							</tbody>
						</table>
						<?}?>
						</div>
					<?}?>
			<?if (isset($_SESSION['admin'])){ ?>
				<div id="novaStage" class="tab-pane fade">
					<div class="row">
						<div class="col-sm-6 border-right">
							<form method="post">
								Založit novou stage:
								<div class="form-group row">
									<br>
									<label class="control-label col-sm-2" for="name">Název:</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="name" name="name">
									</div>
								</div>
								<div class="form-group row">
									<br>
									<label class="control-label col-sm-2" for="capacity">Kapacita diváků:</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="capacity" name="capacity">
									</div>
								</div>
								<div class="form-group row">
									<br>
									<label class="control-label col-sm-2" for="capacityInts">Kapacita interpretů:</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="capacityInts" name="capacityInts">
									</div>
								</div>
								<div class="form-group row">
									<label class="control-label col-sm-2" for="area">Plocha:</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="area" name="area">
									</div>
								</div>
								<button class="btn btn-default" type="submit" name="addStage"><span class='glyphicon glyphicon-plus text-success'></span> Přidat</button>
							</form>
						</div>
						<div class="col-sm-6">
							Vybrat z již existujících stage:<br><br>
							<select class="form-control" name="stage_nazev" form="choose">
								<?
								$sql = "SELECT nazev FROM stage";
								$result = $conn->query($sql);
								for($i = 0; $i < $result->num_rows; $i++){ 
								$row = $result->fetch_assoc(); ?>
								<option value="<?echo $row['nazev']?>"><?echo $row['nazev']?></option>
								<? } ?>
								
							</select>
							<form id="choose" method="post">
								<button type="submit" class="btn btn-default" name="chooseStage" value="true">Vybrat</button>
							</form>
						</div>
					</div>
				</div>
			<? } ?>
			</div>
		</div>
		<?}?>

				<div id="interpretModal" class="modal fade" role="dialog">
					<div class="modal-dialog modal-sm">

					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							Přidat interpreta
						</div>
						<div class="modal-body">
							<form action='' method='post' id="chooseInt">
							<select class="form-control" form="chooseInt" name="chooseInterpret">
								<?
									$sql = "SELECT jmeno FROM interpret";
									$result = $conn->query($sql);
									while($row = $result->fetch_assoc()){
								?>
								<option value="<?echo $row['jmeno']?>"><?echo $row['jmeno']?></option>
								<? } ?>
							</select>
							Od: <input type="text" class="form-control" name="od">
							Do: <input type="text" class="form-control" name="do">
							Headliner: <input type="checkbox" class="form-control" name="jako" value="headliner">
						</div>
						<div class="modal-footer">
							<button type='submit' name='addInterpret' value='true' class='btn btn-default pull-left'>Přidat</button></form>
							<button type="reset" class="btn btn-default" data-dismiss="modal">Zavřít</button>
						</div>
					</div>

					</div>
				</div> 

				<div id="myModal" class="modal fade" role="dialog">
					<div class="modal-dialog modal-sm">

					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Potvrzení nákupu</h4>
						</div>
						<div class="modal-body">
							<form action='' method='post'>
							Typ vstupenky:
							<label class="radio-inline"><input type="radio" name="type" value="zaklad" checked>Základní</label>
							<label class="radio-inline"><input type="radio" name="type" id="typ_vip" value="vip">VIP</label>
							<br><br>Počet vstupenek:
							<input class="col-xs-1 form-control" type="number" min="0" name="pocet" id="pocet" value="1"><br>
							<label name="cena" id="celkCena"></label>
						</div>
						<div class="modal-footer">
							<button type='submit' name='buy' value='true' class='btn btn-default pull-left'>Koupit</button></form>
							<button type="reset" class="btn btn-default" data-dismiss="modal">Zavřít</button>
						</div>
					</div>

					</div>
				</div>


				<input type="button" onclick="printDiv('printableArea')" value="print a div!" />

				<div id="printableArea" hidden>
					<?
					$sql = "SELECT * FROM udalost WHERE nazev = '".$_GET["u"]."'";	//TODO i datum zac
					$result = $conn->query($sql);
					$row = $result->fetch_assoc();
					?>
					<h1><?echo $row["nazev"]?></h1>
					<br><br>
					<h3>Žánr: </h3><h4><?echo $row["zanr"]?></h4>
					<br><br>
					<h3>Místo konání: </h3><h4><?echo $row["misto_konani"]?></h4>
					<br><br>
					<?if ($row['typ'] == 'festival'){
						$sourceOd = $row["dat_zac"];
						$dateOd = new DateTime($sourceOd);
						$sourceDo = $row["dat_kon"];
						$dateDo = new DateTime($sourceDo);
					?>
						<h3>Datum: </h3><h4><?echo " od ".$dateOd->format('d.m.Y')." do ".$dateDo->format('d.m.Y')?></h4>
					<?}
					else{
						$sourceOd = $row["dat_zac"];
						$dateOd = new DateTime($sourceOd);
						?>
						<h3>Datum: </h3><h4><?echo $dateOd->format('d.m.Y')?></h4>
					<?}?>
					<br><br>
					<h3>Cena: </h3><h4><?echo $row['cena_zaklad']?> Kč, VIP <?echo $row['cena_vip']?> Kč</h4>
					<br><br>
					<?
					$sql = "SELECT * FROM vstupenka WHERE udalost='".$row['nazev']."' AND dat_zac='".$row['dat_zac']."' AND typ='vip'";
					$result = $conn->query($sql);
					$num_vip = $result->num_rows;
					$sql = "SELECT * FROM vstupenka WHERE udalost='".$row['nazev']."' AND dat_zac='".$row['dat_zac']."'";
					$result = $conn->query($sql);
					$num_celk = $result->num_rows;
					?>
					<h3>Prodaných vstupenek: </h3><h4><?echo $num_celk?> (<?echo $num_vip?> VIP) aktuální k <?echo date("d.m.Y")?></h4>
					<?
					$sql = "SELECT * FROM interpret_udalost WHERE udalost='".$row['nazev']."' AND dat_zac='".$row['dat_zac']."' ORDER BY interpret";
					$result = $conn->query($sql);
					?>
					<br><br>
					<h2>Seznam interpretů</h2>
					<br>
					<?while($kap = $result->fetch_assoc()) {?>
						<h4>
							<?echo $kap['interpret'];?>
						</h4>
						<br>
					<?}?>
				</div>
	</body>
</html>