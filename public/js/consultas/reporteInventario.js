$(document).ready(function() {

    var tabla

    //Funcion que se ejecuta al inicio
    function init() {
      
     
        mostrarForm(false);
        listar();
    }

    //funcion para listar en el Datatable
    function listar() {
        tabla = $("#inventario").DataTable({
            serverSide: true,
            responsive: true,
            ajax: "api/reporte/inventario",
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
                { data: "nombre", name: "ingrediente.nombre" },
                { data: "disponible", name: "inventario.disponible" },
                { data: "costo", name: "inventario.costo"},
                { data: "nota", name: "inventario.nota"},
                { data: "fecha_ingreso", name: "inventario.fecha_ingreso"},
            ],
            order: [[1, "asc"]]
            // rowGroup: {
            //     dataSrc: "role"
            // }
        });
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




    init();
});







