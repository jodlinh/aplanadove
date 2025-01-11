 <?php
 include 'conexion.php'; 
 $nivel=$_POST["nivel"];

/* NIVEL
1 precio vendedor
2 precio minorista
3 precio final
*/

if($nivel==1){
  $precio="precio1";
}elseif ($nivel==2) {
  $precio="precio2";
}elseif($nivel==3){
  $precio="precio_venta";
}

?>
 
  <div class="row ">
    <div class="col-5 fw-bold">Producto</div>
    <div class="col-2 fw-bold">Precio</div>
    <div class="col fw-bold">Cantidad</div>
    <div class="col fw-bold">Total</div>
  </div>
  

<?php 
  $sql="SELECT codigo, nombre, $precio precio, nombreSistema FROM productos ORDER BY codigo";
  if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit; }
  $tabindex=0;
  while ($res=$query ->fetch_array()) {
    $codigo=$res['codigo'];
    $nombre=$res['nombre'];
    $precio=$res['precio'];
    $nombreSistema=$res['nombreSistema'];

    $tabindex++;

    echo'
  <div class="row border ">
    <div class="col-5">    <input type="text" readonly class="form-control-plaintext" id="'.$nombreSistema.'" value="'.$nombre.'" ></div>  
    <div class="col">      <input type="number" name="precioUnitario'.$nombreSistema.'" id="precioUnitario'.$nombreSistema.'" class="form-control form-control-sm border border-0 " readonly value='.$precio.' >    </div> 
    <div class="col">      <input type="number" name="cant'.$nombreSistema.'" id="cant'.$nombreSistema.'" class="form-control form-control-sm" min="0" tabindex="'.$tabindex.'">    </div>
    <div class="col">      <input type="text" readonly class="form-control-plaintext" id="precio'.$nombreSistema.'" value="0" ></div>
  </div>';    
  }
?>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>    
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>  
<script>  
$( document ).ready(function() {
  $('#canttequenoton').on("input", function() {            buscarPrecio("1");  });
  $('#cantarepafit').on("input", function() {              buscarPrecio("2");  });
  $('#cantpataconPowerAmarillo').on("input", function() {  buscarPrecio("3");  });
  $('#cantfullPataconAmarillo').on("input", function() {   buscarPrecio("4");  });
  $('#cantminitoston').on("input", function() {            buscarPrecio("5");  });
  $('#cantcoquitos').on("input", function() {            buscarPrecio("6");  });
  $('#cantpataconPowerVerde').on("input", function() { buscarPrecio("7");  });
  $('#cantfullPataconVerde').on("input", function() { buscarPrecio("8");  });
});

function buscarPrecio(producto){   
  tipoPrecio=$('input:radio[name=precio]:checked').val();

  $.ajax({
    type: 'POST',
    url: 'ajaxPrecios.php',
    data: {idProducto: producto, tipoPrecio: tipoPrecio},
    success:   
      function(precio) { 
        if(producto == 1){
          cantidad = $('#canttequenoton').val();
          total1= cantidad*precio;
          total1= total1.toFixed(2);
          $('#preciotequenoton').val(total1);                    
        }

        if(producto == 2){
          cantidad = $('#cantarepafit').val();
          total2= cantidad*precio;
          total2= total2.toFixed(2);
          $('#precioarepafit').val(total2);                    
        }    
        if(producto == 3){
          cantidad = $('#cantpataconPowerAmarillo').val();
          total3= cantidad*precio;
          total3= total3.toFixed(2);
          $('#preciopataconPowerAmarillo').val(total3);                    
        } 
        if(producto == 4){
          cantidad = $('#cantfullPataconAmarillo').val();
          total4= cantidad*precio;
          total4= total4.toFixed(2);
          $('#preciofullPataconAmarillo').val(total4);                    
        } 
        if(producto == 5){
          cantidad = $('#cantminitoston').val();
          total5= cantidad*precio;
          total5= total5.toFixed(2);
          $('#preciominitoston').val(total5);                    
        } 
        if(producto == 6){
          cantidad = $('#cantcoquitos').val();
          total6= cantidad*precio;
          total6= total6.toFixed(2);
          $('#preciocoquitos').val(total6);                    
        } 
        if(producto == 7){
          cantidad = $('#cantpataconPowerVerde').val();
          total7= cantidad*precio;
          total7= total7.toFixed(2);
          $('#preciopataconPowerVerde').val(total7);                    
        } 
        if(producto == 8){
          cantidad = $('#cantfullPataconVerde').val();
          total8= cantidad*precio;
          total8= total8.toFixed(2);
          $('#preciofullPataconVerde').val(total8);                    
        } 

        total= parseFloat($('#preciotequenoton').val()) + parseFloat($('#precioarepafit').val())+ parseFloat($('#preciopataconPowerAmarillo').val())+ parseFloat($('#preciofullPataconAmarillo').val())+ parseFloat($('#preciominitoston').val())+ parseFloat($('#preciocoquitos').val())+ parseFloat($('#preciopataconPowerVerde').val())+ parseFloat($('#preciofullPataconVerde').val());

        total= total.toFixed(2);
        $('#totalVenta').val(total);


      }        
  });  
}

</script>
