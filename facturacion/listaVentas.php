<?php
  include 'conexion.php';
  $hoy=date('d/m/Y'); 
?>
 <!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Ventas</title>
    <link rel="icon" type="image/png" sizes="16x16"  href="/favicons/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel ="stylesheet" href ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <!-- Include JavaScript files  -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>    
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> 
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>   

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" /> 

      <script src="/js/datepicker-es.js"></script>
      <script src="/js/readonly.js"></script>

    <script src="listadoVentas.js"></script>

  </head>
  <body>
  	<?php include 'menuNav.php'; ?>
    <h2>Listado de Ventas</h2>

      <div class="row">
        <div class="col-sm-12 col-lg-3 mb-1">           
          <select class="form-select" id="estatusVenta">            
            <option value="0">Pendientes</option>
            <option value="1">Pagadas</option>
            <option value="2" selected>Todas</option>
          </select> 
        </div>
        <div class="col-6 col-sm-6 col-lg-3 col-md-3 mb-1">                       
          <input type="text" class="form-control" id="fechaInicio"  aria-describedby="descFinicio" placeholder="Fecha Inicio" value="<?php echo $hoy; ?>" readonly>     
        </div>
        <div class="col-6  col-sm-6 col-lg-3 col-md-3 mb-1">                       
            <input type="text" class="form-control" id="fechaFin"     aria-describedby="descFfin" placeholder="Fecha Fin" value="<?php echo $hoy; ?>" readonly>     
        </div>  
        <div class=" d-grid gap-2 d-md-block mb-1 col-lg-3 col-sm-12 col-md-3">        
          <button type="button" class="btn btn-success btn-sm" id="filtrar" onclick="filtrar();"><span class='material-symbols-outlined'>search</span></button> 
        </div>
      </div>
     

      

      <div id="resultados">      </div>    

  	   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


       <script>
        $(function () {
          $( "#fechaInicio" ).datepicker({  altField: "#actualDate" });
          $.datepicker.setDefaults($.datepicker.regional["es"]);          
          $("#fechaInicio").datepicker({ firstDay:1 });          

          $( "#fechaFin" ).datepicker({  altField: "#actualDate" });
          $.datepicker.setDefaults($.datepicker.regional["es"]);          
          $("#fechaFin").datepicker({ firstDay:1 });   

           



        });
  </script>
  </body>
  </html>