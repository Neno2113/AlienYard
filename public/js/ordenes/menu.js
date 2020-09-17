var plato;
var comment;
$(document).ready(function() {
    $("[data-mask]").inputmask();

    function init() {
        categoriaMenu();
        $("#registroForm").hide();
        metodoPago();
        canales();
        numeroOrden();

    }


    function numeroOrden(){
        $("#numeroOrden").val("");
        $.ajax({
            url: "secuencia/orden",
            type: "get",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    var i = Number(datos.sec);
                    $("#numeroOrden").val(i);
                    e = i + 1;

                    $("#pNorden").append(e);
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });    
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

    function menu(id){

        $.ajax({
            url: "menu/categoria/"+id,
            type: "get",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                  
                    for (let i = 0; i < datos.producto.length; i++) {
                        var str = datos.producto[i].precio;
                        var res = str.replace(".00", "");
                       let menu = 
                        "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-4'>"+
                            "<div class='card card-widget widget-user' style='width: 18rem;'>"+
                                "<img src='producto/img/"+datos.producto[i].imagen+"')' class='card-img-top ' alt='...'>"+
                                    "<div class='card-body menu'>"+
                                    // "<h5 class='card-title font-weight-bold'>"+datos.producto[i].nombre+"</h5>"+
                                    // "<p class='card-text'><strong>Precio:</strong> <span class='badge badge-warning'>"+datos.producto[i].precio+"</span></p>"+
                                    "<h2 class='lead'  style='font-weight: bold; color: #fff;' ><b>"+datos.producto[i].nombre+"</b></h2>"+
                                    "<p class='text-muted '><b style='font-size: 15px;' class='text-white'>Precio: </b><span class='badge badge-warning' style='font-size: 15px;'>RD$ "+res+"</span></p>"+
                                "</div>"+
                                "<div class='card-footer'>"+
                                    "<div class='row'>"+
                                        "<div class='col-sm-6 border-right'>"+
                                        "<div class='description-block'>"+
                                            "<h5 class='description-header'>"+
                                            "<button data-toggle='modal' data-target='.bd-example-modal-lg' onclick='ver("+datos.producto[i].id+")'  class=' btn btn-primary'><i class='fas fa-eye'></i></button>"+
                                            "</h5>"+
                                            "<span class='description-text'></span>"+
                                        "</div>"+
                                        "</div>"+
                                        "<div class='col-sm-6'>"+
                                        "<div class='description-block'>"+
                                            "<h5 class='description-header'>"+
                                            "<button style='display: none;' class='ml-1 btn btn-primary btn-agregar' onclick='agregarPedido("+datos.producto[i].id+")'   ><i class='fas fa-plus-circle'></i> Agregar</button>"+
                                            "</h5>"+
                                            // "<span class='description-text'>PRODUCTS</span>"+
                                        "</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "</div>"+

                            "</div>"+
                        "</div>"

                        // let menu = 
                        // "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-4'>"+
                        //     "<div class='card card-widget widget-user'>"+
                        // "<div class='widget-user-header text-white' style='background: url(producto/img/"+datos.producto[i].imagen+") center center;'>"+
                        //     "<h3 class='widget-user-username text-right'>"+datos.producto[i].nombre+"</h3>"+
                        //     "<h5 class='widget-user-desc text-right'>"+datos.producto[i].precio+"</h5>"+
                        //     "</div>"+
                        //     "<div class='card-footer'>"+
                        //     "<div class='row'>"+
                        //         "<div class='col-sm-4 border-right'>"+
                        //         "<div class='description-block'>"+
                        //             "<h5 class='description-header'>3,200</h5>"+
                        //             "<span class='description-text'>SALES</span>"+
                        //         "</div>"+
                        //         "</div>"+
                        //         "<div class='col-sm-4 border-right'>"+
                        //         "<div class='description-block'>"+
                        //             "<h5 class='description-header'>13,000</h5>"+
                        //             "<span class='description-text'>FOLLOWERS</span>"+
                        //         "</div>"+
                        //         "</div>"+
                        //         "<div class='col-sm-4'>"+
                        //         "<div class='description-block'>"+
                        //             "<h5 class='description-header'>35</h5>"+
                        //             "<span class='description-text'>PRODUCTS</span>"+
                        //         "</div>"+
                        //         "</div>"+
                        //     "</div>"+
                        //     "</div>"+
                        // "</div>"+

                        // "</div>"
                       
                    $("#menu"+datos.producto[i].id_categoria).append(menu);
                    }
    
                    // //paginacion
                    // for (let i = 0; i < datos.producto.total; i++) {
                    //     var page = 
                    //     "<li class='page-item'><a class='page-link' href='"+datos.producto.first_page_url+"'>1</a></li>"
                        
                    //     $("#paginas").append(page);
                    // }
                 
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
    }


    function categoriaMenu(){

        $.ajax({
            url: "categoria-menu",
            type: "get",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {

                    for (let i = 0; i < datos.categoria.length; i++) {
                       var varMenu = 
                        "<li class=lnav-item'>"+
                        "<a class='nav-link link-menu border-right text-white' id='pills-"+datos.categoria[i].nombre+"-tab' data-toggle='pill' href='#"+datos.categoria[i].nombre+"' role='tab' aria-controls='home' aria-selected='true'>"+datos.categoria[i].nombre+"</a>"+
                        "</li>"
                        
                        $("#myTab").append(varMenu);

                        
                    }

                    for (let i = 0; i < datos.categoria.length; i++) {
                        var contenido = 
                        "<div class='tab-pane fade' id='"+datos.categoria[i].nombre+"' role='tabpanel' aria-labelledby='"+datos.categoria[i].nombre+"-tab'>"+
                        "<div class='row' id='menu"+datos.categoria[i].id+"'></div>"+
                        "</div>"
                        
                        $("#myTabContent").append(contenido);
                        
                    }

                    for (let i = 0; i < datos.categoria.length; i++) {
                      
                        $("#menu"+datos.categoria[i].id).append(menu(datos.categoria[i].id));
                        
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
            numeroOrden: $("#numeroOrden").val(),
            canal: $("#canal").val(),
            delivery: $("#delivery").val()
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
                    $("#numeroOrden").val(datos.orden.numeroOrden);
                    // $("#pNorden").append(datos.orden.numeroOrden);
                    $("#pCanal").append(datos.orden.canal.canal);
                    $("#pUser").append(datos.orden.user.name);
                    $("#pMetodo").append(datos.orden.metodo_pago.metodo);
                    $("#cSideBar").show();
                    $("#cSideBar").ControlSidebar('toggle');
                    $("#btnAgregar").hide();
                    $(".btn-agregar").show()

                    Swal.fire(
                        "Pedido creado",
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
        numeroOrden();
        plato = "";
        Swal.fire(
            "Success",
            "Pedido terminado correctamente",
            "success"
        );
        localStorage.setItem('updated', 'true');
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



function ver(id){
    $.ajax({
        url: "menu/ver/"+id,
        type: "get",
        dataType: "json",
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                $("#ingredientes").empty();
                $("#detalle").empty(); 
               
                let menu = 
                "<div class='card mb-3' style='max-width: 776px;'>"+
                "<div class='row no-gutters'>"+
                    "<div class='col-md-4'>"+
                    "<img src='producto/img/"+datos.producto.imagen+"')' style='margin-top: 3px; padding:19px;' class='card-img' alt='...'>"+
                    "</div>"+
                    "<div class='col-md-8'>"+
                    "<div class='card-body'>"+
                        "<ul class='list-group text-center'>"+
                        "<li class='list-group-item  bg-danger'>"+datos.producto.nombre+"</li>"+
                        "<li id='detalle'  class='list-group-item'></li>"+
                        
                        "</ul>"+
                        
                    "</div>"+
                    "</div>"+
                "</div>"+
                "</div>"
                $("#ingredientes").append(menu); 


                for (let i = 0; i < datos.receta.length; i++) {
                    let ingredientes ="<li class='list-group'>"+datos.receta[i].ingrediente.nombre+"</li>";
                        

                    $("#detalle").append(ingredientes); 
                }
            
            }
        },
        error: function() {
            console.log("Ocurrio un error");
        }
    });
}


function agregarPedido(id){

    var pedido = {
        pedido: $("#orden_id").val(),
    };

    $.ajax({
        url: "agregar-pedido/"+id,
        type: "post",
        dataType: "json",
        data: JSON.stringify(pedido),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
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
                    title: 'Producto agregado correctamente al pedido.'
                })
                let producto = 
                "<div class='mb-1' id='producto"+datos.detalle.id+"'>"+
                    "<div class='bg-warning disabled color-palette text-center'><span><Strong>"+datos.detalle.producto.nombre+"</Strong></span></div>"+
                    "<div class='bg-warning  color-palette'>"+
                    "<div class='col-md-6'>"+
                        "<input type='text' class='form-control text-center is-warning pl ml-5 mb-1' id='costo"+datos.detalle.id+"' value='"+datos.detalle.producto.precio+"'></input>"+
                    "</div>"+
                    "<div class='btn-group d-flex justify-content-center' role='group' aria-label='Basic example'>"+
                        "<button type='button' onclick='productoReceta("+datos.detalle.id+")' data-toggle='modal' data-target='.bd-comentarios-modal-lg' id='btn-eliminar' class='btn btn-secondary'><i class='fas fa-align-justify'></i></button>"+
                        "<button type='button' id='precio"+datos.detalle.id+"' onclick='updateCosto("+datos.detalle.id+")'  class='btn btn-success'><i class='far fa-check-square'></i></button>"+
                        "<button type='button' onclick='deleteDetalle("+datos.detalle.id+")' class='btn btn-danger'><i class='far fa-minus-square'></i></button>"+
                    "</div>"+
                    "</div>"+
                "</div>"
               
                $("#pedidoProductos").append(producto);
                $("#costo"+datos.detalle.id).inputmask('RD$ 999');
                $("#btn-save").show();
            }
        },
        error: function() {
            console.log("Ocurrio un error");
        }
    });
}


function deleteDetalle(id){
    Swal.fire({
        title: "¿Estas seguro de eliminar este plato del pedido?",
        text: "Lo puede volver agregar si lo borra",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminarlo!"
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: "detalle/delete/"+id,
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function(datos) {
                    if (datos.status == "success") {
                        console.log(datos);
                        Swal.fire("Plato eliminado!", 
                        "El plato ha sido eliminado.", 
                        "success");    
                    
                        $("#producto"+id).remove();
                        $("#id").val("");
    
                    }
                },
                error: function() {
                    console.log("Ocurrio un error");
                }
            });  
          
        }
    });
  
}

function updateCosto(id){

    var costo = {
        costo: $("#costo"+id).val(),
    };

    $.ajax({
        url: "update-costo/"+id,
        type: "post",
        dataType: "json",
        data: JSON.stringify(costo),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
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
                    title: 'Precio ajustado correctamente.'
                })
                $("#precio"+id).attr("disabled", true);
              
            }
        },
        error: function() {
            console.log("Ocurrio un error");
        }
    });
}

function productoReceta(id){

    $.ajax({
        url: "producto-receta/"+id,
        type: "get",
        dataType: "json",
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                plato = id;
                $("#nombre_plato").html(datos.producto.nombre);
                $("#recetaProducto").empty();
                for (let i = 0; i < datos.receta.length; i++) {
                    let receta = 
                    "<div class='custom-control custom-checkbox'>"+
                    "<input class='custom-control-input' onclick='test("+datos.receta[i].id+")'    type='checkbox' name='receta"+datos.receta[i].id+"' id='ingrediente"+datos.receta[i].id+"'"+
                    "value='Plato: No agregar "+datos.receta[i].ingrediente.nombre+" a este plato.'>  <input type='hidden' id='nombre"+datos.receta[i].id+"' value="+datos.receta[i].ingrediente.id+">"+
                    "<label for='ingrediente"+datos.receta[i].id+"' class='custom-control-label'>No ponerle "+datos.receta[i].ingrediente.nombre+" de este plato.</label>"+
                    "</div>"

                    $("#recetaProducto").append(receta);
                    
                }
             

            }
        },
        error: function() {
            console.log("Ocurrio un error");
        }
    });
}

$("#btnComment").click(function(e){
    e.preventDefault();
    var comentario = {
        plato: plato,
        comentario: $("#comentario").val()
    }

    $.ajax({
        url: "comentario-manual",
        type: "post",
        dataType: "json",
        data: JSON.stringify(comentario),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                $("#comentario").val("");
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
                    title: 'Comentario guardado correctamente.'
                })

                $('input[type="checkbox"]').prop('checked', false);
   
            }
        },
        error: function() {
            console.log("Ocurrio un error");
        }
    });
 
   
})

$('input[name="termino"]').click(function(){

    if($(this).prop("checked") == true){
        var comentario = {
            plato: plato,
            termino: $(this).val()
        }
    
        $.ajax({
            url: "comentario",
            type: "post",
            dataType: "json",
            data: JSON.stringify(comentario),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                comment = datos.comentario.id;
            
       
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
   
    }

    else if($(this).prop("checked") == false){
        var comentario = {
            plato: plato,
            termino: $(this).val()
        }
    
        $.ajax({
            url: "delete-comment",
            type: "post",
            dataType: "json",
            data: JSON.stringify(comentario),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                comment = "";
            
       
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });


    }

});

$("input[name='entrega']").click(function(){
    if($(this).prop("checked") == true){
        var entrega = {
            plato: plato,
            entrega: $(this).val()
        }
      
        $.ajax({
            url: "entrega/plato",
            type: "post",
            dataType: "json",
            data: JSON.stringify(entrega),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                comment = datos.comentario.id;
            
       
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
    }else if($(this).prop("checked") == false){
        console.log("Hi...");
        // var entrega = {
        //     plato: plato,
        //     entrega: $(this).val()
        // }
      
        // $.ajax({
        //     url: "entrega/plato/delete",
        //     type: "post",
        //     dataType: "json",
        //     data: JSON.stringify(entrega),
        //     contentType: "application/json",
        //     success: function(datos) {
        //         if (datos.status == "success") {
        //         comment = "";
            
       
        //         }
        //     },
        //     error: function() {
        //         console.log("Ocurrio un error");
        //     }
        // });
    }
})

function test(id){
    
    if($("input[name='receta"+id+"']").prop("checked") == true){
        console.log($("#ingrediente"+id).val());
        var comentario = {
            plato: plato,
            termino: $("#ingrediente"+id).val(),
            ingrediente: $("#nombre"+id).val()
        }
      
        $.ajax({
            url: "comentario",
            type: "post",
            dataType: "json",
            data: JSON.stringify(comentario),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                comment = datos.comentario.id;
            
       
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
      
      
    }else if($("input[name='receta"+id+"']").prop("checked") == false){
        var comentario = {
            plato: plato,
            termino: $("#ingrediente"+id).val(),
            ingrediente: $("#nombre"+id).val()
        }
    
        $.ajax({
            url: "delete-comment",
            type: "post",
            dataType: "json",
            data: JSON.stringify(comentario),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                comment = "";
            
       
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
    }
}

$("#canal").on('change', function(){
    var deliverDefault = $("#canal").val();
    if(deliverDefault == 3){
        $("#delivery").val("Delivery");
    }
});







