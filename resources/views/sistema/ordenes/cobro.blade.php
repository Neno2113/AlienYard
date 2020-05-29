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
                <h4>Cobros</h4>
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
                    <div class="col-md-2">
                        <label for="">Total</label>
                        <input type="text" name="total" id="total" class="form-control text-center font-weight-bold">
                    </div>
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
                    <div class="col-md-3">
                        <label for="">Efectivo</label>
                        <input type="text" name="efectivo" id="efectivo" class="form-control text-center"
                            data-inputmask='"mask": "RD$ 9[,]999"' data-mask>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                        <label for="">itbis</label>
                        <input type="text" name="itbis" id="itbis" class="form-control text-center">
                    </div>
                    <div class="col-md-2">
                        <label for="">Descuento</label>
                        <input type="text" name="descuento" id="descuento" class="form-control text-center">
                    </div>
                    
                    <div class="col-md-2 mt-1">
                        <button type="button" id="btn-aplicar" class="btn btn-dark btn-block mt-4 "><i
                                class="fas fa-calculator"></i> Aplicar</button>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2 mt-1">
                        <button type="button" id="btn-payT" class="btn btn-success btn-block mt-4 pl-2"><i
                                class="fab fa-cc-amazon-pay fa-lg"></i> Pagar</button>
                        <button type="button" id="btn-payM" class="btn btn-success btn-block mt-4 pl-2"><i
                                class="fab fa-cc-amazon-pay fa-lg"></i> Pagar</button>
                    </div>

                    <div class="col-md-2 mt-1">
                        <button type="button" id="btn-dividir" class="btn btn-primary btn-block mt-4 pl-2"><i
                                class="fas fa-divide"></i> Dividir cuentas</button>
                    </div>
                </div>
                <div class="row mt-3" id="fila-botones">
                    <div class="col-md-12">
                        <button class="btn btn-primary rounded-pill float-left" name="btn-agregar" id="btn-generar"><i
                                class="fas fa-file-invoice-dollar"></i>
                            Generar</button>
                    

                        <a class="btn btn-secondary rounded-pill float-right text-white" name="btn-imprimir"
                            id="btn-imprimir"><i class="fas fa-print"></i>
                            Imprimir</a>
                    </div>
                </div>
                <hr class="mt-5">
                <div class="row mt-4">
                    <h5 class="">Platos</h5>
                    <hr>
                    <table class="table tabla-existencia table-bordered" id="table-receta">
                        <thead style="font-size: 15px;" class="text-center font-weight-bold thead-dark">
                            <tr>
                                <th>Plato</th>
                                <th>Precio</th>
                                <th id="editar-permisos">Facturar</th>
                            </tr>
                        </thead>
                        <tbody id="platos">

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

<div class="card" id="listadoUsers">
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



@include('adminlte/scripts')
<script src="{{asset('js/ordenes/cobro.js')}}"></script>

@endsection