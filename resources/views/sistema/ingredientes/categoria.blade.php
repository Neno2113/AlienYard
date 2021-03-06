@extends('adminlte.layout')

@section('seccion', 'Categorias')

@section('title', 'Ingrediente')

@section('content')
{{-- <div class="container"> --}}
<div class="row mt-3 ml-3">
   
    {{-- <button class="btn btn-danger mb-3 " id="btnCancelar"><i class="fas fa-window-close"></i></button> --}}
</div>

<div class="row "> 
    <div class="col-md-3"></div>
    <div class="col-md-5">
        <div class="card  mb-3" id="registroForm">
            <div class="card-header text-center bg-danger pt-2">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                            class="fas fa-remove"></i></button>
                </div>
                {{-- <h4>Categoria Ingrediente</h4> --}}
            </div>
            <div class="card-body">
                <h4 class="font-weight-bold text-center text-white">Categoria del ingrediente</h4>
                <hr class="bg-white">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <label for="" class="text-center">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                        <input type="hidden" name="id" id="id">
                    </div>
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
{{-- </div> --}}

<div class="card card-listado" id="listadoUsers">
    <div class="card-header bg-dark">
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary float-left" id="btnAgregar"><i class="fas fa-plus"></i> Agregar</button>
                <h4 class="text-center"> Listado de categorias</h4>
            </div>
        </div>
       
    </div>
    <div class="card-body">

        <table id="users" class="table table-bordered table-hover datatables" style="width: 100%">
            <thead>
                <tr>
                    <th></th>    
                    <th>Nombre</th>
                    <th>Actions</th>
                
                </tr>
            </thead>
            <tbody class="text-white font-weight-bold"></tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
    </div>

</div>



@include('adminlte/scripts')
<script src="{{asset('js/ingredientes/categoria-ingredientes.js')}}"></script>

@endsection