$(document).ready(function() {

    var tabla

    //Funcion que se ejecuta al inicio
    function init() {
  
        $("#desde").val("");
        $("#hasta").val("");
        mostrarForm(true);
    }

    function mostrarForm(flag) {
        
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
        mostrarForm(true);
    });


    init();
});


$("#btn-generar").click(function(){
        
    
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    // alert("Hi");
    listar(desde, hasta);


});


//funcion para listar en el Datatable
function listar(desde, hasta) {
    $("#registroForm").hide();
    $("#listadoUsers").show();
    $("#users").DataTable().destroy();
    tabla = $("#users").DataTable({
        serverSide: true,
        responsive: true,
        ajax: "api/reporte/ordenes/"+desde+"/"+hasta,
        dom: "Bfrtip",
        iDisplayLength: 10,
        buttons: [
            "pageLength",
            
            "copyHtml5",
            {
                extend: "excelHtml5",
                autoFilter: true,
                sheetnombre: "Exported data"
            },
            {
                extend: 'pdfHtml5',
                customize: function ( doc ) {
                    doc.content.splice( 0, 0, {
               
                        margin: [ 0, 0, 0, 5 ],
                        alignment: 'center',
                        image: "data:image/jpeg;base64,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"
                    } );
                }
            },
        ],
        columns: [
            { data: "Expandir", orderable: false, searchable: false },
            { data: "numeroOrden", name: "maestro_pedido.numeroOrden"},
            { data: "name", name: "users.name"},
            { data: "fecha_creacion", name: "maestro_pedido.fecha_creacion"},
            { data: "hora_pago", name: "maestro_pedido.hora_pago"},
            { data: "canal", name: "canal.canal"},
            { data: "metodo", name: "metodo_pago.metodo"},
            { data: "estado", name: "estado_pedido.estado"},

        
        ],
        order: [[1, "asc"]],
        // rowGroup: {
        //     dataSrc: "role"
        // }
    });

   
}



