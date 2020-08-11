@extends('adminlte.layout')

@section('seccion', 'Consulta')

@section('title', 'Inventario')

@section('content')



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
                <h4>Consulta de Inventario</h4>
            </div>
            <div class="card-body">
               
               
            </div>
         

        </div>
    </div>
  
</div>

<div class="card card-listado" id="listadoUsers">
    <div class="card-header text-center bg-dark">
        <h4>Listado de Inventario</h4>
    </div>
    <div class="card-body">

        <table id="inventario" class="table table-bordered table-hover datatables" style="width: 100%">
            <thead>
                <tr>  
                    <th>Ingrediente</th>
                    <th>Existencia</th>
                    <th>Costo</th>
                    <th>Nota</th>
                    <th>Fecha Ingreso</th>            
                </tr>
            </thead>
            <tbody class="bg-light text-dark reportes-body"></tbody>
            <tfoot>
                <tr>
                    <th>Ingrediente</th>
                    <th>Existencia</th>
                    <th>Costo</th>
                    <th>Nota</th>
                    <th>Fecha Ingreso</th>   
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="card-footer  text-muted ">
        <button class="btn  btn-danger mt-1" id="btnCancelar"><i class="fas fa-arrow-alt-circle-left fa-lg"></i>
            Cancelar</button>
        {{-- <button type="submit" id="btn-guardar" class="btn btn-info mt-1 float-right"><i
                class="far fa-save fa-lg"></i> Guardar</button>
        <button type="submit" id="btn-edit" class="btn btn-warning mt-1 float-right"><i
                class="far fa-edit fa-lg"></i> Editar</button> --}}

    </div>

</div>



@include('adminlte/scripts')
<script src="{{asset('js/consultas/reporteInventario.js')}}"></script>

@endsection