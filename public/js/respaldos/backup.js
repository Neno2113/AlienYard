$(document).ready(function() {
    $("[data-mask]").inputmask();
    moment.locale('es-do');   

    var tabla;

    function init() {
        listar();
        mostrarForm(false);
        $("#btn-edit").hide();
    }

    function limpiar() {
  

    }

    $("#btn-guardar").click(function(e) {
        // validacion(e);
        e.preventDefault();
        guardar();
      
    });

    function guardar(){
        $("#btn-guardar").hide();
        $("#btn-spin").show();
        $.ajax({
            url: "backup/create",
            type: "PUT",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
               
            },
            error: function(datos) {
                console.log(datos);
                if (datos.status == 200 && datos.responseText == "success") {
                    Swal.fire(
                        "Respaldo realizado correctamente",
                        "",
                        "success"
                    );
                    $("#btn-guardar").show();
                    $("#btn-spin").hide();
                    listar();
                } else {
                    bootbox.alert(
                        "Ocurrio un error durante la creacion del usuario verifique los datos suministrados!!"
                    );
                }
                // Swal.fire(
                //     "Success",
                //     "Respaldo realizado correctamente",
                //     "success"
                // );
            }
        });
    }

    function listar() {
        $("#respaldos").empty();
        $.ajax({
            url: "backup",
            type: "GET",
            dataType: "json",
            contentType: "application/json",
            success: function(datos) {
                console.log(datos);
                for (let i = 0; i < datos.backups.length; i++) {
                    var backups = `
                    <tr id="fila${datos.backups[i].last_modified}">
                        <td>${datos.backups[i].disk}</td>
                        <td>${moment.unix(datos.backups[i].last_modified).fromNow()}</td>
                        <td>${datos.backups[i].file_path}</td>
                        <td>${Math.round(parseInt(datos.backups[i].file_size/1048576))} MB</td>
                        
                        </td>
                    </tr>
                    `
                    
                    $("#respaldos").append(backups);
                }
            },
            error: function(datos) {
                console.log(datos);
                console.log("Error Why")
                
             
            }
        });
    }


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
            $("#btn-spin").hide();
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

function eliminar(file_name, disco, last_modified) {
    Swal.fire({
        title: "¿Esta seguro de eliminar este respaldo?",
        text: "El respaldo de eliminara para siempre!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar respaldo!"
    }).then(result => {
        if (result.value) {
            accionEliminar(file_name, disco, last_modified);
        }
    });
    
}

function accionEliminar(file_name, disco, last_modified){
    // console.log(file_name);
    // console.log(disco);
    var data = {
        file_name: file_name,
        disco: disco
    };

    $.ajax({
        url: "backup/delete",
        type: "DELETE",
        dataType: "json",
        data: JSON.stringify(data),
        contentType: "application/json",
        success: function(datos) {
          
        },
        error: function(datos) {
            // console.log(datos);
            Swal.fire("Respaldo Eliminado!", "El respaldo ha sido eliminado.", "success");    

            $("#fila"+last_modified).remove();
        }
    });
}
