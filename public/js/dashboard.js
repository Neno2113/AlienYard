$(document).ready(function() {
    $("[data-mask]").inputmask();

    var tabla;

    //Funcion que se ejecuta al inicio
    function init() {
        $("#btn-edit").hide();
        ordenes();
        ventaDia();
        ordenesProceso();
        venta12meses();
        venta10dias();
        ordenesLista();
        inventario();
        // latest_orders();
        // latest_products();
        // latest_cortes();
        Chart.defaults.global.defaultFontColor = 'white';
    }

    //funcion para limpiar el formulario(los inputs)
    function limpiar() {
        $("#numero_corte").val("");
        // $("#sec").val("");
        $("#productos")
            .val("")
            .trigger("change");
        $("#fecha_entrega").val("");
        $("#no_marcada").val("");
        $("#corte").val("");
        $("#ancho_marcada").val("");
        $("#largo_marcada").val("");
        $("#aprovechamiento").val("");
    }

    function ordenes() {
        $.ajax({
            url: "ordenes/nuevas",
            type: "get",
            dataType: "json",
            success: function(datos) {
                if (datos.status == "success") {
                    // console.log(datos);
                    $("#cant_orden").html(datos.ordenesTomadas);
                } else {
                    bootbox.alert("Ocurrio un error !!");
                }
            },
            error: function() {
                bootbox.alert("Ocurrio un error!!");
            }
        });
    }

    function ventaDia() {
        $.ajax({
            url: "ventasDelDia",
            type: "get",
            dataType: "json",
            success: function(datos) {
                if (datos.status == "success") {
                    // console.log(datos);
                    $("#ventaDeldia").html("RD$ "+datos.dia);
                } else {
                    bootbox.alert("Ocurrio un error !!");
                }
            },
            error: function() {
                console.log("error");
            }
        });
    }

    function ordenesProceso() {
        $.ajax({
            url: "ordenes/proceso",
            type: "get",
            dataType: "json",
            success: function(datos) {
                if (datos.status == "success") {
                    $("#ordenes_proceso").html(datos.ordenesProceso);
                } else {
                    bootbox.alert("Ocurrio un error !!");
                }
            },
            error: function() {
                bootbox.alert("Ocurrio un error!!");
            }
        });
    }

    function ordenesLista() {
        $.ajax({
            url: "ordenes/listas",
            type: "get",
            dataType: "json",
            success: function(datos) {
                if (datos.status == "success") {
                    console.log(datos);
                    $("#ordenes_listas").html(datos.ordenesLista);
                } else {
                    bootbox.alert("Ocurrio un error !!");
                }
            },
            error: function() {
                bootbox.alert("Ocurrio un error!!");
            }
        });
    }

    $("#btnAgregar").click(function(e) {
        e.preventDefault();
        $("#btn-generar").show();
        mostrarForm(true);
    });
    $("#btnCancelar").click(function(e) {
        e.preventDefault();
        $("#btn-generar").attr("disabled", false);
        mostrarForm(false);
    });

    // // Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".card-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    });
    $(
        ".connectedSortable .card-header, .connectedSortable .nav-tabs-custom"
    ).css("cursor", "move");

    // // jQuery UI sortable for the todo list
    $(".todo-list").sortable({
        placeholder: "sort-highlight",
        handle: ".handle",
        forcePlaceholderSize: true,
        zIndex: 999999
    });

    //  /* jQueryKnob */
    $(".knob").knob();

    /* Chart.js Charts */
    // Sales chart
    function convertToArray(obj) {
        return Object.keys(obj).map(function(key) {
            return obj[key];
        });
    }

    function venta12meses() {
        $.ajax({
            url: "venta12meses",
            type: "get",
            dataType: "json",
            success: function(datos) {
                if (datos.status == "success") {
                    let fechas = [];
                    let totales = [];

                    //Fecha en mes de ventas
                    for (let i = 0; i < datos.result.length; i++) {
                        fechas.push(datos.result[i].mes);
                    }

                    //totales
                    for (let i = 0; i < datos.result.length; i++) {
                        totales.push(datos.result[i].total);
                    }

                    var ctx = document.getElementById("ventas12meses");

               
                    var myChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: fechas,
                            datasets: [
                                {
                                    label: "Venta ultimos 12 meses",
                                    data: totales,
                                    backgroundColor: [
                                        "rgba(255, 99, 132, 0.2)",
                                        "rgba(54, 162, 235, 0.2)",
                                        "rgba(255, 206, 86, 0.2)",
                                        "rgba(75, 192, 192, 0.2)",
                                        "rgba(153, 102, 255, 0.2)",
                                        "rgba(255, 159, 64, 0.2)"
                                    ],
                                    borderColor: [
                                        "rgba(255, 99, 132, 1)",
                                        "rgba(54, 162, 235, 1)",
                                        "rgba(255, 206, 86, 1)",
                                        "rgba(75, 192, 192, 1)",
                                        "rgba(153, 102, 255, 1)",
                                        "rgba(255, 159, 64, 1)"
                                    ],
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                yAxes: [
                                    {
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }
                                ]
                            }
                        }
                    });
                } else {
                    bootbox.alert("Ocurrio un error !!");
                }
            },
            error: function() {
                console.log("error");
            }
        });
    }

    function venta10dias() {
        $.ajax({
            url: "venta10dias",
            type: "get",
            dataType: "json",
            success: function(datos) {
                if (datos.status == "success") {
                    let fechas = [];
                    let totales = [];

                    //Fecha en mes de ventas
                    for (let i = 0; i < datos.result.length; i++) {
                        fechas.push(datos.result[i].date);
                    }

                    //totales
                    for (let i = 0; i < datos.result.length; i++) {
                        totales.push(datos.result[i].total);
                    }

                    var ctx = document.getElementById("ventas10dias");
                    var myChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: fechas,
                            datasets: [
                                {
                                    label: "Venta ultimos 10 dias",
                                    data: totales,
                                    backgroundColor: [
                                        "rgba(255, 99, 132, 0.2)",
                                        "rgba(54, 162, 235, 0.2)",
                                        "rgba(255, 206, 86, 0.2)",
                                        "rgba(75, 192, 192, 0.2)",
                                        "rgba(153, 102, 255, 0.2)",
                                        "rgba(255, 159, 64, 0.2)",
                                        "rgba(147, 255, 64, 0.2)",
                                        "rgba(148, 9, 9, 0.2)",
                                        "rgba(158, 176, 0, 0.2)",
                                        "rgba(12, 99, 0, 0.2)"
                                    ],
                                    borderColor: [
                                        "rgba(255, 99, 132, 1)",
                                        "rgba(54, 162, 235, 1)",
                                        "rgba(255, 206, 86, 1)",
                                        "rgba(75, 192, 192, 1)",
                                        "rgba(153, 102, 255, 1)",
                                        "rgba(255, 159, 64, 1)"
                                    ],
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                yAxes: [
                                    {
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }
                                ]
                            }
                        }
                    });
                } else {
                    bootbox.alert("Ocurrio un error !!");
                }
            },
            error: function() {
                console.log("error");
            }
        });
    }

    function inventario() {
        $.ajax({
            url: "inventario",
            type: "get",
            dataType: "json",
            success: function(datos) {
                if (datos.status == "success") {
                    // console.log(datos);
                    // let ingredientes = datos.inventario;
                    for (let i = 0; i < datos.inventario.length; i++) {
                        var orden =
                            "<tr>" +
                            "<td>" +
                            datos.inventario[i].ingrediente.nombre +
                            "</td>"+
                            "<td>" +
                            datos.inventario[i].nota +
                            "</td>"+
                            "<td>" +
                            "<span class='badge badge-danger'>"+
                            datos.inventario[i].disponible +
                            "</span>"+
                            "</td>" +
                            "<td>" +
                            datos.inventario[i].fecha_ingreso +
                            "</td>" +
                            "</tr>";
                        $("#latest_orders").append(orden);
                    }
                } else {
                    bootbox.alert("Ocurrio un error !!");
                }
            },
            error: function() {
                console.log("error");
            }
        });
    }

    function latest_products() {
        $.ajax({
            url: "latest_products",
            type: "get",
            dataType: "json",
            success: function(datos) {
                if (datos.status == "success") {
                    let productos = datos.productos;
                    for (let i = 0; i < datos.productos.length; i++) {
                        var producto =
                            "<li class='item'>" +
                            "<div class='product-info'>" +
                            "<a href='javascript:void(0)' class='product-title'>" +
                            productos[i].referencia_producto +
                            "<span class='badge badge-warning float-right'>$" +
                            productos[i].precio_lista +
                            "</span></a>" +
                            "<span class='product-description'>" +
                            productos[i].descripcion +
                            "</span>" +
                            "</div>" +
                            "</li>";
                            $("#productos").append(producto);
                    }


                } else {
                    bootbox.alert("Ocurrio un error !!");
                }
            },
            error: function() {
                console.log("error");
            }
        });
    }

    function latest_cortes() {
        $.ajax({
            url: "latest_cortes",
            type: "get",
            dataType: "json",
            success: function(datos) {
                if (datos.status == "success") {
                    let cortes = datos.cortes;
                    for (let i = 0; i < datos.cortes.length; i++) {
                        var corte =
                            "<tr>" +
                            "<td>" +
                            "<a href='pages/examples/invoice.html'>" +
                            cortes[i].numero_corte +
                            "</a></td>" +
                            "<td>" +
                            cortes[i].fase +
                            "</td>" +
                            "<td>" +
                            cortes[i].producto.referencia_producto +
                            "</td>" +
                            "<td>" +
                            "<div class='sparkbar' data-color='#00a65a'>" +
                            cortes[i].total +
                            "</div>" +
                            "</td>" +
                            "</tr>";
                            $("#latest_cortes").append(corte);
                    }


                } else {
                    bootbox.alert("Ocurrio un error !!");
                }
            },
            error: function() {
                console.log("error");
            }
        });
    }

    init();
});
