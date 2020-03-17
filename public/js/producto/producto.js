$(document).ready(function() {
    $("[data-mask]").inputmask();

    // $("#formulario").validate({
    //     rules: {
    //         name: {
    //             required: true,
    //             minlength: 3
    //         },
    //         surname: {
    //             required: true,
    //             minlength: 4
    //         },
    //         edad: "required",
    //         email: {
    //             required: true,
    //             email: true
    //         },
    //         password: {
    //             required: true,
    //             minlength: 8
    //         }
    //     },
    //     messages: {
    //         name: {
    //             required: "Introduzca el name",
    //             minlength: "Debe contener al menos 3 letras"
    //         },
    //         surname: {
    //             required: "Introduzca el surname",
    //             minlength: "Debe contener al menos 4 letras"
    //         },
    //         edad: "La edad es obligatoria",
    //         email: {
    //             required: "El email es obligatorio",
    //             email: "Debe itroducir un email valido"
    //         },
    //         password: {
    //             required: "La contraseña es obligatoria",
    //             minlength: "Debe contener al menos 8 caracteres"
    //         }
    //     }
    // })

    var tabla;

    function init() {
        listar();
        mostrarForm(false);
        $("#btn-edit").hide();
        categorias();
        // ingredientes();
        categoriaingrediente();
    }


    function categorias(){

        $.ajax({
            url: "categoria/producto",
            type: "get",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    var longitud = datos.categoria.length;
                    
                    for (let i = 0; i < longitud; i++) {
                        var fila =  "<option value="+datos.categoria[i].id +">"+datos.categoria[i].nombre+"</option>"
                        
                        $("#categoria").append(fila);
                    }
                    $("#categoria").select2();
            
                 
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
    }

    function categoriaingrediente(){

        $.ajax({
            url: "catIngrediente-select",
            type: "get",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
               

                    let longitud = datos.categoria.length;
                    
                    for (let i = 0; i < longitud; i++) {
                        var fila =  "<option value="+datos.categoria[i].id +">"+datos.categoria[i].nombre+"</option>"
                        
                        $("#ingrediente_cat").append(fila);
                    }
                    $("#ingrediente_cat").select2();
            
                 
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
    }


    function ingredientes(){

        var categoria = {
            categoria: $("#ingrediente_cat").val(),
        };
       

        $.ajax({
            url: "ingrediente-select",
            type: "post",
            dataType: "json",
            data: JSON.stringify(categoria),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    var longitud = datos.ingrediente.length;
                    
                    for (let i = 0; i < longitud; i++) {
                        var fila =  "<option value="+datos.ingrediente[i].id +">"+datos.ingrediente[i].nombre+"</option>"
                        
                        $("#ingrediente").append(fila);
                    }
                    $("#ingrediente").select2();
            
                 
                }
            },
            error: function() {
                console.log("Ocurrio un error");
            }
        });
    }
    $("#ingrediente_cat").change(function(){
        ingredientes();
    });
    

    function limpiar() {
        $("#categoria").val("").trigger("change").select2();
        $("#costo").val("");
        $("#nombre").val("").attr("readonly", false);
        $("#ingrediente").val("").trigger("change").select2();
        $("#id").val("");
        $("#image_name").val("");
      
    }

    $("#btn-guardar").click(function(e) {
      e.preventDefault();
      limpiar();
      tabla.ajax.reload();
      mostrarForm(false);
      Swal.fire("Success!", "Producto creaqdo correctamente!.", "success");  
      
    });

    function guardar(){

        var producto = {
            id: $("#id").val(),
            nombre: $("#nombre").val(),
            categoria: $("#categoria").val(),
            costo: $("#costo").val(),
            imagen:$("#image_name").val()
        };
       
    
        $.ajax({
            url: "producto",
            type: "POST",
            dataType: "json",
            data: JSON.stringify(producto),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
               
                    $("#producto_id").val(datos.producto.id);
                    Swal.fire(
                        "Success",
                        "Producto creado correctamente",
                        "success"
                    );
                    $("#receta-div").show();
                    $("#producto-div").hide();
                    $("#formUpload").hide();
                    $("#btn-guardar").show();
                    $("#button-div").hide();
                    
                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                    );
                }
            },
            error: function(datos) {
                Swal.fire(
                    "Error",
                    "Ya existe un producto con este nombre",
                    "error"
                );
            }
        });
    }

    function guardarReceta(){

        var receta = {
            producto: $("#producto_id").val(),
            id_ingrediente: $("#ingrediente").val()
        };
    
        $.ajax({
            url: "receta",
            type: "POST",
            dataType: "json",
            data: JSON.stringify(receta),
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
                        title: 'Ingrediente agregado correctamente.'
                    })
                    var fila =
                    '<tr id="fila'+datos.receta.id+'">'+
                    "<td class=''><input type='hidden' id='usuario"+datos.receta.id+"' value="+datos.receta.id+">"+datos.receta.producto.nombre+"</td>"+
                    "<td class='font-weight-bold'><input type='hidden' id='permiso"+datos.receta.id+"' value="+datos.receta.id+">"+datos.receta.ingrediente.nombre+"</td>"+
                    "<td><button type='button' id='btn-eliminar' onclick='delIngrediente("+datos.receta.id+")' class='btn btn-danger'><i class='fas fa-minus-square'></i></button></td>"+
                    "</tr>";
                    $("#ingredientes").append(fila);

                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                    );
                }
            },
            error: function(datos) {
                Swal.fire(
                    "Error",
                    "Ya tiene este ingrediente agregado el producto",
                    "error"
                );
            }
        });
    }

    $("#btn-agregar").click(function(){
        guardarReceta();
    }); 

    function listar() {
        tabla = $("#users").DataTable({
            serverSide: true,
            responsive: true,
            ajax: "api/productos",
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
                { data: "nombre", name: "producto.nombre"},
                { data: "categoria", name: "categoriaproducto.nombre"},
                { data: "precio", name: "producto.disponible"},
                { data: "Opciones", orderable: false, searchable: false },
            ],
            order: [[1, "asc"]],
            rowGroup: {
                dataSrc: "categoria"
            }
        });
    }

    $("#btn-edit").click(function(e) {
        e.preventDefault();
        guardar();
    });


    $("#formUpload").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        // console.log( JSON.stringify(formData));
        $.ajax({
            url: "producto-imagen",
            type: "POST",
            data: formData,
            dataType: "JSON",
            processData: false,
            cache: false,
            contentType: false,
            success: function(datos) {
                if (datos.status == "success") {
                    Swal.fire(
                        "Success",
                        "Imagen subida correctamente",
                        "success"
                    );
                    $("#producto_imagen").val("");
                    $("#image_name").val(datos.producto);
                    $("#button-div").show();
                    $("#btn-crear").attr("disabled", false);
                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la creacion de la composicion"
                    );
                }
            },
            error: function(datos) {
                console.log(datos.responseJSON.message);
                let errores = datos.responseJSON.message;

                Object.entries(errores).forEach(([key, val]) => {
                    bootbox.alert({
                        message:
                            "<h4 class='invalid-feedback d-block'>" +
                            val +
                            "</h4>",
                        size: "small"
                    });
                });
            }
        });
    });
    
    $("#btn-upload").click(function() {
    
    });


    $("#btn-crear").click(function() {
      
        guardar();
      
    });

    function mostrarForm(flag) {
        limpiar();
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
            $("#receta-div").hide();
            $("#btn-guardar").hide();
            $("#btn-edit").hide();
            $("#btn-guardar").hide();
            $("#producto-div").show();
            $("#formUpload").show();
            $("#btn-crear").attr("disabled", true);
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
    $.get("producto/mostrar/" + id, function(datos, status) {
        console.log(datos);
        // data = JSON.parse(data);
        $("#listadoUsers").hide();
        $("#registroForm").show();
        $("#btnCancelar").show();
        $("#btn-edit").show();
        $("#btnAgregar").hide();
        $("#btn-guardar").hide();
        $("#ver-contra").show();
        $("#receta-div").show();
        $("#producto-div").hide();
        $("#formUpload").hide();
        $("#btn-guardar").show();
        $("#button-div").hide();
        $("#ingredientes").empty();
        // console.log(data);
        // $("#test").attr("src", '/AlienYard/public/avatar/'+data.user.avatar)
        $("#producto_id").val(datos.receta.id_producto);
        // $("#categoria").val(data.ingrediente.categoria.id).trigger("change").select2();
        // $("#nombre").val(data.ingrediente.nombre).attr("readonly", false);
        // $("#disponible").val(data.inventario.disponible).attr("readonly", false);
        // $("#costo").val(data.inventario.costo).attr("readonly", false);
        // $("#fecha_ingreso").val(data.inventario.fecha_ingreso).attr("readonly", false);

        for (let i = 0; i < datos.receta.length; i++) {

            var fila =
            '<tr id="fila'+datos.receta.id+'">'+
            "<td class=''><input type='hidden' id='usuario"+datos.receta[i].id+"' value="+datos.receta[i].id+">"+datos.receta[i].producto.nombre+"</td>"+
            "<td class='font-weight-bold'><input type='hidden' id='permiso"+datos.receta.id+"' value="+datos.receta.id+">"+datos.receta[i].ingrediente.nombre+"</td>"+
            "<td><button type='button' id='btn-eliminar' onclick='delIngrediente("+datos.receta[i].id+")' class='btn btn-danger'><i class='fas fa-minus-square'></i></button></td>"+
            "</tr>";

            $("#ingredientes").append(fila);
            
        }
    });
}

function ver(id_user) {
    $.post("user/" + id_user, function(data, status) {
        $("#listadoUsers").hide();
        $("#registroForm").show();
        $("#btnCancelar").show();
        $("#btnAgregar").hide();
        $("#btn-guardar").hide();

        $("#nombre")
            .val(data.user.name)
            .attr("readonly", true);
     
    });
}

function eliminar(id) {
    Swal.fire({
        title: "Estas seguro de eliminar este ingrediente?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminarlo!"
    }).then(result => {
        if (result.value) {
            accionEliminar(id);
        }
    });
    // bootbox.confirm("¿Estas seguro de eliminar este usuario?", function(
    //     result
    // ) {
    //     if (result) {
    //         $.post("user/delete/" + id_user, function() {
    //             // bootbox.alert(e);
    //             bootbox.alert("Usuario eliminado correctamente");
    //             $("#users")
    //                 .DataTable()
    //                 .ajax.reload();
    //         });
    //     }
    // });
}

function accionEliminar(id){
 
    $.ajax({
        url: "producto/delete/"+id,
        type: "post",
        dataType: "json",
        // data: JSON.stringify(user),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                Swal.fire("Deleted!", 
                "Producto eliminado correctamente!.", 
                "success");    
                $("#id").val("");

                $("#users").DataTable().ajax.reload();
              
            
            } else {
                bootbox.alert(
                    "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                );
            }
        },
        error: function(datos) {
           console.log(datos.responseJSON);
        }
    });
}


function delIngrediente(id) {
    Swal.fire({
        title: "Estas seguro de eliminar este ingrediente?",
        text: "Lo puede volver agregar si lo borra",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminarlo!"
    }).then(result => {
        if (result.value) {
            
            $.ajax({
                url: "ingrediente/receta/"+id,
                type: "post",
                dataType: "json",
                // data: JSON.stringify(user),
                contentType: "application/json",
                success: function(datos) {
                    if (datos.status == "success") {
                        Swal.fire("Deleted!", 
                        "El ingrediente ha sido eliminado.", 
                        "success");    
                        $("#id").val("");
        
                        $("#fila"+id).remove();
                      
                    
                    } else {
                        bootbox.alert(
                            "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                        );
                    }
                },
                error: function(datos) {
                   console.log(datos.responseJSON);
                }
            });
        }
    });
    // bootbox.confirm("¿Estas seguro de eliminar este usuario?", function(
    //     result
    // ) {
    //     if (result) {
    //         $.post("user/delete/" + id_user, function() {
    //             // bootbox.alert(e);
    //             bootbox.alert("Usuario eliminado correctamente");
    //             $("#users")
    //                 .DataTable()
    //                 .ajax.reload();
    //         });
    //     }
    // });
}