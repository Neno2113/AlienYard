$(document).ready(function() {
    $("[data-mask]").inputmask();




    var tabla;

    function init() {
        listar();
        usuarios();
        mostrarForm(false);
        $("#btn-edit").hide();
        $("#permisos").select2();
    }


    function usuarios (){

        $.ajax({
            url: "usuarios",
            type: "GET",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    var longitud = datos.usuarios.length;

                    for (let i = 0; i < longitud; i++) {
                        var fila =  "<option value="+datos.usuarios[i].id +">"+datos.usuarios[i].name+" "+datos.usuarios[i].surname+"</option>"

                        $("#usuario").append(fila);
                    }
                    $("#usuario").select2();

                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la actualizacion de la composicion"
                    );
                }
            },
            error: function() {
                bootbox.alert(
                    "Ocurrio un error!!"
                );
            }
        });
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
        e.preventDefault();

        limpiar();
        tabla.ajax.reload();
        mostrarForm(false);
        Swal.fire(
            'Success',
            'Permisos agregados correctamente.',
            'success'
        )

    });

    $("#btn-agregar").on('click', function(e){
        e.preventDefault();

        agregar();
    });


    function agregar(){

        var permiso = {
            permiso: $("#permisos").val(),
            usuario: $("#usuario").val()
        };

        $.ajax({
            url: "permiso",
            type: "POST",
            dataType: "json",
            data: JSON.stringify(permiso),
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
                        title: 'Permiso agregado correctamente.'
                    })
                    let usuario = $("#usuario option:selected").text();
                    let permiso = $("#permisos option:selected").text();
                    var cont;
                    var fila =
                    '<tr id="fila'+datos.permiso.id+'">'+
                    "<td class=''><input type='hidden' id='usuario"+datos.permiso.user.id+"' value="+datos.permiso.user.id+">"+datos.permiso.user.name+"</td>"+
                    "<td class='font-weight-bold'><input type='hidden' id='permiso"+datos.permiso.id+"' value="+datos.permiso.id+">"+datos.permiso.permiso+"</td>"+
                    "<td><button type='button' id='btn-eliminar' onclick='delAcceso("+datos.permiso.id+")' class='btn btn-danger'><i class='fas fa-user-lock'></i></i></button></td>"+
                    "</tr>";
                    $("#permisos-agregados").append(fila);
                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                    );
                }
            },
            error: function(datos) {
                Swal.fire(
                    'Error',
                    'Este usuario ya tiene este permiso asignado.',
                    'error'
                )
            }
        });
    }

    function listar() {
        tabla = $("#users").DataTable({
            serverSide: true,
            responsive: true,
            ajax:{
                "url": "api/permisos",
                "type": "POST"
            },
            dom: 'Bfrtip',
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
                { data: "Opciones", orderable: false, searchable: false },
                { data: "name", name: 'users.name'},
                // { data: "permiso", name: 'permiso_usuario.permiso'},
                { data: "role", name: 'users.role'},
                { data: "email", name: 'users.email'}
            ],
            order: [[2, 'asc']],
            rowGroup: {
                dataSrc: 'role'
            }
        });
    }

    $("#btn-edit").click(function(e) {
        e.preventDefault();
        var user = {
            id: $("#id").val(),
            nombre: $("#name").val(),
            apellido: $("#surname").val(),
            email: $("#email").val(),
            edad: $("#edad").val(),
            telefono: $("#telefono").val(),
            celular: $("#celular").val(),
            direccion: $("#direccion").val(),
            role: $("#role").val(),
            password: $("#password").val()
        };

        $.ajax({
            url: "user/edit",
            type: "PUT",
            dataType: "json",
            data: JSON.stringify(user),
            contentType: "application/json",
            success: function(datos) {
                if (datos.status == "success") {
                    bootbox.alert("Se actualizado correctamente el usuario");
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
    // setInterval(function(){
    //     tabla.ajax.reload();
    // }, 30000)

    function mostrarForm(flag) {
        limpiar();
        if (flag) {
            $("#listadoUsers").hide();
            $("#registroForm").show();
            $("#btnCancelar").show();
            $("#btnAgregar").hide();
        } else {
            $("#listadoUsers").show();
            $("#registroForm").hide();
            $("#btnCancelar").hide();
            $("#fila1").show();
            $("#btn-agregar").show();
            $("#btn-edit").hide();
            $("#editar-permisos").hide();
            $("#btn-guardar").show();
        }
    }

    $("#btnAgregar").click(function(e) {
        e.preventDefault();
        mostrarForm(true);
        $("#editar-permisos").hide();
        $("#permisos-agregados").empty();
    });
    $("#btnCancelar").click(function(e) {
        e.preventDefault();
        mostrarForm(false);
    });

    $("#btn-eliminar").click(function(e){
        e.preventDefault();
        alert("Hi");
    });


    init();
});


function mostrar(id_user) {
    $.get("permiso/" + id_user, function(data, status) {

        $("#listadoUsers").hide();
        $("#registroForm").show();
        $("#btnCancelar").show();
        // $("#btn-edit").show();
        // $("#btn-agregar").hide();
        // $("#btn-guardar").hide();
        $("#fila1").show();
        $("#ver-contra").show();
        $("#editar-permisos").show();
        $("#permisos-agregados").empty();
        $("#usuario").val(id_user).trigger('change');

        for (let i = 0; i < data.permiso.length; i++) {
            var fila =
            '<tr id="fila'+data.permiso[i].id+'">'+
            "<td class=''><input type='hidden' id='usuario"+data.permiso[i].user.id+"' value="+data.permiso[i].user.id+">"+data.permiso[i].user.name+"</td>"+
            "<td class='font-weight-bold'><input type='hidden' id='permiso"+data.permiso[i].id+"' value="+data.permiso[i].id+">"+data.permiso[i].permiso+"</td>"+
            "<td><button type='button' id='btn-eliminar' onclick='delAcceso("+data.permiso[i].id+")' class='btn btn-danger'><i class='fas fa-user-lock'></i></i></button></td>"+
            "</tr>";
            $("#permisos-agregados").append(fila);
        }


    });
}

function delAcceso(id){
    Swal.fire({
        title: '¿Esta seguro de quitarle este acceso a este usuario?',
        text: "Eliminar acceso",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, acepto'
      }).then((result) => {
        if (result.value) {
            eliminarAcceso(id);
        }
      })
}

function eliminarAcceso(id){

    $.ajax({
        url: "permiso/delete/"+id,
        type: "POST",
        dataType: "json",
        // data: JSON.stringify(permiso),
        contentType: "application/json",
        success: function(datos) {
            if (datos.status == "success") {
                // console.log(datos);
                Swal.fire(
                    'Success',
                    'Permiso eliminado correctamente.',
                    'success'
                )
                $("#fila"+id).remove();

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
}


// function eliminar(id_permiso){
//     bootbox.confirm("¿Estas seguro de eliminarle este acceso a este usuario?", function(result){
//         if(result){
//             $.post("permiso/delete/" + id_permiso, function(){
//                 // bootbox.alert(e);
//                 bootbox.alert("Acceso eliminado correctamente!!");
//                 $("#users").DataTable().ajax.reload();
//             })
//         }
//     })
// }



