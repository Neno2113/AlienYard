var orden;
$(document).ready(function() {
    $("[data-mask]").inputmask();

    function init() {
        ordenes();
   

    }

    function canales(){
        $.ajax({
            url: "canal-orden",
            type: "get",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    let longitud = datos.canal.length;
                    for (let i = 0; i < longitud; i++) {
                        var fila =  "<option value="+datos.canal[i].id +">"+datos.canal[i].canal+"</option>"
                        $("#canal").append(fila);
                    }
                    $("#canal").select2();
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
    }

    function ordenes(){

        $.ajax({
            url: "pedidos",
            type: "get",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    for (let i = 0; i < datos.ordenes.length; i++) {
                       
                        if(datos.ordenes[i].estado_id == 3){
                            let pedidos = "<div id='orden"+datos.ordenes[i].id+"' class='col-md-4 col-sm-6 col-12'>"+
                            "<div id='color"+datos.ordenes[i].id+"' class='info-box bg-warning'>"+
                                "<span class='info-box-icon'><i class='fas fa-hamburger'></i></span>"+
                                "<div class='info-box-content'>"+
                                    "<span class='info-box-number h6'>Orden# "+datos.ordenes[i].numeroOrden+"</span>"+
                                    "<span class='info-box-text h6'><strong>Canal:</strong> "+datos.ordenes[i].canal.canal+"</span>"+
                                    // "<span class='info-box-text'><strong>Delivery:</strong> "+datos.ordenes[i].delivery+"</span>"+
                                    "<div class='progress'>"+
                                    "<div class='progress-bar' style='width: 100%'></div>"+
                                     "</div>"+
                                    "<span class='progress-description'>"+
                                    "<button class='btn btn-secondary btn-block font-weight-bold' id='btnPreparar"+datos.ordenes[i].id+"' onclick='preparar("+datos.ordenes[i].id+")' ><i class='fas fa-store fa-lg'></i> Preparar</button>"+
                                    "<button type='button' id='btnPlatos"+datos.ordenes[i].id+"' class='btn btn-dark btn-block' style='display: none'  data-toggle='modal' data-target='.bd-comentarios-modal-lg' onclick='ver("+datos.ordenes[i].id+")' ><i class='fas fa-utensils'></i> Platos</button>"+    
                                    "<button type='button' id='btnDelete"+datos.ordenes[i].id+"' class='btn btn-danger btn-block mr-1' style='display: none' onclick='ordenDelete("+datos.ordenes[i].id+")'><i class='fas fa-trash-alt'></i> Eliminar</button>"+
                         
                                    "</span>"+
                                "</div>"+
                            "</div>"+
                             "</div>"
                             
                             $("#pedidos").append(pedidos);
                        }else if(datos.ordenes[i].estado_id == 4){

                            let pedidos = "<div id='orden"+datos.ordenes[i].id+"' class='col-md-4 col-sm-6 col-12'>"+
                            "<div id='color"+datos.ordenes[i].id+"' class='info-box bg-info'>"+
                                "<span class='info-box-icon'><i class='fas fa-hamburger'></i></span>"+
                                "<div class='info-box-content'>"+
                                    "<span class='info-box-number h6'>Orden# "+datos.ordenes[i].numeroOrden+"</span>"+
                                    "<span class='info-box-text h6'><strong>Canal:</strong> "+datos.ordenes[i].canal.canal+"</span>"+
                                    // "<span class='info-box-text'><strong>Delivery:</strong> "+datos.ordenes[i].delivery+"</span>"+
                                    "<div class='progress'>"+
                                    "<div class='progress-bar' style='width: 100%'></div>"+
                                     "</div>"+
                                    "<span class='progress-description'>"+
                                    "<button type='button' id='btnPlatos"+datos.ordenes[i].id+"' class='btn btn-dark btn-block'   data-toggle='modal' data-target='.bd-comentarios-modal-lg' onclick='ver("+datos.ordenes[i].id+")' ><i class='fas fa-utensils'></i> Platos</button>"+
                                        "<button type='button' id='btnDelete"+datos.ordenes[i].id+"' class='btn btn-danger btn-block mr-1' onclick='ordenDelete("+datos.ordenes[i].id+")'><i class='fas fa-trash-alt'></i> Eliminar</button>"+
                    
                                    "</span>"+
                                "</div>"+
                            "</div>"+
                             "</div>"
                             
                             $("#pedidos").append(pedidos);
                        }else if(datos.ordenes[i].estado_id == 5){
                            let pedidos = "<div id='orden"+datos.ordenes[i].id+"' class='col-md-4 col-sm-6 col-12'>"+
                            "<div id='color"+datos.ordenes[i].id+"' class='info-box bg-success'>"+
                                "<span class='info-box-icon'><i class='fas fa-hamburger'></i></span>"+
                                "<div class='info-box-content'>"+
                                    "<span class='info-box-number h6'>Orden# "+datos.ordenes[i].numeroOrden+"</span>"+
                                    "<span class='info-box-text h6'><strong>Canal:</strong> "+datos.ordenes[i].canal.canal+"</span>"+
                                    // "<span class='info-box-text'><strong>Delivery:</strong> "+datos.ordenes[i].delivery+"</span>"+
                                    "<div class='progress'>"+
                                    "<div class='progress-bar' style='width: 100%'></div>"+
                                     "</div>"+
                                    "<span class='progress-description'>"+
                                    "<button type='button' id='btnPlatos"+datos.ordenes[i].id+"' class='btn btn-dark btn-block'   data-toggle='modal' data-target='.bd-comentarios-modal-lg' onclick='ver("+datos.ordenes[i].id+")' ><i class='fas fa-utensils'></i> Platos</button>"+
                                        "<button type='button' id='btnDelete"+datos.ordenes[i].id+"' class='btn btn-danger btn-block ' onclick='ordenDelete("+datos.ordenes[i].id+")'><i class='fas fa-trash-alt'></i> Eliminar</button>"+

                                    "</span>"+
                                "</div>"+
                            "</div>"+
                             "</div>"
                             
                             $("#pedidos").append(pedidos);
                        }
                      
                    }
    
              
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
    }




 
  
    function guardar(){

        var orden = {
            metodo: $("#metodo_pago").val(),
            canal: $("#canal").val(),
        };

        $.ajax({
            url: "orden",
            type: "POST",
            dataType: "json",
            data: JSON.stringify(orden),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    $("#orden_id").val(datos.orden.id);

                    mostrarForm(false);
                    $("#pNorden").append(datos.orden.id);
                    $("#pCanal").append(datos.orden.canal.canal);
                    $("#pUser").append(datos.orden.user.name);
                    $("#pMetodo").append(datos.orden.metodo_pago.metodo);
                    $("#cSideBar").show();
                    $("#cSideBar").ControlSidebar('toggle');
                    $("#btnAgregar").hide();
                    $(".btn-agregar").show()

                    Swal.fire(
                        "Success",
                        "Pedido creado correctamente",
                        "success"
                    );
                    
                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                    );
                }
            },
            error: function(datos) {
                Swal.fire(
                    "Error",
                    "Ocurrio un error",
                    "error"
                );
            }
        });
    }

    $("#btn-guardar").click(function(e){
        e.preventDefault();
        guardar();
    })

    $("#btn-save").click(function(e){
        e.preventDefault();
        mostrarForm(false)
        $("#cSideBar").hide();
        $("#cSideBar").ControlSidebar('toggle');
        $("#pedidoProductos").empty();
        $("#pNorden").empty();
        $("#pCanal").empty();
        $("#pUser").empty();
        $("#pMetodo").empty();
        $(".btn-agregar").hide()
        plato = "";
        Swal.fire(
            "Success",
            "Pedido terminado correctamente",
            "success"
        );
    })

    function limpiar() {
        $("#categoria").val("").trigger("change").select2();
        $("#costo").val("");
        $("#nombre").val("").attr("readonly", false);
        $("#ingrediente").val("").trigger("change").select2();
        $("#id").val("");
        $("#image_name").val("");
    }


    function mostrarForm(flag) {
        limpiar();
        if (flag) {
            $("#listadoUsers").hide();
            $("#registroForm").show();
            $("#btnCancelar").show();
            $("#btnAgregar").hide();
            $("#btn-guardar").show();
            $("#btn-edit").hide();
            
           
        } else {
            $("#listadoUsers").show();
            $("#btn-save").hide();
          
            $("#registroForm").hide();
            $("#btnCancelar").hide();
            $("#btnAgregar").show();
            $("#receta-div").hide();
            $("#btn-guardar").show();
            $("#btn-edit").hide();
            $("#btn-guardar").hide();
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

function comentarios(id){
    $.ajax({
        url: "orden/comentarios/"+id,
        type: "get",
        dataType: "json",
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                $("#comment"+id).empty();

                if(datos.comentarioManual){
                    let comentarioManual = 
                    "<li class='list-group-item font-weight-bold' style='font-size: 16px;'>Comentario: "+datos.comentarioManual+"</li>";
    
                    $("#comment"+id).append(comentarioManual);
                }
        

                for (let i = 0; i < datos.comentarios.length; i++) {
                    let comentarios =
                    "<li class='list-group-item' style='font-weight: bolder;font-size: 16px;'><input type='hidden'><i class='far fa-comment'></i> "+datos.comentarios[i].comentario+"</li>";
                    
                        
                    $("#comment"+id).append(comentarios); 
                }
            
            }
        },
        error: function() {
            console.log("Ocurrio un error");
        }
    });
}



function ver(id){
    $.ajax({
        url: "orden/"+id,
        type: "get",
        dataType: "json",
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                console.log(datos);
                $("#accordion").empty();
                orden = id;
 
                for (let i = 0; i < datos.ordenes.length; i++) {
                    if(datos.ordenes[i].comment_us){
                        let acordion = `
                        <div class='card card-dark'>
                        <div class='card-header d-flex justify-content-center'>
                            <h4 class='card-title font-weight-bold'><i class='fas fa-hamburger'></i>
                           
                        <a data-toggle='collapse' data-parent='#accordion' href='#plato${datos.ordenes[i].id}'> ${datos.ordenes[i].producto.nombre}
                  
                        <span style='font-size: 15px;' class='badge badge-primary'>#${datos.ordenes[i].delivery}</span>
                        </a>
                        <i class="fas fa-comment fa-lg chat-bubble"></i>  
                        </h4>
                        </div>
                        <div id='plato${datos.ordenes[i].id}' class='panel-collapse collapse in'>
                            <div class='card-body'>
                            <ul class='list-group' id='comment${datos.ordenes[i].id}'>
                            
                            </ul>
                            </div>
                        </div>
                        </div>
                        `
                        $("#accordion").append(acordion); 
                    }else{
                        let acordion = `
                        <div class='card card-dark'>
                        <div class='card-header d-flex justify-content-center'>
                            <h4 class='card-title font-weight-bold'><i class='fas fa-hamburger'></i>
                           
                        <a data-toggle='collapse' data-parent='#accordion' href='#plato${datos.ordenes[i].id}'> ${datos.ordenes[i].producto.nombre}
                  
                        <span style='font-size: 15px;' class='badge badge-primary'>#${datos.ordenes[i].delivery}</span>
                        </a>
                        </h4>
                        </div>
                        <div id='plato${datos.ordenes[i].id}' class='panel-collapse collapse in'>
                            <div class='card-body'>
                            <ul class='list-group' id='comment${datos.ordenes[i].id}'>
                            
                            </ul>
                            </div>
                        </div>
                        </div>
                        `
                        $("#accordion").append(acordion); 
                    }                    
                }

                for (let i = 0; i < datos.ordenes.length; i++) {
                    $("#comment"+datos.ordenes[i].id).append(comentarios(datos.ordenes[i].id)); 

                }
            
            }
        },
        error: function() {
            console.log("Ocurrio un error");
        }
    });
}


function ordenDelete(id){
    Swal.fire({
        title: "¿Estas seguro de eliminar esta orden?",
        text: "No podra revertir esta accion",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminarlo!"
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: "orden/delete/"+id,
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function(datos) {
                    if (datos.status == "success") {
                        Swal.fire("Deleted!", 
                        "La orden ha sido eliminado.", 
                        "success");    
                    
                        $("#orden"+id).remove();
                    }
                },
                error: function() {
                    console.log("Ocurrio un error");
                }
            });  
          
        }
    });
  
}

$("#btnReady").click(function(e){
    e.preventDefault();
    // $(this).attr("disabled", true);

    Swal.fire({
        title: "¿Esta orden esta lista?",
        text: "Solo debe darle a este boton en caso de que la orden este lista",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, esta lista!"
    }).then(result => {
        if (result.value) {

            let pedido = {
                orden: orden
            };

            $.ajax({
                url: "orden/lista",
                type: "post",
                dataType: "json",
                data: JSON.stringify(pedido),
                contentType: "application/json",
                success: function(datos) {
                    if (datos.status == "success") {
                        Swal.fire("Orden lista!", 
                        "La orden esta lista.", 
                        "success");    
                        $("#color"+datos.orden.id).removeClass("bg-info").addClass("bg-success");
                        $('.bd-comentarios-modal-lg').modal('hide')
                        // $("#btnReady").addClass("lito"+datos.orden.id);
                        // $(".lito"+datos.orden.id).attr('disabled', true);

                        let inventarios = datos.inventario;
                        console.log(inventarios);
                        Object.entries(inventarios).forEach(([key, val]) => {
                            if(val.disponible <= 0 ){
                                val.disponible = 0;
                            }
                            
                            if(val.disponible <= 20){
                              
                                bootbox.alert({
                                    message:'El ingrediente <strong>'+val.ingrediente.nombre +'</strong> se esta agotando actualmente quedan '+val.disponible,
                                });

                             
                            }
                          
                        });
                        
                    }
                },
                error: function() {
                    console.log("Ocurrio un error");
                }
            });  
          
        }
    });
  

});


// function verificarInventario(){

//     $.ajax({
//         url: "verificar/inventario",
//         type: "get",
//         dataType: "json",
//         contentType: "application/json",
//         success: function(datos) {
//             if (datos.status == "success") {
//                 console.log()
                
//             }
//         },
//         error: function() {
//             console.log("Ocurrio un error");
//         }
//     });  
// }

function preparar(id){

    $.ajax({
        url: "orden/preparar/"+id,
        type: "post",
        dataType: "json",
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                Swal.fire("Orden en proceso!", 
                "Ha indicado que va a trabajar esta orden.", 
                "success");  
                $("#btnPreparar"+id).hide();
                $("#btnPlatos"+id).show();
                $("#btnDelete"+id).show();
                $("#color"+id).removeClass("bg-warning").addClass("bg-info")
                
            }
        },
        error: function() {
            console.log("Ocurrio un error");
        }
    });  

}

setInterval(function(){ 
    reload(); 

}, 5000);

function reload(){
    var updated = localStorage.getItem("updated");

    if(updated == "true"){
        localStorage.setItem('updated', 'false');
        location.reload();
    }else{
        
    }
}

 












