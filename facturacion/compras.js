
$(document).ready(function(){  funcPrincipal(); });

function funcPrincipal(){

  $('#guardarCliente').on("click", function() {  guardar();  });
  $('#vender').on("click", function() {  vender();  });  
  $('#btnNuevoProducto').on("click", function() { agregarProducto(); });  

  $(document).on('click', '.btnElimina', function(event) {
    
    $(this).closest('tr').remove();
  });


  //  AUTOCOMPLETADO NOMBRE
  $('#proveedor').on( "input", function() {     

    $('#proveedor').typeahead({
      source: function (query, process) {
        var nombre = $('#proveedor').val();
        return $.get('search_proveedor.php', { query: nombre }, function (data) {
          data = $.parseJSON(data);
          return process(data);
        });
      }
    });
  });


  //*************
  const myModal = document.getElementById('myModal');
  const myInput = document.getElementById('myInput');

/*
  myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus();
  });
  */
}


function funcEliminarFila(){  
  console.log ($(this).parent().parent());

}


function guardar(){
  var rif=$('#rif').val();
  var nombre=$('#nombre').val();
  var telefono=$('#telefono').val();
  var direccion=$('#direccion').val();
  var email=$('#email').val();
  var instagram=$('#instagram').val();
  var tipoCliente=$('#tipoCliente').val();

  $.ajax({
    type: 'POST',
    url: 'ajaxCompras.php',
    data: {guardarProveedor: 1, rif:rif, nombre: nombre, telefono:telefono, direccion:direccion, tipoCliente:tipoCliente, email:email, instagram: instagram},
    success:   
        function(msj) { 
          if(msj == 1){
            $('#msj').html('<div class="alert alert-danger" role="alert">Proveedor ya existe en el sistema</div>');                    
          }else if (msj==0){
            $('#msj').html('<div class="alert alert-success" role="alert">Proveedor agregado</div>');          
          }else{
            $('#msj').html('<div class="alert alert-warning" role="alert">Problemas al crear proveedor</div>');  
          }
        }
      });  
}



function vender(){
  var fechaCompra=$('#fechaCompra').val();
  var nombre=$('#nombreCliente').val();
  var cantTequenoton=$('#canttequenoton').val();  
  var cantArepafit=$('#cantarepafit').val();
  var cantPataconPowerAmarillo=$('#cantpataconPowerAmarillo').val();
  var cantFullPataconAmarillo=$('#cantfullPataconAmarillo').val();
  var cantMinitoston=$('#cantminitoston').val();
  var cantCoquitos=$('#cantcoquitos').val();
  var cantPataconPowerVerde=$('#cantpataconPowerVerde').val();  
  var cantFullPataconVerde=$('#cantfullPataconVerde').val();
 
  var idVendedor=$('#idVendedor').val();
  var tipoVenta=$('#tipoVenta').val();
  var tipoPrecio=$('input:radio[name=precio]:checked').val();  
  $.ajax({
    type: 'POST',
    url: 'ajaxVenta.php',
    data: { 
            vender: 1,
            fechaCompra:fechaCompra, 
            nombre: nombre, 
            cantTequenoton:cantTequenoton, 
            cantArepafit:cantArepafit, 
            cantPataconPowerAmarillo:cantPataconPowerAmarillo, 
            cantFullPataconAmarillo:cantFullPataconAmarillo, 
            cantMinitoston:cantMinitoston, 
            cantCoquitos:cantCoquitos,
            cantPataconPowerVerde:cantPataconPowerVerde,
            cantFullPataconVerde:cantFullPataconVerde,
            tipoVenta: tipoVenta,
            idVendedor: idVendedor,
            tipoPrecio: tipoPrecio
          },
    success:   
        function(msj) {
       
        //alert(msj);      
          if(msj == 0){
            $('#msjVenta').html('<div class="alert alert-danger" role="alert">Cliente NO existe, debe registrarlo primero</div>');                    
          }else if(msj == 1){
            $('#msjVenta').html('<div class="alert alert-danger" role="alert">Fecha no puede quedar en blanco</div>');                    
          }else if(msj == 2){
            $('#msjVenta').html('<div class="alert alert-danger" role="alert">No ha seleccionado ningún producto</div>');                    
          }else if(msj == 3){
            $('#msjVenta').html('<div class="alert alert-danger" role="alert">Seleccione Tipo de venta</div>');                    
          }else if(msj == 4){
            $('#msjVenta').html('<div class="alert alert-success" role="alert">Todo bien</div>');        
            setTimeout("location.href='index.php'", 1000);                
          }
        }
      });  
}



function precioProducto(nivel){   
  $.ajax({
    type: 'POST',
    url: 'listaPrecios.php',
    data: {nivel: nivel},
    success:   
      function(msj) {         
        $('#respuesta').html(msj);
      }        
  });  
}

function agregarProducto(){
  var tipoInsumo=$('#tipoInsumo').val();
  $.ajax({
    type: 'POST',
    url: 'ajaxCompras.php',
    data: {agregarProducto: 1, tipoInsumo: tipoInsumo},
    success:   
      function(msj) {            
        $('#tablaProductos').append(msj);
        $(".form-chose").chosen({no_results_text: "No se encuentra "});  
      }        
  });  

}
