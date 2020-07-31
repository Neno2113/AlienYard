$(document).ready(function() {
    $("[data-mask]").inputmask();

    $("#formulario").validate({
        rules: {
     
            password: {
                required: true,
                pwcheck: true,
                minlength: 8
            }
        },
        messages: {
         
            password: {
                required: "La contraseña es obligatoria",
                pwcheck: "La contraseña debe contener al menos 8 caracteres entre minusculas, mayusculas, numeros y un caracter especial",
                minlength: "La contraseña debe contener al menos 8 caracteres entre minusculas, mayusculas, numeros y un caracter especial"
            }
        }  
    })
    $.validator.addMethod("pwcheck", function(value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
            && /[a-z]/.test(value) // has a lowercase letter
            && /[A-Z]/.test(value) // has a uppercase letter
            && /\d/.test(value) // has a digit
     });

     
    var tabla;

    function init() {
        listar();
        mostrarForm(false);
        $("#btn-edit").hide();
    }

    function limpiar() {
        $("#name")
            .val("")
            .attr("readonly", false);
        $("#surname")
            .val("")
            .attr("readonly", false);
        $("#edad")
            .val("")
            .attr("readonly", false);
        $("#telefono")
            .val("")
            .attr("readonly", false);
        $("#celular")
            .val("")
            .attr("readonly", false);
        $("#direccion")
            .val("")
            .attr("readonly", false);
        $("#email")
            .val("")
            .attr("readonly", false);
        $("#role")
            .val("")
            .attr("disabled", false);
        $("#password")
            .val("")
            .attr("readonly", false);
        $("#ver-contra").show();
        $("#username").val("");
      
    }

    $("#btn-guardar").click(function(e) {
        // validacion(e);
        e.preventDefault();
        guardar();
      
    });

    function guardar(){
        var user = {
            name: $("#name").val(),
            surname: $("#surname").val(),
            email: $("#email").val(),
            username: $("#username").val(),
            edad: $("#edad").val(),
            telefono: $("#telefono").val(),
            celular: $("#celular").val(),
            direccion: $("#direccion").val(),
            role: $("#role").val(),
            password: $("#password").val(),
            avatar: $("#avatar_name").val()
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
                        "Success",
                        "Usuario creado correctamente",
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
                let errores = datos.responseJSON.errors;
                console.log(datos);
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
            ajax: "api/users",
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
                { data: "Expandir", orderable: false, searchable: false },
            
                { data: "Editar", orderable: false, searchable: false },
                { data: "name" },
                { data: "surname" },
                { data: "email" },
                { data: "role" },
                { data: "edad" },
                { data: "celular" }
            ],
            order: [[6, "asc"]],
            rowGroup: {
                dataSrc: "role"
            }
        });
    }

    $("#btn-edit").click(function(e) {
        e.preventDefault();

        var form = $("#formulario").valid();
        // console.log(form);

        if(form){
            var user = {
                id: $("#id").val(),
                name: $("#name").val(),
                surname: $("#surname").val(),
                email: $("#email").val(),
                username: $("#username").val(),
                edad: $("#edad").val(),
                telefono: $("#telefono").val(),
                celular: $("#celular").val(),
                direccion: $("#direccion").val(),
                role: $("#role").val(),
                password: $("#password").val(),
                avatar: $("#avatar_name").val()
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
                            "Success",
                            "Usuario actualizado correctamente",
                            "success"
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
        }else{
            Swal.fire(
                "Info",
                "Asegurese de cumplir con los requerimientos de la contraseña",
                "info"
            ); 
        }
    
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
        $("#avatar").show();

        // console.log(data);
        // $("#test").attr("src", '/AlienYard/public/avatar/'+data.user.avatar)
        $("#id").val(data.user.id);
        $("#avatar_name").val(data.user.avatar);
        $("#user_id").val(data.user.id);
        $("#name").val(data.user.name);
        $("#surname").val(data.user.surname);
        $("#edad").val(data.user.edad);
        $("#telefono").val(data.user.telefono);
        $("#celular").val(data.user.celular);
        $("#direccion").val(data.user.direccion);
        $("#email").val(data.user.email);
        $("#username").val(data.user.username);
        $("#role").val(data.user.role);
    });
}

function ver(id_user) {
    $.post("user/" + id_user, function(data, status) {
        $("#listadoUsers").hide();
        $("#registroForm").show();
        $("#btnCancelar").show();
        $("#btnAgregar").hide();
        $("#btn-guardar").hide();

        $("#name")
            .val(data.user.name)
            .attr("readonly", true);
        $("#ver-contra").hide();
        $("#surname")
            .val(data.user.surname)
            .attr("readonly", true);
        $("#edad")
            .val(data.user.edad)
            .attr("readonly", true);
        $("#telefono")
            .val(data.user.telefono)
            .attr("readonly", true);
        $("#celular")
            .val(data.user.celular)
            .attr("readonly", true);
        $("#direccion")
            .val(data.user.direccion)
            .attr("readonly", true);
        $("#email")
            .val(data.user.email)
            .attr("readonly", true);
        $("#role")
            .val(data.user.role)
            .attr("disabled", true);
    });
}

function eliminar(id_user) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.value) {
            accionEliminar(id_user);
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
        url: "user/delete/"+id,
        type: "post",
        dataType: "json",
        // data: JSON.stringify(user),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                Swal.fire("Deleted!", "Your file has been deleted.", "success");    
                $("#id").val("");

                $("#users").DataTable().ajax.reload();
              
            
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
}
