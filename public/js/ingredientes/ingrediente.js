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
    }


    function categorias(){

        $.ajax({
            url: "categoria/select",
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

    function limpiar() {
        $("#nombre").val("").attr("readonly", false);
        $("#fecha_ingreso").val("");
        $("#disponible").val("");
        $("#categoria").val("").trigger("change").select2();
        $("#costo").val("");
        $("#id").val("");
    }

    $("#btn-guardar").click(function(e) {
        // validacion(e);
        e.preventDefault();
        guardar();
      
    });

    function guardar(){
        var ingrediente = {
            id: $("#id").val(),
            categoria: $("#categoria").val(),
            nombre: $("#nombre").val(),
            disponible: $("#disponible").val(),
            nota: $("#nota").val(),
            costo: $("#costo").val(),
            fechaIngreso: $("#fecha_ingreso").val()
        };
        console.log(JSON.stringify(ingrediente));
    
        $.ajax({
            url: "ingrediente",
            type: "POST",
            dataType: "json",
            data: JSON.stringify(ingrediente),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    Swal.fire(
                        "Success",
                        datos.message,
                        "success"
                    );
                    limpiar();
                    tabla.ajax.reload();
                    mostrarForm(false);
                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                    );
                }
            },
            error: function(datos) {
                console.log(datos.responseJSON.errors);
                let errores = datos.responseJSON.errors;

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
    }

    function listar() {
        tabla = $("#users").DataTable({
            serverSide: true,
            responsive: true,
            ajax: "api/ingredientes",
            dom: "Bfrtip",
            // iDisplayLength: 5,
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
                { data: "nombre", name: "ingrediente.nombre"},
                { data: "categoria", name: "categoriaingrediente.nombre"},
                { data: "disponible", name: "inventario.disponible"},
                { data: "costo", name: "inventario.costo"},
                { data: "fecha_ingreso", name: "inventario.fecha_ingreso"},
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
            url: "avatar",
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
                    $("#avatar").val("");
                    $("#avatar_name").val(datos.avatar);
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
        // Swal.fire(
        //     'Success',
        //     'Usuario creado correctamente',
        //     'success'
        // );
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
            // $("#vatar").hide();
            $("#btn-edit").hide();
            $("#btn-guardar").show();
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
    $.get("ingrediente/" + id, function(data, status) {
      
        // data = JSON.parse(data);
        $("#listadoUsers").hide();
        $("#registroForm").show();
        $("#btnCancelar").show();
        $("#btn-edit").show();
        $("#btnAgregar").hide();
        $("#btn-guardar").hide();
        $("#ver-contra").show();
        $("#vatar").show();
        let disponible = Number(data.inventario.disponible);
        // console.log(data.inventario.disponible);
        if(disponible <= 0){
            disponible = 0;
        }
        // console.log(disponible);

        // console.log(data);
        // $("#test").attr("src", '/AlienYard/public/avatar/'+data.user.avatar)
        $("#id").val(data.ingrediente.id);
        $("#categoria").val(data.ingrediente.categoria.id).trigger("change").select2();
        $("#nombre").val(data.ingrediente.nombre).attr("readonly", false);
        $("#disponible").val(disponible).attr("readonly", false);
        $("#costo").val(data.inventario.costo).attr("readonly", false);
        $("#fecha_ingreso").val(data.inventario.fecha_ingreso).attr("readonly", false);
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
        url: "ingrediente/delete/"+id,
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
