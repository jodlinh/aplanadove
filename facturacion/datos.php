 <?php

include 'conexion.php';


$cedula=$_POST['cedula'];
$tipoCliente=$_POST['tipoCliente'];
$nombre=$_POST['nombre'];
$direccion=$_POST['direccion'];
$telefono=$_POST['telefono'];

$cedula=$tipoCliente.$cedula;


$sql = "SELECT cedula FROM cliente WHERE cedula = '$cedula'";
if (!$query = $mysqli->query($sql)) {	die($mysqli->error);  exit;	}
if($query -> num_rows == 0){
	$sql = "INSERT INTO cliente (cedula, nombre, telefono, direccion) VALUES ('$cedula', UPPER('$nombre'), '$telefono', UPPER('$direccion'))";
	if (!$query = $mysqli->query($sql)) {	die($mysqli->error);  exit;	}
	echo 0;
}else{	echo 1; }


?>