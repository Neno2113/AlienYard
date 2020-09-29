$(document).ready(function() {

   

    //Funcion que se ejecuta al inicio
    function init() {
  
        $("#desde").val("");
        $("#hasta").val("");
        mostrarForm(false);
        listarUltimas();
       
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
    $("#btnVolver").click(function(e) {
        e.preventDefault();
        mostrarForm(false);
        listarUltimas();
    });

    $("#btn-filtrar").on('click', ()=>{
        mostrarForm(true);
    })




    init();
});
var tabla;

$("#btn-generar").click(function(){
        
    
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    // alert("Hi");
    listar(desde, hasta);


});

function listarUltimas(){
    $("#users").DataTable().destroy();
    tabla = $("#users").DataTable({
        serverSide: true,
        responsive: true,
        ajax: "api/reporte/facturas/dia",
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
            { data: "name", name: "users.name"},
            { data: "no_factura", name: "factura.no_factura"},
            { data: "tipo_factura", name: "factura.tipo_factura"},
            { data: "numeroOrden", name: "maestro_pedido.numeroOrden"},
            { data: "fecha", name: "factura.fecha"},
            { data: "metodo_pago", name: "maestro_pedido.metodo_pago"},
            { data: "total", name: "factura.total"},
        ],
        order: [[1, "asc"]],
        // rowGroup: {
        //     dataSrc: "numeroOrden"
        // }
    });
}



//funcion para listar en el Datatable
function listar(desde, hasta) {
    $("#registroForm").hide();
    $("#listadoUsers").show();
    $("#users").DataTable().destroy();
    tabla = $("#users").DataTable({
        serverSide: true,
        responsive: true,
        ajax: "api/reporte/facturas/"+desde+"/"+hasta,
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
            { data: "name", name: "users.name"},
            { data: "no_factura", name: "factura.no_factura"},
            { data: "tipo_factura", name: "factura.tipo_factura"},
            { data: "numeroOrden", name: "maestro_pedido.numeroOrden"},
            { data: "fecha", name: "factura.fecha"},
            { data: "metodo_pago", name: "maestro_pedido.metodo_pago"},
            { data: "total", name: "factura.total"},
        ],
        order: [[1, "asc"]],
        // rowGroup: {
        //     dataSrc: "numeroOrden"
        // }
    });

    
}
