@extends('adminlte.layout')

@section('seccion', 'Ordenes')

@section('title', 'Pagos')

@section('content')
{{-- <div class="container"> --}}


<div class="row ">
    <div class="col-12">
        <div class="card  mb-3" id="registroForm">
            <div class="card-header text-center bg-dark">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                            class="fas fa-remove"></i></button>
                </div>
                <h4>Pagos</h4>
            </div>
            <div class="card-body">
                <div class="d-flex flex-row-reverse ">
                    <div class="col-md-2">
                        <label for="" class="ml-4">Numero orden</label>
                        <input type="text" name="numero_orden" id="numero_orden"
                            class="form-control text-center font-weight-bold">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Canal</label>
                        <input type="text" name="canal" id="canal" class="form-control text-center font-weight-bold">
                        <input type="hidden" name="pedido" id="pedido">
                    </div>
                    <div class="col-md-4">
                        <label for="">Estado</label>
                        <input type="text" name="estado" id="estado" class="form-control text-center font-weight-bold">
                    </div>
                    <div class="col-md-4">
                        <label for="">Metodo de pago</label>
                        <select name="metodo_pago" id="metodo_pago" class="form-control select2">
                            <option value="" disabled>Elige un metodo de pago</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">

                    <div class="col-md-4">
                        <label for="">Tipos de factura</label>
                        <select name="tipo_factura" id="tipo_factura" class="form-control select2">
                            <option value="" disabled>Elige un tipo de factura</option>
                            <option value="IN">Factura</option>
                            <option value="B01">Comprobante fiscal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="">Numero factura</label>
                        <input type="text" name="numero_factura" id="numero_factura" class="form-control text-center"
                            data-inputmask='"mask": "99999[99999]"' data-mask>
                        <input type="hidden" name="factura" id="factura">
                    </div>
                    <div class="col-md-2">
                        <label for="">Total</label>
                        <input type="text" name="total" id="total" class="form-control text-center font-weight-bold">
                    </div>
                    <div class="col-md-3">
                        <label for="">Efectivo</label>
                        <input type="text" name="efectivo" id="efectivo" class="form-control text-center"
                            data-inputmask='"mask": "RD$ 9[,]999"' data-mask>
                    </div>
                </div>
                <div class="row mt-3">
                    {{-- <div class="col-md-2">
                        <label for="">Itbis</label>
                        <input type="text" name="itbis" id="itbis" class="form-control text-center">
                    </div> --}}
                    <div class="col-md-2">
                        <label for="">Oferta</label>
                        <input type="text" name="descuento" id="descuento" class="form-control text-center">
                    </div>

                    <div class="col-md-2 mt-1 pt-1">
                        <button type="button" id="btn-aplicar" class="btn btn-dark btn-block mt-4 "><i
                                class="fas fa-percent"></i> Aplicar</button>
                    </div>
                    <div class="col-md-2 mt-1 pt-1">
                        <button data-toggle='modal' id="btn-comprobante" data-target='.bd-example-modal-lg'
                            class='btn btn-primary  mt-4'> <i class="fas fa-file-invoice-dollar"></i> Factura fiscal</button>
                    </div>
                    <div class="col-md-2 "> </div>
                    <div class="col-md-2 mt-1">
                        <button type="button" id="btn-payT" class="btn btn-success btn-block mt-4 pl-2"><i
                                class="fab fa-cc-amazon-pay fa-lg"></i> Procesar</button>
                        <button type="button" id="btn-payM" class="btn btn-success btn-block mt-4 pl-2"><i
                                class="fab fa-cc-amazon-pay fa-lg"></i> Procesar</button>
                    </div>

                    {{-- <div class="col-md-2 mt-1">
                        <button type="button" id="btn-dividir" class="btn btn-primary btn-block mt-4 pl-2"><i
                                class="fas fa-divide"></i> Dividir cuentas</button>
                        <button type="button" id="btn-dividirM" class="btn btn-primary btn-block mt-4 pl-2"><i
                                class="fas fa-divide"></i> Dividir cuentas</button>
                    </div> --}}
                </div>
                <div class="row mt-3" id="fila-botones">
                    <div class="col-md-12">
                        <button class="btn btn-primary float-left" name="btn-agregar" id="btn-generar"><i
                                class="fas fa-file-invoice-dollar"></i>
                            Generar</button>


                        <a class="btn btn-secondary rounded-pill float-right text-white" name="btn-imprimir"
                            id="btn-imprimir"><i class="fas fa-print"></i>
                            Imprimir</a>
                    </div>
                </div>
                <hr class="bg-white">
                {{-- <h5 class="text-center font-weight-bold text-white">Platos</h5> --}}
                <div class="row mt-4">

                    <hr>
                    <table class="table tabla-existencia table-bordered" id="table-receta">
                        <thead style="font-size: 15px;" class="text-center font-weight-bold thead-dark ">
                            <tr>
                                <th>Plato</th>
                                <th>Precio</th>
                                <th>Pago</th>
                                <th id="editar-permisos">Facturar</th>
                            </tr>
                        </thead>
                        <tbody id="platos" class="text-white">

                        </tbody>

                    </table>
                </div>

            </div>
            <div class="card-footer  text-muted ">
                <button class="btn  btn-danger mt-1" id="btnCancelar"><i class="fas fa-arrow-alt-circle-left fa-lg"></i>
                    Cancelar</button>
                <button type="submit" id="btn-guardar" class="btn btn-primary mt-1 float-right"><i
                        class="far fa-save fa-lg"></i> Guardar</button>
                <button type="submit" id="btn-edit" class="btn btn-warning mt-1 float-right"><i
                        class="far fa-edit fa-lg"></i> Editar</button>

            </div>

        </div>
    </div>

</div>

<div class="card card-listado" id="listadoUsers">
    <div class="card-header text-center bg-dark">
        <h4> Listado de ordenes</h4>
    </div>
    <div class="card-body">

        <table id="users" class="table table-bordered table-hover datatables" style="width: 100%">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>#</th>
                    <th>Estado</th>
                    <th>Canal</th>
                    <th>Delivery</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th>Actions</th>
                    <th>#</th>
                    <th>Estado</th>
                    <th>Canal</th>
                    <th>Delivery</th>
                </tr>
            </tfoot>
        </table>
    </div>

</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ventana comprobante fiscal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row ">
                        <div class="col-md-4">
                            <label for="name" class="text-dark">RNC/Cedula</label>
                            <input type="text" name="rnc" id="rnc" class="form-control"
                                data-inputmask='"mask": "999999999[99]"' data-mask>
                        </div>
                        <div class="col-md-4">
                            <label for="nombre_cont" class="text-dark">Nombre/Razon Social</label>
                            <input type="text" name="nombre_cont" id="nombre_cont" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="estado_cont" class="text-dark">Estado</label>
                            <input type="text" name="estado_cont" id="estado_cont" class="form-control">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="far fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>



@include('adminlte/scripts')
<script src="{{asset('js/ordenes/cobro.js')}}"></script>

@endsection