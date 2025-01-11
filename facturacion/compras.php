<?php   include 'conexion.php'; ?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compras</title>

    <link rel="icon" type="image/png" sizes="16x16"  href="/favicons/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!--BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel ="stylesheet" href ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <!-- Include JavaScript files  -->
    <!-- Jquery -->    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>    
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>  

    
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" /> 
    <script src="/js/datepicker-es.js"></script>
    <script src="/js/readonly.js"></script> 

    <script src="/chosen/chosen.jquery.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/chosen/chosen.css" />

    <script src="compras.js?v1"></script>

  </head>
  <body>
   <?php include 'menuNav.php'; ?> 

  
    
<div class="container mt-3">
  <div class="row rounded-top">
    <h4 class="bg-success text-white p-2 rounded-top mb-0">Compras</h4>
  </div>
  <div class="row border rounded-bottom" > 
    <form name="formulario" id="formulario">
      <div class="form-floating m-2">        
        <input type="text" class="form-control" id="fechaCompra" name="fechaCompra"  aria-describedby="inputNombre" autocomplete="off" readonly placeholder="Fecha de Compra">     
        <label for="fechaCompra"> Fecha de compra</label>
      </div>
      <div class="form-floating m-2">        
        <input type="text" class="form-control" id="numFactura" name="numFactura"  aria-describedby="inputNombre" autocomplete="off" placeholder="Num. Factura">     
        <label for="numFactura">Nro. Factura</label>
      </div>        
      <div class="m-2">
        <div class="input-group input-group-sm">        
          <div class="form-floating"> 
            <input type="text" class="typeahead form-control" id="proveedor"   placeholder="Proveedor" autocomplete="off">
            <label for="proveedor">Proveedor</label>
          </div>
          <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal">
            <span class="material-symbols-outlined">add_circle</span>  
          </button>  
        </div> 
      </div>

      <div class="row mt-5 pb-2 border-bottom ">
        <div class="col-lg-12">
        Productos 
        </div>
        <div class="col-10 col-md-4">
          <select class="form-select" id="tipoInsumo">           
            <?php 
              $sql="SELECT id, nombre FROM tipo_insumo ORDER BY nombre ";
              if (!$query = $mysqli->query($sql)) { die($mysqli->error);  exit; }                      
              while ($res=$query ->fetch_array()) {
                $codigo=$res['id'];
                $nombre=$res['nombre'];                      
                echo '<option value="'.$codigo.'" >'.$nombre.'</option>';
              }    
            ?>    
          </select>     
        </div>
        <div class="col">
          <button type="button" class="btn  btn-sm" value="Agregar" id="btnNuevoProducto"> <span class="material-symbols-outlined text-primary">add_circle</span></button>
        </div>
      </div>
            
      <div class="container mt-3">
        <table class="table  table-hover " >
          <tbody id="tablaProductos">
        
          </tbody>
      </table>
    </div>
       


      <div id="respuesta"></div>
      <div class="row text-center">            
          <div class="col text-success"><span class="align-text-bottom">Total Bs.</span></div> 
          <div class="col text-success"><span class="align-text-bottom">Total USD</span></div> 
      </div>
      <div class="row text-center">           
          <div class="col text-success" id="totalBS">0</div>          
          <div class="col text-success" id="totalUSD">0</div>
      </div>


      <div class="row mt-3 d-grid gap-1 ms-2 me-2">    
          <button type="button" class="btn btn-primary" id="vender">Guardar</button> 
      </div>


      <div class="mt-3" id="msjVenta">        </div>

      </div>
    </form>
  </div>
</div>
  


<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Proveedor</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
     
            <div class="row mb-3">                    
              <div class="col-3">
                <select class="form-select" id="tipoCliente" >               
                  <option value="J">J</option>    
                </select>   
              </div>
              <div class="col">
                <input type="text" class="form-control" id="rif" width="3" placeholder="RIF" autocomplete="off" >  
              </div>
            </div>      

            <div class="mb-3">         
              <input type="text" class="form-control" id="nombre" aria-describedby="inputNombre" placeholder="Razón Social"  autocomplete="off">  
            </div>      
            <div class="mb-3">          
              <input type="text" class="form-control" id="telefono"  aria-describedby="inputTelefono" placeholder=" Teléfono (Opcional)"  autocomplete="off">         
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" id="direccion"  aria-describedby="inputDireccion" placeholder=" Dirección (Opcional)" autocomplete="off">  
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" id="email"  aria-describedby="inputEmail" placeholder=" Email (Opcional)" autocomplete="off">  
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" id="instagram"  aria-describedby="inputInstagram" placeholder=" Instagram (Opcional)" autocomplete="off">  
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