<?php 

include 'conexion.php'; 


if(isset($_POST['filtrar'])){

	$estatusVenta=$_POST['estatusVenta'];
	$fechaInicio=$_POST['fechaInicio'];
	$fechaFin= $_POST['fechaFin'];

	$fechaInicio = str_replace('/', '-', $fechaInicio);
	$fechaFin = str_replace('/', '-', $fechaFin);

	$fechaInicio = date("Y-m-d", strtotime($fechaInicio));
	$fechaFin = date("Y-m-d", strtotime($fechaFin));


	if($estatusVenta==0) 	   $status="and pagado=0";
	elseif ($estatusVenta==1)  $status="and pagado=1";
	else 					   $status="";
		

/*
	 <table class="table table-hover table-sm table-borderless">
	        <thead>
	          <tr>
	            <th scope="col"># Fac</th>
	            <th scope="col">Cliente</th>            
	            <th scope="col">Fecha</th>
	           <!-- <th scope="col">Tipo Venta</th> -->
	            <th scope="col" class="text-end">Total</th>
	            <th scope="col" class="text-end">Abonado</th>
	           	<th scope="col" class="text-end"> </th>
	            <th colspan="3" scope="col"> </th>            
	          </tr>
	        </thead>
	          <tbody>
*/
	 ?>
	            <?php
	              $sql="SELECT id, id_cliente, fecha_compra, tipo_pago, pagado from facturacion WHERE fecha_compra BETWEEN '$fechaInicio' and '$fechaFin'  $status ORDER BY id DESC";              
	              if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit; }
	              if($query -> num_rows > 0){
	                while ($res = $query -> fetch_array()) {
	                    $factura = $res['id'];
	                    $idCliente = $res['id_cliente'];
	                    $fechaCompra = $res['fecha_compra'];
	                    $tipoPago = $res['tipo_pago'];
	                    $pagado= $res['pagado'];

	                    if($tipoPago==0) $tipo="Crédito";
	                    elseif($tipoPago==1) $tipo="Contado";

	                    if($pagado==0) { $status="<span class='text-danger'><span class='material-symbols-outlined'>cancel</span></span>";  }
	                    elseif($pagado==1) { $status="<span class='text-success'><span class='material-symbols-outlined'>check</span></span>";  }




	                    $sql="SELECT nombre from cliente WHERE id = $idCliente";              
	              		if (!$query1 = $mysqli->query($sql)) { die($mysqli->error);  exit; }
	              		$res1= $query1 -> fetch_array();
	              		$nombreCliente=$res1['nombre'];

	              		$sql="SELECT cantidad*precio total from detalles_facturacion WHERE id_facturacion = $factura";              
	              		if (!$query2 = $mysqli->query($sql)) { die($mysqli->error);  exit; }
	              		$acum=0;
	              		while ($res2= $query2 -> fetch_array()){
	              			$monto=$res2['total'];
	              			$acum+=$monto;
	              		}

	              		$sql="SELECT IFNULL(sum(monto_dolar), 0) abonado FROM pago_facturas WHERE id_facturacion=$factura";
	              		if (!$query2 = $mysqli->query($sql)) { die($mysqli->error);  exit; }
	              		$res2= $query2 -> fetch_array();
	              		$abonado=$res2["abonado"];


	              		$pendiente=$acum-$abonado;

	              		if($pendiente >0){
	              			$color="text-danger-emphasis";
	              			$bgcolor="bg-danger";
	              		}else{
	              			$color="text-success";
	              			$bgcolor="bg-success";
	              		}
	 
	              		$nombreCliente=$res1['nombre'];

	                    echo '	
	                    <div class="row '.$bgcolor.' text-white">
	                    	<div class="col-1 fw-bold">'.$factura.'</div>
	                    	<div class="col  fw-bold text-start">'.$nombreCliente.'</div>
	                    </div>
	                    <table class="table table-hover table-sm">                
	                    <thead> 
	                    	<tr>
	              				<th scope="col">Fecha</th>						        
						        <th scope="col" class="text-end">Total</th>
						        <th scope="col" class="text-end">Abono</th>
						        <th scope="col" class="text-end">Pend.</th>
						        <th scope="col" class="text-end">Status </th>
						        <th scope="col">Pagar </th>                   						                       
	                      	</tr>
	                    </thead>
	                    <tbody>
	                      <td><a  class="btn"  onClick="verFactura('.$factura.');">'.$fechaCompra.'</a></td>	                    
	                      <td class="text-end">'.$acum.'</td>
	                      <td class="text-end"><a  class="btn"  onClick="verAbonos('.$factura.');">'.$abonado.'</a></td>
	                      <td class="text-end '.$color.'">'.$pendiente.'</td>
	                      <td class="text-end">'.$status.'</td>';
	                      if($pagado==0)
	                      	echo '<td><a  class="btn btn-sm"  onClick="pagarFactura('.$factura.');"><span class="material-symbols-outlined">payments</span></a> </td>';
	                  	  else
	    					echo '<td>&nbsp;</td>';              			
	                      echo '
	                    </tr>
	                    <tr>
	                    	<td colspan="7" id="detalle'.$factura.'" class="border border-0"></td>
	                    </tr>
	                    </tbody>
	                    </table>
	                    ';


	                }

	              }

/*	              
	          </tbody>
	      </table>
*/
	            ?>            


<?php 
}


if(isset($_POST['pagarFactura'])){
	$factura= $_POST['factura'];
	echo '
	<div class="row ms-3 me-3">
		<div class="col  p-2 "><input type="text" class="form-control" id="fechaFactura'.$factura.'" placeholder="dd/mm/aaaa">		</div>
		<div class="col p-2"><input type="text" class="form-control" id="numFactura'.$factura.'" placeholder="Nro. Transacción">		</div>
	</div>
	<div class="row ms-3 me-3">
		<div class="col p-2"><input type="text" class="form-control" id="montoFactura'.$factura.'" placeholder="Monto Bs.">		</div>
		<div class="col p-2"><input type="text" class="form-control" id="montoDolarFactura'.$factura.'" placeholder="Monto $">		</div>
		<div class="col p-2"><input type="text" class="form-control" id="tasaFactura'.$factura.'" placeholder="Tasa">		</div>
	</div>
	<div class="row ms-3">
		<div class="col text-center">
			<button type="button" class="btn btn-sm text-success" id="boton'.$factura.'" onClick="ejecutarPago('.$factura.');">
			<span class="material-symbols-outlined align-middle text-success">save</span>Pagar</button>
			<button type="button" class="btn btn-sm text-danger" id="cancelar'.$factura.'" onClick="filtrar();"><span class="material-symbols-outlined align-middle text-danger" >block</span>Cancelar</button>		
		</div>
	</div>

	';


}


if(isset($_POST["verFactura"])){
	$factura=$_POST["factura"];

	$sql="SELECT id_cliente, fecha_compra, tipo_pago, pagado from facturacion WHERE id=$factura";              
    if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit; }      
    
    $res = $query -> fetch_array();
        
    $idCliente = $res['id_cliente'];
    $fechaCompra = $res['fecha_compra'];
    $tipoPago = $res['tipo_pago'];
    $pagado= $res['pagado'];

    if($tipoPago==0) $tipo="Crédito";
    elseif($tipoPago==1) $tipo="Contado";

    if($pagado==0) { $status="<span class='text-danger'><span class='material-symbols-outlined'>cancel</span></span>";  $colorPagado="text-danger"; }
	elseif($pagado==1) { $status="<span class='text-success'><span class='material-symbols-outlined'>check</span></span>"; $colorPagado="text-success"; }


    $sql="SELECT cedula, nombre, telefono, direccion from cliente WHERE id = $idCliente";              
	if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit; }
	$res= $query -> fetch_array();
	$cedula=$res['cedula'];
	$nombre=$res['nombre'];
	$telefono=$res['telefono'];
	$direccion=$res['direccion'];

	echo '
	<div class="row">		
		<div class="col fw-bold">CI / RIF: </div>
		<div class="col fw-bold">Cliente: </div>
		<div class="col fw-bold">Teléfono: </div>		
	</div>	
	<div class="row">		
		<div class="col">'.$cedula.'</div>
		<div class="col"> '.$nombre.'</div>
		<div class="col"> '.$telefono.'</div>		
	</div>	
	<div class="row">		
		<div class="col fw-bold">Dirección: </div>
	</div>
	<div class="row">		
		<div class="col">'.$direccion.'</div>
	</div>

	<div class="row">		
		<div class="col fw-bold">Fecha:</div>
		<div class="col fw-bold">Tipo:</div>
		<div class="col fw-bold">Pagado:</div>
	</div>
	<div class="row">		
		<div class="col">'.$fechaCompra.'</div>
		<div class="col">'.$tipo.'</div>
		<div class="col">'.$status.'</div>
	</div>


	<table class="table table-bordered table-sm fs-6  table-hover">
	  <thead>
	    <tr>
	      <th scope="col">Producto</th>      	     
	      <th scope="col">Cant.</th>
	      <th scope="col">Precio</th>
	      <th scope="col">Total</th>
	    </tr>
	  </thead> 
	  <tbody>';




	$sql="SELECT cantidad, precio, cantidad*precio total, nombre from detalles_facturacion d, productos p WHERE id_facturacion = $factura and d.id_productos=p.codigo";              
	if (!$query2 = $mysqli->query($sql)) { die($mysqli->error);  exit; }
	$acum=0;
	while ($res2= $query2 -> fetch_array()){
		$cantidad=$res2["cantidad"];
		$precio=$res2["precio"];
		$nombre=$res2["nombre"];

		$total=$res2['total'];
		$acum+=$total;

		echo "
		<tr>
			<td>$nombre</td>
			<td>$cantidad</td>
			<td>$precio</td>
			<td>$total</td>
		</tr>";		
	}

	echo "</tbody>		</table>

	<div class='row'>		
		<div class='col col-9 fw-bold $colorPagado'>Total Factura</div><div class='col fw-bold $colorPagado'>$".number_format($acum, 2, ',', '.')."</div>
	</div>";

}

if(isset($_POST["ejecutarPago"])){
	$factura=$_POST['factura'];
	$fechaFactura=$_POST['fechaFactura'];
	$fechaFactura = str_replace('/', '-', $fechaFactura);
	$fechaFactura = date("Y-m-d", strtotime($fechaFactura));
	$tasaFactura=$_POST['tasaFactura'];

	$numFactura=$_POST['numFactura'];
	$montoFactura=$_POST['montoFactura'];
	$montoDolarFactura=$_POST['montoDolarFactura'];

	if($fechaFactura=="" or $numFactura=="" or $montoFactura=="" or $tasaFactura=="" or $montoDolarFactura=="") exit("Faltan datos");

	//MONTO TOTAL DE LA VENTA
	$sql="SELECT cantidad*precio total FROM detalles_facturacion WHERE id_facturacion=$factura";
	if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit(2); }
	$totalFactura=0;
	while ($res= $query -> fetch_array()){
		$total=$res['total'];
		$totalFactura+=$total;
	}
	//MONTO ABONADO A LA FACTURA
	$sql="SELECT ifnull(SUM(monto_dolar),0) abonado FROM pago_facturas WHERE id_facturacion=$factura";
	if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit(2); } 
	$res=$query -> fetch_array();
	$abonado=$res["abonado"];

	$totalAbonado=$abonado+$montoDolarFactura;

	$soloDebe=$totalFactura-$abonado;

	if($totalFactura < $totalAbonado) 
		exit("Monto pagado es mayor al monto de la factura, totalAbonado: $totalAbonado y solo debe: $".$soloDebe);
	elseif($totalFactura == $totalAbonado){
		$sql= "UPDATE facturacion SET pagado=1 WHERE id=$factura";
		if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit(2); }
	}

	$sql="INSERT INTO pago_facturas (id_facturacion, num_transferencia, fecha_transferencia, monto_transferencia, monto_dolar, tasa) VALUES($factura, '$numFactura', '$fechaFactura', $montoFactura, $montoDolarFactura, $tasaFactura)";
	if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit(2); }
	
	exit("1");

}



if(isset($_POST["verAbonos"])){
	$factura=$_POST["factura"];

	$sql="SELECT id_cliente, fecha_compra, tipo_pago, pagado from facturacion WHERE id=$factura";              
    if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit; }      
    
    $res = $query -> fetch_array();
        
    $idCliente = $res['id_cliente'];
    $fechaCompra = $res['fecha_compra'];
    $tipoPago = $res['tipo_pago'];
    $pagado= $res['pagado'];

    if($tipoPago==0) $tipo="Crédito";
    elseif($tipoPago==1) $tipo="Contado";

    if($pagado==0) { $status="<span class='text-danger'><span class='material-symbols-outlined'>cancel</span></span>";  $colorPagado="text-danger"; }
	elseif($pagado==1) { $status="<span class='text-success'><span class='material-symbols-outlined'>check</span></span>"; $colorPagado="text-success"; }


    $sql="SELECT cedula, nombre, telefono, direccion from cliente WHERE id = $idCliente";              
	if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit; }
	$res= $query -> fetch_array();
	$cedula=$res['cedula'];
	$nombre=$res['nombre'];
	$telefono=$res['telefono'];
	$direccion=$res['direccion'];

	echo '
	<div class="row">		
		<div class="col fw-bold">CI / RIF: </div>
		<div class="col fw-bold">Cliente: </div>
		<div class="col fw-bold">Teléfono: </div>		
	</div>	
	<div class="row">		
		<div class="col">'.$cedula.'</div>
		<div class="col"> '.$nombre.'</div>
		<div class="col"> '.$telefono.'</div>		
	</div>	
	<div class="row">		
		<div class="col fw-bold">Dirección: </div>
	</div>
	<div class="row">		
		<div class="col">'.$direccion.'</div>
	</div>

	<div class="row">		
		<div class="col fw-bold">Fecha:</div>
		<div class="col fw-bold">Tipo:</div>
		<div class="col fw-bold">Pagado:</div>
	</div>
	<div class="row">		
		<div class="col">'.$fechaCompra.'</div>
		<div class="col">'.$tipo.'</div>
		<div class="col">'.$status.'</div>
	</div>


	<table class="table table-bordered table-sm fs-6  table-hover">
	  <thead>
	    <tr>
	      <th scope="col">Num. Transf</th>      	     
	      <th scope="col">Fecha</th>
	      <th scope="col">Monto Bs.</th>
	      <th scope="col">Monto $</th>
	      <th scope="col">Tasa</th>
	    </tr>
	  </thead> 
	  <tbody>';




	$sql="SELECT num_transferencia, fecha_transferencia, monto_transferencia, monto_dolar, tasa from pago_facturas WHERE id_facturacion = $factura";              
	if (!$query2 = $mysqli->query($sql)) { die($mysqli->error);  exit; }
	$acum=0;
	while ($res2= $query2 -> fetch_array()){
		$numTransf=$res2["num_transferencia"];
		$fechaTransf=$res2["fecha_transferencia"];
		$montoTransf=$res2["monto_transferencia"];
		$montoDolar=$res2["monto_dolar"];
		$tasa=$res2["tasa"];
		
		$acum+=$montoDolar;

		echo "
		<tr>
			<td>$numTransf</td>
			<td>$fechaTransf</td>
			<td>$montoTransf</td>
			<td>$montoDolar</td>
			<td>$tasa</td>
		</tr>";		
	}

	echo "</tbody>		</table>

	<div class='row'>		
		<div class='col col-9 fw-bold $colorPagado'>Total Abonado</div><div class='col fw-bold $colorPagado'>$".number_format($acum, 2, ',', '.')."</div>
	</div>";

}

?>

      


