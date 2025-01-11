 <?php
include 'conexion.php';


if(isset($_POST['guardarProveedor'])){
		$rif=$_POST['rif'];
		$tipoCliente=$_POST['tipoCliente'];
		$nombre=$_POST['nombre'];
		$direccion=$_POST['direccion'];
		$telefono=$_POST['telefono'];
		$email=$_POST['email'];
		$instagram=$_POST['instagram'];

		$rif=$tipoCliente.$rif;


		$sql = "SELECT rif FROM proveedor WHERE rif = '$rif'";
		if (!$query = $mysqli->query($sql)) {	die($mysqli->error);  exit;	}
		if($query -> num_rows == 0){
			$sql = "INSERT INTO proveedor (rif, nombre, telefono, direccion, email, instagram) VALUES ('$rif', UPPER('$nombre'), '$telefono', UPPER('$direccion'), '$email', '$instagram' )";
			if (!$query = $mysqli->query($sql)) {	die($mysqli->error);  exit;	}
			echo 0;
		}else{	echo 1; }



}

if(isset($_POST['vender'])){

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
}


if(isset($_POST["agregarProducto"])){
	$tipoInsumo=$_POST['tipoInsumo'];
	echo '
	<tr>
    <td>
      <div class="row mt-1">         
        <div class="col">
          <select class="form-chose" name="producto[]">
            <option value="0" selected>Producto..</option>';
    
              $sql="SELECT i.id, i.nombre, i.unidad_medida, t.nombre tipoInsumo FROM insumos i, tipo_insumo t WHERE t.id=i.tipo_insumo and t.id=$tipoInsumo ORDER BY i.nombre";
              if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit; }
              $tabindex=0;
              while ($res=$query ->fetch_array()) {
                $codigo=$res['id'];
                $nombre=$res['nombre'];
                $unidadMedida=$res['unidad_medida'];      
                $tipoInsumo=$res["tipoInsumo"];
                echo '<option value="'.$codigo.'" >'.$nombre.'</option>';
              }    
 	echo '
          </select>            
      </div>          
	    </div>
	    <div class="row mt-1">          
	      <div class="col">
	        <input type="number" class="form-control form-control-sm border " placeholder=" Costo Bs" name="montobs[]"  >
	      </div>     
	      <div class="col">
	        <input type="number"  class="form-control form-control-sm border " placeholder="Costo $"  name="montodolar[]">
	      </div>
	      <div class="col">            
	        <input type="number"  class="form-control form-control-sm border "  placeholder="Tasa" name="tasa[]">	        
	      </div>
	      <div class="col-1">            
	      	<button type="button" class="btn  btn-sm btnElimina" value="Agregar" name="eliminar"> <span class="material-symbols-outlined text-danger">cancel</span></button>
	      </div>
	    </div>
	  </td>
	</tr>';
}

?>