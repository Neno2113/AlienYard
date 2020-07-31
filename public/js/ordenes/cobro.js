$(document).ready(function() {
    $("[data-mask]").inputmask();

    
    var tabla;

    function init() {
        listar();
        mostrarForm(false);
        metodoPago();
        $("#itbis").val(0);
        $("#fila-botones").hide();
        $("#btn-payM").hide();
        
    }


    
    function metodoPago(){
        $.ajax({
            url: "metodo-pago",
            type: "get",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    let longitud = datos.metodo.length;
                    for (let i = 0; i < longitud; i++) {
                        var fila =  "<option value="+datos.metodo[i].id +">"+datos.metodo[i].metodo+"</option>"
                        $("#metodo_pago").append(fila);
                    }
                    $("#metodo_pago").select2();
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
    }

    $("#btn-payT").click(function(e) {
        // validacion(e);
        e.preventDefault();
        guardar();
      
    });

    $("#tipo_factura").change( () => {
        let tipo_factura = $("#tipo_factura").val();

        if(tipo_factura == "B01"){
            $("#btn-comprobante").show();
        }else{
            $("#btn-comprobante").hide();
        }
    });

    function guardar(){
        var categoria = {
            pedido: $("#pedido").val(),
            no_factura: $("#numero_factura").val(),
            tipo_factura: $("#tipo_factura").val(),
            descuento: $("#descuento").val(),
            itbis: $("#itbis").val(),
            total: $("#total").val(),
            efectivo: $("#efectivo").val(),
            rnc: $("#rnc").val(),
            nombre: $("#nombre_cont").val(),
            estado: $("#estado_cont").val()
        };

        $.ajax({
            url: "facturar/total",
            type: "POST",
            dataType: "json",
            data: JSON.stringify(categoria),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    $("#btn-payT").attr('disabled', true);
                    $("#btn-dividir").attr('disabled', true);
                    $("#btn-generar").attr('disabled', true);
                    $("#fila-botones").show();
                    $("#btn-imprimir").attr("href", 'imprimir/factura/'+datos.factura.id);
                    $("#efectivo").attr("disabled", false);
                    numeroFactura();
                    if(datos.cambio){
                        Swal.fire(
                            "Cambio: " + datos.cambio,
                            "Orden procesada",
                            "success"
                        ); 
                        $("#btn-guardar").attr("disabled", false);
                    }else{
                        Swal.fire(
                            "Success",
                            "Orden procesada",
                            "success"
                        );
                    }

                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                    );
                }
            },
            error: function(datos) {
                // console.log(datos);
                let errores = datos.responseJSON.message;

                Object.entries(errores).forEach(([key, val]) => {
                    Swal.fire(
                        "Error",
                        ''+val,
                        "error"
                    );
                });
            }
        });
    }

    function listar() {
        tabla = $("#users").DataTable({
            serverSide: true,
            responsive: true,
            ajax: "api/ordenes",
            dom: "Bfrtip",
            iDisplayLength: 5,
            buttons: [
                "pageLength",
                "copyHtml5",
                {
                    extend: "excelHtml5",
                    autoFilter: true,
                    sheetnombre: "Exported data"
                },
                "csvHtml5",
                {
                    extend: "pdfHtml5",
                    orientation: "landscape",
                    pageSize: "LEGAL"
                }
            ],
            columns: [
                { data: "Opciones", orderable: false, searchable: false },
                { data: "numeroOrden", name: "maestro_pedido.numeroOrden" },
                { data: "estado", name: "estado_pedido.estado" },
                { data: "canal", name: "canal.canal" },
                { data: "delivery", name: "maestro_pedido.delivery" },
               
            
            ],
            order: [[1, "asc"]],
            // rowGroup: {
            //     dataSrc: "role"
            // }
        });
    }

    $("#btn-guardar").click(function(e) {
        e.preventDefault();
   

        var categoria = {
            pedido: $("#pedido").val()
        };

        $.ajax({
            url: "facturar/termino",
            type: "POST",
            dataType: "json",
            data: JSON.stringify(categoria),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    mostrarForm(false);
                    tabla.ajax.reload();
                    Swal.fire(
                        "Success",
                        "Orden facturada correctamente",
                        "success"
                    );

                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                    );
                }
            },
            error: function(datos) {
                // console.log(datos);
                let errores = datos.responseJSON.message;

                Object.entries(errores).forEach(([key, val]) => {
                    Swal.fire(
                        "Error",
                        ''+val,
                        "error"
                    );
                });
            }
        });
    });



    function mostrarForm(flag) {
        reiniciar();
        if (flag) {
            $("#listadoUsers").hide();
            $("#registroForm").show();
            $("#permisoForm").show();
            $("#btnCancelar").show();
            $("#btnAgregar").hide();
        } else {
            $("#listadoUsers").show();
            $("#registroForm").hide();
            $("#permisoForm").hide();
            $("#btnCancelar").hide();
            $("#btnAgregar").show();
            // $("#vatar").hide();
            $("#btn-edit").hide();
            $("#btn-guardar").show();
            $("#btn-comprobante").hide();
        }
    }

    $("#btnAgregar").click(function(e) {
        e.preventDefault();
        mostrarForm(true);
    });
    $("#btnCancelar").click(function(e) {
        e.preventDefault();
        mostrarForm(false);
    });

    init();
});

function mostrar(id) {
    $.get("orden/cobro/" + id, function(data, status) {
        // data = JSON.parse(data);
        $("#listadoUsers").hide();
        $("#registroForm").show();
        $("#btnCancelar").show();
        $("#btn-edit").hide();  
        reiniciar();
        $("#fila-botones").hide();
        $("#btn-payM").hide();
        $("#btn-guardar").attr("disabled", true); 
        $("#btn-generar").attr('disabled', false);
        $("#descuento").inputmask('99%').val(0);
        $("#itbis").inputmask('99%').val(18);
        $("#numero_factura").val("");
        $("#efectivo").attr("disabled", true);
        
      

        $("#pedido").val(data.orden.id);
        $("#numero_orden").val("# "+data.orden.numeroOrden).attr('disabled', true);
        $("#canal").val(data.orden.canal.canal).attr('disabled', true);
        $("#estado").val(data.orden.estado.estado).attr('disabled', true);
        $("#metodo_pago").val(data.orden.metodo_pago.id);
        $("#total").val("RD$ "+data.total).attr('disabled', true);
        $("#tipo_factura").val("IN");
        $("#platos").empty();
        $("#btn-payT").show();
        $("#btn-payT").attr('disabled', false);
        $("#btn-dividir").attr('disabled', false);
        $("#btn-aplicar").attr('disabled', false);

        if(data.factura.length >= 1){
            for (let i = 0; i < data.detalle.length; i++) {
                var platos =     
                '<tr id="fila'+data.detalle[i].id+'">'+
                "<td class='text-center font-weight-bold'>"+data.detalle[i].producto.nombre+"</td>"+
                "<td class='font-weight-bold text-center'>RD$ "+data.detalle[i].costo+"</td>"+
                "<td class='font-weight-bold text-center'><input type='hidden' id='factura"+data.detalle[i].id+"' value="+data.detalle_factura[i].factura+"><button type='button' name='cobro"+data.detalle_factura[i].factura+"' id='cobrar"+data.detalle_factura[i].factura+"' onclick='seleccionarpago("+data.detalle[i].id+")' class='btn btn-dark'><i class='fas fa-cash-register'></i></button></td>"+
                "<td class='text-center'><button type='button' id='agregar"+data.detalle[i].id+"' onclick='agregar("+data.detalle[i].id+")' class='btn btn-primary'><i class='fas fa-cart-plus'></i></button></td>"+
                "</tr>";
    
                $("#platos").append(platos);
              
            }
            $("#btn-dividir").hide();
            $("#btn-dividirM").show();
        }else{
            for (let i = 0; i < data.detalle.length; i++) {
                var platos =     
                '<tr id="fila'+data.detalle[i].id+'">'+
                "<td class='text-center font-weight-bold'>"+data.detalle[i].producto.nombre+"</td>"+
                "<td class='font-weight-bold text-center'>RD$ "+data.detalle[i].costo+"</td>"+
                "<td class='font-weight-bold text-center'><input type='hidden' ><button type='button' id='cobrar' onclick='seleccionarpago("+data.detalle[i].id+")' class='btn btn-dark'><i class='fas fa-cash-register'></i></button></td>"+
                "<td class='text-center'><button type='button' id='agregar"+data.detalle[i].id+"' onclick='agregar("+data.detalle[i].id+")' class='btn btn-primary'><i class='fas fa-cart-plus'></i></button></td>"+
                "</tr>";
    
                $("#platos").append(platos);
                
            }
            numeroFactura();
            $("#btn-dividir").show();
            $("#btn-dividirM").hide();
        }

       

        $("td:nth-child(3) ,th:nth-child(3)").hide();
        $("td:nth-child(4) ,th:nth-child(4)").hide();

        if(data.factura.length >= 1){
            
            $("#numero_factura").attr("disabled", true);
            $("#efectivo").attr("disabled", false);
            $("#btn-aplicar").attr("disabled", true);
            console.log(`Test`);

        }else{
            $("#numero_factura").attr("disabled", false);
            $("#efectivo").attr("disabled", true);
            $("#btn-aplicar").attr("disabled", false);
        }

        // if(data.factura.manual == 1){
        //     $("td:nth-child(3) ,th:nth-child(3)").show();
        //     // $("td:nth-child(4) ,th:nth-child(4)").show();
        //     $("#efectivo").attr("disabled", true);
        //     $("#total").val(0);
        //     $("#factura").val(data.factura.id);
        //     $("#btn-payT").hide();
        //     $("#btn-payM").show();
        // }
       
    });
}

//TODO: Esta funcion debera cambiar mas adelante con la secuencia correcta que se lleva actualmente
function numeroFactura(){
    $("#numero_factura").val("");
   
    $.ajax({
        url: "factura/sec",
        type: "GET",
        dataType: "json",
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                // console.log(typeof datos.sec);
           
                $("#numero_factura").val(datos.sec);
                var cant = $("#numero_factura").val();
                cant = cant.split('_').join("");
                let nume = "00000000";
                var res = nume.concat(cant);
                // console.log(res);
                // console.log(res.length);
                while(res.length > 8){
                   res = res.replace("0", "");
                   
                }
                console.log(res);
                $("#numero_factura").val(res);
            } else {
                bootbox.alert(
                    "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                );
            }
        },
        error: function(datos) {
            // console.log(datos);
            let errores = datos.responseJSON.message;

            Object.entries(errores).forEach(([key, val]) => {
                Swal.fire(
                    "Error",
                    ''+val,
                    "error"
                );
            });
        }
    });
}


function reiniciar() {
    // $("#numero_factura").val("");
    // $("#total").val(0);
    $("#efectivo").val("");
    $("#btn-aplicar").attr("disabled", false);
    $("#btn-payT").attr("disabled", false);

  
}

$("#btn-dividir").click(function(e){
    e.preventDefault();
    $("#btn-payT").hide();
    $("#fila-botones").show();
    $("#btn-payM").show().attr('disabled', true);
    $("#efectivo").attr('disabled', true);
    $("#btn-imprimir").attr('disabled', true);
    // $("td:nth-child(3) ,th:nth-child(3)").show();
    $("td:nth-child(4) ,th:nth-child(4)").show();
    $("#total").val(0);

});

$("#btn-dividirM").click(function(e){
    e.preventDefault();
    $("#btn-payT").hide();
    $("#fila-botones").show();
    $("#btn-payM").show().attr('disabled', true);
    $("#efectivo").attr('disabled', true);
    $("#btn-imprimir").attr('disabled', true);
    $("td:nth-child(3) ,th:nth-child(3)").show();
    // $("td:nth-child(4) ,th:nth-child(4)").show();
    $("#total").val(0);
});


$("#btn-generar").click(function(e){
    e.preventDefault();
    
    var categoria = {
        pedido: $("#pedido").val(),
        no_factura: $("#numero_factura").val(),
        tipo_factura: $("#tipo_factura").val(),
        descuento: $("#descuento").val(),
        itbis: $("#itbis").val(),
        total: $("#total").val(),
        efectivo: $("#efectivo").val()
    };

    $.ajax({
        url: "facturar/manual",
        type: "POST",
        dataType: "json",
        data: JSON.stringify(categoria),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                $("#btn-payT").attr('disabled', true);
                $("#btn-dividir").attr('disabled', true);
                $("#btn-generar").attr('disabled', true);
                $("#fila-botones").show();
                $("#btn-payT").hide();
                // $("#efectivo").attr('disabled', false);
                $("td:nth-child(3) ,th:nth-child(3)").show();
                $("#btn-payM").show().attr('disabled', false);
                $("#factura").val(datos.factura.id);
                $("#total").val("");
                numeroFactura();
                Swal.fire(
                    "Success",
                    "Factura generada correctamente",
                    "success"
                );

            } else {
                bootbox.alert(
                    "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                );
            }
        },
        error: function(datos) {
            // console.log(datos);
            let errores = datos.responseJSON.message;

            Object.entries(errores).forEach(([key, val]) => {
                Swal.fire(
                    "Error",
                    ''+val,
                    "error"
                );
            });
        }
    });
    
})

function agregar(id){
    var categoria = {
        factura: $("#factura").val()
    };

    $.ajax({
        url: "facturar/agregar/"+id,
        type: "POST",
        dataType: "json",
        data: JSON.stringify(categoria),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
               
                $("#agregar"+id).attr('disabled', true);
             
                let val = $("#total").val();
                let total = Number(val) + Number(datos.detalle.costo);
                $("#btn-imprimir").attr("href", 'imprimir/factura/'+datos.detalle.factura);
                $("#total").val(total); 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
        
                Toast.fire({
                    type: 'success',
                    title: 'Plato agregado a la factura correctamente.'
                })

            } else {
                bootbox.alert(
                    "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                );
            }
        },
        error: function(datos) {
            // console.log(datos);
            let errores = datos.responseJSON.message;

            Object.entries(errores).forEach(([key, val]) => {
                Swal.fire(
                    "Error",
                    ''+val,
                    "error"
                );
            });
        }
    });
}


$("#btn-payM").click(function(e) {
    e.preventDefault();
    var categoria = {
        factura: $("#factura").val(),
        descuento: $("#descuento").val(),
        itbis: $("#itbis").val(),
        total: $("#total").val(),
        efectivo: $("#efectivo").val()
    };

    // console.log(JSON.stringify(categoria));
    $.ajax({
        url: "facturar/terminar",
        type: "POST",
        dataType: "json",
        data: JSON.stringify(categoria),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                $("#btn-payM").hide();
                $("#btn-payM").attr("disabled", true);
                $("#btn-payT").show();
                $("#btn-imprimir").attr('disabled', false);
                $("#cobrar"+datos.factura.id).attr("disabled", true);
                $("#btn-guardar").attr("disabled", false);
                
                Swal.fire(
                    "Cambio: "+datos.cambio,
                    "",
                    "success"
                );
          

            } else {
                bootbox.alert(
                    "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                );
            }
        },
        error: function(datos) {
            // console.log(datos);
            let errores = datos.responseJSON.message;

            Object.entries(errores).forEach(([key, val]) => {
                Swal.fire(
                    "Error",
                    ''+val,
                    "error"
                );
            });
        }
    });
  
});

$("#btn-imprimir").click(function(){
    $("#btn-generar").attr('disabled', false);
    reiniciar();
})

$("#btn-aplicar").click(function(e){
    e.preventDefault();


    var aplicar = {
        monto: $("#total").val(),
        itbis: $("#itbis").val(),
        descuento: $("#descuento").val()
       
    };

    $.ajax({
        url: "monto/aplicar",
        type: "POST",
        dataType: "json",
        data: JSON.stringify(aplicar),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                $("#total").val("");
                $("#total").val("RD$ " +datos.total);  
                $("#btn-aplicar").attr("disabled", true);  
            

            } else {
                bootbox.alert(
                    "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                );
            }
        },
        error: function(datos) {
            // console.log(datos);
            let errores = datos.responseJSON.message;

            Object.entries(errores).forEach(([key, val]) => {
                Swal.fire(
                    "Error",
                    ''+val,
                    "error"
                );
            });
        }
    });
})


function seleccionarpago(id){
    var categoria = {
        factura: $("#factura"+id).val()
    };
    // console.log($("#factura"+id).val());

    $.ajax({
        url: "facturar/seleccionar",
        type: "POST",
        dataType: "json",
        data: JSON.stringify(categoria),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                console.log(datos.detalle);
                let total = Number(datos.total);
                $("#efectivo").attr('disabled', false);
                $("#efectivo").val("");
                $("#total").val("RD$ " + total); 
                $("#seleccionar"+id).attr("disabled", true);
                $("#factura").val(datos.factura.id);
                $("#btn-payT").hide();
                $("#btn-payM").show().attr("disabled", false);
                $("#numero_factura").val(datos.factura.no_factura);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
        
                Toast.fire({
                    type: 'success',
                    title: 'Plato seleccionado .'
                })

            } else {
                bootbox.alert(
                    "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                );
            }
        },
        error: function(datos) {
            // console.log(datos);
            let errores = datos.responseJSON.message;

            Object.entries(errores).forEach(([key, val]) => {
                Swal.fire(
                    "Error",
                    ''+val,
                    "error"
                );
            });
        }
    });
}
