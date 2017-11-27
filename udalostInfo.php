<? 
	include "database.php";
	$sql = "SELECT * FROM udalost WHERE nazev = '" .$_POST['id']. "' AND dat_zac = '" .$_POST['date']. "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo json_encode($row);
?>