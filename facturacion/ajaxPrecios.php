 <?php

include 'conexion.php'; 


if(isset($_POST['idProducto'])){
	$idProducto=$_POST['idProducto'];
	$tipoPrecio=$_POST['tipoPrecio'];


if($tipoPrecio==1){
  $precio="precio1";
}elseif ($tipoPrecio==2) {
  $precio="precio2";
}elseif($tipoPrecio==3){
  $precio="precio_venta";
}


	$sql = "SELECT $precio precio FROM productos WHERE codigo = $idProducto";
	if (!$query = $mysqli->query($sql)) {	die($mysqli->error);  exit;	}
	if($query -> num_rows > 0){
		$res=$query -> fetch_array();
		$precio=$res["precio"];

		echo $precio;
	}
}

?>