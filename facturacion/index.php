<?php   include 'conexion.php'; ?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facturación</title>
    <link rel="icon" type="image/png" sizes="16x16"  href="/favicons/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel ="stylesheet" href ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <!-- Include JavaScript files  -->
    <!-- Jquery -->    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>    
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>  

    <!-- <script src ="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>  -->
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" /> 
    <script src="/js/datepicker-es.js"></script>
    <script src="/js/readonly.js"></script> 

    <script src="facturacion.js?v1.0"></script>

  </head>
  <body>
   <?php include 'menuNav.php'; ?> 

  
    <h2>Facturar</h2>

  <div class="container">

<form name="formulario" id="formulario">

<div>
  <div class="input-group input-group-sm mb-1"> 
  <span class="input-group-text" id="inputNombre">Fecha de compra</span>
  <input type="text" class="form-control" id="fechaCompra" name="fechaCompra"  aria-describedby="inputNombre" autocomplete="off" readonly>     
</div>
  
<div class="mb-3">
  <div class="input-group input-group-sm mb-3">
  <span class="input-group-text" id="inputNombre">Nombre del Cliente</span>
  <input type="text" class="typeahead form-control" id="nombreCliente"   placeholder="Indique el nombre...." autocomplete="off">
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <span class="material-symbols-outlined">add_circle</span>  
  </button>  
</div>
 
<div class="border p-3 mb-3">
  <select class="form-select" id="idVendedor">   
    <option value="0">Vendedor (opcional)</option>
    <?php
      $sql="SELECT id, nombre from vendedor ORDER BY nombre";              
      if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit; }
      if($query -> num_rows > 0){
        while ($res=$query->fetch_array()){
          $idVendedor=$res['id'];
          $nombreVendedor=$res['nombre'];
          echo "<option value='$idVendedor'>$nombreVendedor</option>";

        }
      }
    ?>    
  </select>   
</div>

<div class="row">
  <div class="col border p-2 text-center">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="precio" id="precioFinal" value="3">
      <label class="form-check-label" for="precioFinal">
        Precio Final
      </label>
    </div>
  </div>
  <div class="col border p-2 text-center">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="precio" id="precioMinorista" value="2">
      <label class="form-check-label" for="precioMinorista">
        Precio Minorista
      </label>
    </div>
  </div>
  <div class="col border p-2 text-center">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="precio" id="precioVendedor" value="1">
      <label class="form-check-label" for="precioVendedor">
        Precio Vendedor
      </label>
    </div>
  </div>
</div>

<div id="respuesta"></div>
<div class="row">  
    <div class="col-5">   </div>
    <div class="col-2">     </div> 
    <div class="col h2 text-success border align-text-bottom p-2 "><span class="align-text-bottom">Total</span></div> 
    <div class="col h2 text-success border align-middle"><input type="text" readonly class="form-control-plaintext text-success" id="totalVenta" value="0"></div>
  </div>


<div class="input-group input-group-sm mt-1">
  <span class="input-group-text" id="inputVenta">Tipo de Venta:</span>
  <select class="form-select" id="tipoVenta"> 
    <option value="-1">Seleccione...</option>
    <option value="0">Venta a Crédito</option>
    <option value="1">Venta de Contado</option>
    
  </select>
</div> 


<div class="row mt-3 d-grid gap-1 ms-2 me-2">    
    <button type="button" class="btn btn-success" id="vender">Vender</button> 
</div>


<div class="mt-3" id="msjVenta">        </div>

</div>
</form>
</div>
  


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
 
        <div class="row mb-3">                    
          <div class="col-3">
            <select class="form-select" id="tipoCliente" >   
              <option value="V">V</option>
              <option value="J">J</option>    
            </select>   
          </div>
          <div class="col">
            <input type="text" class="form-control" id="cedulaCliente" width="3" placeholder="Cédula o Rif" autocomplete="off" >  
          </div>
        </div>      

        <div class="mb-3">         
          <input type="text" class="form-control" id="nombreCliente2" aria-describedby="inputNombre" placeholder="Nombre Cliente"  autocomplete="off">  
        </div>      
        <div class="mb-3">          
          <input type="text" class="form-control" id="telefonoCliente"  aria-describedby="inputTelefono" placeholder=" Teléfono (Opcional)"  autocomplete="off">         
        </div>
        <div class="mb-3">
          <input type="text" class="form-control" id="direccionCliente"  aria-describedby="inputDireccion" placeholder=" Dirección (Opcional)" autocomplete="off">  
        </div>
        <div class="mb-3" id="msj">        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarCliente">Guardar</button>
      </div>
    </div>
  </div>
</div>

  
 




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
        $(function () {
          $( "#fechaCompra" ).datepicker({  altField: "#actualDate" });
          $.datepicker.setDefaults($.datepicker.regional["es"]);
          
          $("#fechaCompra").datepicker({ firstDay:1 });          
        });
  </script>

  </body>


</script>
</html>