 <?php
include 'conexion.php';

$fechaCompra= $_POST['fechaCompra']; 
$fechaCompra = str_replace('/', '-', $fechaCompra);
$fechaCompra = date("Y-m-d", strtotime($fechaCompra));
$nombre= $_POST['nombre']; 
$tipoVenta=$_POST['tipoVenta'];
$idVendedor=$_POST['idVendedor'];
$tipoPrecio=$_POST['tipoPrecio'];

if($tipoPrecio==1){
  $precio="precio1";
}elseif ($tipoPrecio==2) {
  $precio="precio2";
}elseif($tipoPrecio==3){
  $precio="precio_venta";
}


if(strlen($_POST['cantTequenoton'])==0) 
	$cantTequenoton=0; 
else { 
	$cantTequenoton=$_POST['cantTequenoton']; 
	$lista[]= array("producto"=> 1, "cantidad" => $cantTequenoton); 
}

if(strlen($_POST['cantArepafit'])==0) 
	$cantArepafit=0; 
else { 
	$cantArepafit=$_POST['cantArepafit']; 
	$lista[]= array("producto"=> 2, "cantidad" => $cantArepafit);
}
if(strlen($_POST['cantPataconPowerAmarillo'])==0) 
	$cantPataconPowerAmarillo=0; 
else { 
	$cantPataconPowerAmarillo=$_POST['cantPataconPowerAmarillo']; 
	$lista[]= array("producto"=> 3, "cantidad" => $cantPataconPowerAmarillo);
}
if(strlen($_POST['cantFullPataconAmarillo'])==0) 
	$cantFullPataconAmarillo=0; 
else { 
	$cantFullPataconAmarillo=$_POST['cantFullPataconAmarillo'];
	$lista[]= array("producto"=> 4, "cantidad" => $cantFullPataconAmarillo);
}
if(strlen($_POST['cantMinitoston'])==0) 
	$cantMinitoston=0; 
else { 
	$cantMinitoston=$_POST['cantMinitoston'];
	$lista[]= array("producto"=> 5, "cantidad" => $cantMinitoston);
}
if(strlen($_POST['cantCoquitos'])==0) 
	$cantCoquitos=0; 
else { 
	$cantCoquitos=$_POST['cantCoquitos'];
	$lista[]= array("producto"=> 6, "cantidad" => $cantCoquitos);
}
if(strlen($_POST['cantPataconPowerVerde'])==0) 
	$cantPataconPowerVerde=0; 
else { 
	$cantPataconPowerVerde=$_POST['cantPataconPowerVerde'];
	$lista[]= array("producto"=> 7, "cantidad" => $cantPataconPowerVerde);
}
if(strlen($_POST['cantFullPataconVerde'])==0) 
	$cantFullPataconVerde=0; 
else { 
	$cantFullPataconVerde=$_POST['cantFullPataconVerde'];
	$lista[]= array("producto"=> 8, "cantidad" => $cantFullPataconVerde);
}


$sql = "SELECT id, nombre FROM cliente  WHERE nombre = '$nombre'";
if (!$query = $mysqli->query($sql)) {	die($mysqli->error);  exit;	}
if($query -> num_rows == 0){
	exit('0');
}else{

	$res=$query -> fetch_array();
	$idCliente= $res["id"];


	if(strlen($fechaCompra)==0) exit('1');
	$hoy=date('Y-m-d');
	$fecha = date("Y-m-d", strtotime($fechaCompra));



	if($cantTequenoton==0 and $cantArepafit==0 and $cantPataconPowerAmarillo==0 and $cantFullPataconAmarillo==0 and $cantMinitoston==0 and $cantCoquitos==0 and $cantPataconPowerVerde==0 and $cantFullPataconVerde==0){
		exit('2');
	}


	if($tipoVenta==-1){		exit('3');	}

	$sql="INSERT INTO facturacion (id_vendedor, id_cliente, fecha_compra, tipo_pago) VALUES ($idVendedor, $idCliente, '$fecha', $tipoVenta)";
	if (!$query = $mysqli->query($sql)) {	die($mysqli->error);  exit;	}

	$serial= $mysqli -> insert_id; //SERIAL DE LA VENTA	


	 for($i=0;$i<count($lista); $i++){
	 	 $producto=$lista[$i]["producto"];
	 	 $cantidad=$lista[$i]["cantidad"];

		$sql = "SELECT $precio precio FROM productos  WHERE codigo = $producto";
		if (!$query = $mysqli->query($sql)) {	die($mysqli->error);  exit;	}
		$res=$query -> fetch_array();
		$precioVenta=$res['precio'];


		$sql="INSERT INTO detalles_facturacion (id_facturacion, id_productos, cantidad, precio) VALUES ($serial, $producto, $cantidad, $precioVenta)";
		if (!$query = $mysqli->query($sql)) {	die($mysqli->error);  exit;	}		
	}

	exit('4');
}



?>