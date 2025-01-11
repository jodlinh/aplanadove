
$( document ).ready(function() {
  
  $(window).on("load", function(){     $('#filtrar').click(); });
  $('#pagarFactura').on("click", function(){  pagarFactura();  });

})

function guardarNumTransf(){
  alert("guardado");
}


function filtrar() {
  estatusVenta = $('#estatusVenta').val();
  fechaInicio= $('#fechaInicio').val();
  fechaFin= $('#fechaFin').val();

  $.ajax({
    type: 'POST',
    url: 'ajaxListadoVentas.php',
    data: { filtrar:1, estatusVenta:estatusVenta, fechaInicio: fechaInicio, fechaFin:fechaFin},
    success:   
        function(msj) {          
          $('#resultados').html(msj);
          
        }
      });  


}

function pagarFactura(factura){

  espacio= '#detalle'+factura;
  $.ajax({
    type: 'POST',
    url: 'ajaxListadoVentas.php',
    data: {pagarFactura: 1, factura: factura },
    success:  
      function(msj) { 
        $(espacio).html(msj);
      }
  });
  return false;  

}

function  ejecutarPago(factura){

  fechaFactura = $('#fechaFactura'+factura).val();
  numFactura =$('#numFactura'+factura).val();
  montoFactura =$('#montoFactura'+factura).val();
  montoDolarFactura=$('#montoDolarFactura'+factura).val();
  tasaFactura =$('#tasaFactura'+factura).val();


  $.ajax({
      type: 'POST',
      url: 'ajaxListadoVentas.php',
      data: {ejecutarPago: 1, factura: factura, fechaFactura:fechaFactura, numFactura: numFactura, montoFactura:montoFactura, montoDolarFactura:montoDolarFactura, tasaFactura:tasaFactura},
      success:       
        function(msj) {                       
          if(msj==1){
            Swal.fire({
              title: "Factura Pagada!",
              text: "Se ha pagado exitósamente la factura.",
              icon: "success"
            });
            filtrar();
          }else{
            Swal.fire({
              title: "Error al guardar",
              text: msj,
              icon: "error" 
            });
          }
        }
    }); 
}





function verFactura(factura){
  $.ajax({
    type: 'POST',
    url: 'ajaxListadoVentas.php',
    data: {verFactura: 1, factura: factura },
    success:  
      function(msj) {        
        Swal.fire({                 
          title: 'Factura No. '+factura,
          html: msj,         
          showCloseButton: true

          //showCancelButton: true,          
          //cancelButtonText: "Cancelar",
          //confirmButtonText: "Pagar Factura!",
          //reverseButtons: true,
          //confirmButtonColor: "#3085d6",
          //cancelButtonColor: "#d33"

        });
        /*
        .then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: 'POST',
              url: 'ajaxListadoVentas.php',
              data: {ejecutarPago: 1, factura: factura},
              success:  
                function(msj) {                    
                  if(msj==1){
                    Swal.fire({
                      title: "Factura Pagada!",
                      text: "Se ha pagado exitósamente la factura.",
                      icon: "success"
                    });
                    filtrar();
                  }
                }
            });                        
          }
        });
        */
      }
  });
  return false;  
}



function verAbonos(factura){
  $.ajax({
    type: 'POST',
    url: 'ajaxListadoVentas.php',
    data: {verAbonos: 1, factura: factura },
    success:  
      function(msj) {        
        Swal.fire({                 
          title: 'Factura No. '+factura,
          html: msj,         
          showCloseButton: true
        });        
      }
  });
  return false;  
}