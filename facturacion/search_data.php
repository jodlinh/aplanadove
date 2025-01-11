 <?php

$mysqli = new mysqli("localhost", "jhuerta", "dFt&523$$.123", "aplanado");
if ($mysqli->connect_errno) {	die($mysqli->connect_error);  exit;}
$mysqli->select_db("aplanado"); 


$sql = "SELECT nombre FROM cliente WHERE nombre LIKE '%".$_GET['query']."%' LIMIT 5";
if (!$query = $mysqli->query($sql)) {	die($mysqli->error);  exit;	}
$json = array();
while($rows = $query -> fetch_array()){
	$json[] = $rows["nombre"];
}

echo json_encode($json);
?>