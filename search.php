<?php
	include "database.php";
	if (isset($_POST['searchKapela'])){
		$jmeno = $_POST['nazev'];
		$zanr = $_POST['zanr'];
		$sql = "SELECT jmeno FROM interpret WHERE jmeno LIKE '%" .$jmeno. "%' AND zanr LIKE '%" .$zanr. "%'";
		$result = $conn->query($sql);
		$output = array();
		while($row = $result->fetch_assoc()){
			array_push($output, $row['jmeno']);
		}
		echo json_encode($output);
	}

	if (isset($_POST['searchHudebnik'])){
		$jmeno = $_POST['jmeno'];
		$kapela = $_POST['kapela'];
		$sql = "SELECT * FROM umelec WHERE jmeno LIKE '%" .$jmeno. "%' AND jm_interpreta LIKE '%" .$kapela. "%'";
		$result = $conn->query($sql);
		$output = array();
		while($row = $result->fetch_assoc()){
			$output[] = $row;
		}
		echo json_encode($output);
	}

	if (isset($_POST['searchKoncert'])){
		$nazev = $_POST['nazev'];
		$zanr = $_POST['zanr'];
		$misto = $_POST['misto'];
		$datum = $_POST['datum'];
		$sql = "SELECT nazev FROM udalost WHERE typ = 'koncert' AND nazev LIKE '%" .$nazev. "%' AND zanr LIKE '%" .$zanr. "%' AND dat_zac LIKE '%" .$datum. "%' AND misto_konani LIKE '%" .$misto. "%'";
		$result = $conn->query($sql);
		$output = array();
		while($row = $result->fetch_assoc()){
			array_push($output, $row['nazev']);
		}
		echo json_encode($output);
	}

	if (isset($_POST['searchFestival'])){
		$nazev = $_POST['nazev'];
		$zanr = $_POST['zanr'];
		$misto = $_POST['misto'];
		$datum = $_POST['datum'];
		$sql = "SELECT nazev FROM udalost WHERE typ = 'festival' AND nazev LIKE '%" .$nazev. "%' AND zanr LIKE '%" .$zanr. "%' AND dat_zac LIKE '%" .$datum. "%' AND misto_konani LIKE '%" .$misto. "%'";
		$result = $conn->query($sql);
		$output = array();
		while($row = $result->fetch_assoc()){
			array_push($output, $row['nazev']);
		}
		echo json_encode($output);
	}
?>