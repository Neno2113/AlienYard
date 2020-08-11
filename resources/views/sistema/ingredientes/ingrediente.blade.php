@extends('adminlte.layout')

@section('seccion', 'Categorias')

@section('title', 'Ingrediente')

@section('content')
{{-- <div class="container"> --}}
<div class="row mt-3 ml-3">
    <button class="btn btn-primary mb-3 " id="btnAgregar"><i class="fas fa-plus-circle"></i> Agregar</button>
    {{-- <button class="btn btn-danger mb-3 " id="btnCancelar"><i class="fas fa-window-close"></i></button> --}}
</div>

<div class="row ">

    <div class="col-12">
        <div class="card  mb-3" id="registroForm">
            <div class="card-header text-center bg-danger p-2">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                            class="fas fa-remove"></i></button>
                </div>
                {{-- <h4>Ingrediente</h4> --}}
            </div>
            <div class="card-body">
                <h4 class="font-weight-bold text-center text-white">Ingrediente</h4>
                <hr class="bg-white">
                <form action="" id="formulario" class="form-group carta panel-body">


                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Categoria</label>
                            <select name="categoria" id="categoria" class="form-control selectpicker">
                                <option value="" disabled>Elige una categoria</option>
                            </select>
                            <input type="hidden" name="id" id="id">
                        </div>
                        <div class="col-md-4">
                            <label for="">Nombre</label>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="">Disponible</label>
                            <input type="text" name="disponible" id="disponible" placeholder="Disponible"
                                class="form-control text-center" data-inputmask='"mask": "9[99]"' data-mask>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="">Costo</label>
                            <input type="text" name="costo" id="costo" placeholder="Costo"
                                class="form-control text-center" data-inputmask='"mask": "RD$ 9[9[9[9]]]"' data-mask>
                        </div>
                        <div class="col-md-4">
                            <label for="">Fecha</label>
                            <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control"
                                placeholder="Fecha">
                        </div>
                        <div class="col-md-4">
                            <label for="">Nota</label>
                            <textarea name="nota" id="nota" cols="40" rows="2"
                                placeholder="Equivalente de cada producto"></textarea>
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
            </form>
        </div>
    </div>

</div>
{{-- </div> --}}

<div class="card card-listado" id="listadoUsers">
    <div class="card-header text-center bg-dark">
        <h4> Listado de ingredientes</h4>
    </div>
    <div class="card-body">

        <table id="users" class="table table-bordered table-hover datatables" style="width: 100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Disponible</th>
                    <th>Costo</th>
                    <th>Fecha ingreso</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody class="text-white font-weight-bold"></tbody>
            <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Disponible</th>
                    <th>Costo</th>
                    <th>Fecha ingreso</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
    </div>

</div>



@include('adminlte/scripts')
<script src="{{asset('js/ingredientes/ingrediente.js')}}"></script>

@endsection