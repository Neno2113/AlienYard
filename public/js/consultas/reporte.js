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
            "csvHtml5",
            {
                extend: "pdfHtml5",
                orientation: "landscape",
                pageSize: "LEGAL"
            }
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



