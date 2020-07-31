@extends('adminlte.layout')

@section('seccion', 'Ordenes')

@section('title', 'Ordenes')

@section('content')

<div id="listadoUsers">
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1 class="text-center text-white">Ordenes</h1>
                        </div>
                        <hr class="menuLineUp">
                    </div>
                </div>
                <div class="row" id="pedidos">



                </div>
                <!-- /.row -->


            </div>
        </div>
    </div>
</div>



<div class="modal fade bd-comentarios-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Platos de la orden</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="" class="modal-body">
                <div id="accordion">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                        class="fas fa-times fa-lg"></i></button>
                <button type="button" class="btn btn-primary mr-3" id="btnReady"><i class="fas fa-hamburger"></i>
                    Listo</button>

            </div>

        </div>
    </div>
</div>







@include('adminlte/scripts')
<script src="{{asset('js/ordenes/ordenes.js')}}"></script>

@endsection