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
    }

    function limpiar() {
        $("#name").val("").attr('readonly', false);
        $("#surname").val("").attr('readonly', false);
        $("#edad").val("").attr('readonly', false);
        $("#telefono").val("").attr('readonly', false);
        $("#celular").val("").attr('readonly', false);
        $("#direccion").val("").attr('readonly', false);
        $("#email").val("").attr('readonly', false);
        $("#role").val("").attr('disabled', false);
        $("#password").val("").attr('readonly', false);
        $("#ver-contra").show();
    }

    $("#btn-guardar").click(function(e) {
        // validacion(e);
        e.preventDefault();
        
        var user = {
            name: $("#name").val(),
            surname: $("#surname").val(),
            email: $("#email").val(),
            edad: $("#edad").val(),
            telefono: $("#telefono").val(),
            celular: $("#celular").val(),
            direccion: $("#direccion").val(),
            role: $("#role").val(),
            password: $("#password").val()
        };


        $.ajax({
            url: "user",
            type: "POST",
            dataType: "json",
            data: JSON.stringify(user),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    Swal.fire(
                        'Success',
                        'Usuario creado correctamente',
                        'success'
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
                        message:"<h4 class='invalid-feedback d-block'>"+val+"</h4>",
                        size: 'small'
                    });
                });            
            }
        });
    });

    function listar() {
        tabla = $("#users").DataTable({
            serverSide: true,
            responsive: true,
            ajax: "api/users",
            dom: 'Bfrtip',
            iDisplayLength: 5,  
            buttons: [
                'pageLength',
                'copyHtml5',
                 {
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetnombre: 'Exported data'
                },
                'csvHtml5',
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
                ],
            columns: [
                { data: "Expandir", orderable: false, searchable: false },
                { data: "Ver", orderable: false, searchable: false },
                { data: "Editar", orderable: false, searchable: false },
                { data: "name" },
                { data: "surname" },
                { data: "email" },
                { data: "role" },
                { data: "edad" },
                { data: "celular" },
            ],
            order: [[6, 'asc']],
            rowGroup: {
                dataSrc: 'role'
            }
        });
    }

    $("#btn-edit").click(function(e) {
        e.preventDefault();
        var user = {
            id: $("#id").val(),
            name: $("#name").val(),
            surname: $("#surname").val(),
            email: $("#email").val(),
            edad: $("#edad").val(),
            telefono: $("#telefono").val(),
            celular: $("#celular").val(),
            direccion: $("#direccion").val(),
            role: $("#role").val(),
            password: $("#password").val()
        };
     
        $.ajax({
            url: "user",
            type: "post",
            dataType: "json",
            data: JSON.stringify(user),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    Swal.fire(
                        'Success',
                        'Usuario actualizado correctamente',
                        'success'
                    );
                    $("#id").val("");
                    limpiar();
                    tabla.ajax.reload();
                    mostrarForm(false);
                    // $("#listadoUsers").show();
                    // $("#registroForm").hide();
                    // $("#btnCancelar").hide();
                    // $("#btn-edit").hide();
                    // $("#btn-guardar").show();
                    // $("#btnAgregar").show();

                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                    );
                }
            },
            error: function() {
                bootbox.alert(
                    "Ocurrio un error, trate rellenando los campos obligatorios(*)"
                );
            }
        });
       
    });

    $("#formUpload").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "user/avatar",
            type: "POST",
            data: formData,
            dataType: "JSON",
            processData: false,
            cache: false,
            contentType: false,
            success: function(datos) {
                if (datos.status == "success") {
                    Swal.fire(
                        'Success',
                        'Imagen subida correctamente',
                        'success'
                    )
                    $("#avatar").val("");
                  ;
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
    // setInterval(function(){
    //     tabla.ajax.reload();
    // }, 30000)

    $("#btn-upload").click(function(e){
        e.preventDefault();
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

function mostrar(id_user) {
    $.post("user/" + id_user, function(data, status) {
        // data = JSON.parse(data);
        $("#listadoUsers").hide();
        $("#registroForm").show();
        $("#btnCancelar").show();
        $("#btn-edit").show();
        $("#btnAgregar").hide();
        $("#btn-guardar").hide();
        $("#ver-contra").show();

        // console.log(data);
        $("#id").val(data.user.id);
        $("#name").val(data.user.name).attr('readonly', false);
        $("#surname").val(data.user.surname).attr('readonly', false);
        $("#edad").val(data.user.edad).attr('readonly', false);
        $("#telefono").val(data.user.telefono).attr('readonly', false);
        $("#celular").val(data.user.celular).attr('readonly', false);
        $("#direccion").val(data.user.direccion).attr('readonly', false);
        $("#email").val(data.user.email).attr('readonly', false);
        $("#role").val(data.user.role).attr('disabled', false);
    });
}


function ver(id_user) {
    $.post("user/" + id_user, function(data, status) {
        $("#listadoUsers").hide();
        $("#registroForm").show();
        $("#btnCancelar").show();
        $("#btnAgregar").hide();
        $("#btn-guardar").hide();

        
        $("#name").val(data.user.name).attr('readonly', true);
        $("#ver-contra").hide();
        $("#surname").val(data.user.surname).attr('readonly', true);
        $("#edad").val(data.user.edad).attr('readonly', true);
        $("#telefono").val(data.user.telefono).attr('readonly', true);
        $("#celular").val(data.user.celular).attr('readonly', true);
        $("#direccion").val(data.user.direccion).attr('readonly', true);
        $("#email").val(data.user.email).attr('readonly', true);
        $("#role").val(data.user.role).attr('disabled', true);
    });
}


function eliminar(id_user){
    bootbox.confirm("¿Estas seguro de eliminar este usuario?", function(result){
        if(result){
            $.post("user/delete/" + id_user, function(){
                // bootbox.alert(e);
                bootbox.alert("Usuario eliminado correctamente");
                $("#users").DataTable().ajax.reload();
            })
        }
    })
}
