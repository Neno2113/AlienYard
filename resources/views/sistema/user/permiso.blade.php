@extends('adminlte.layout')

@section('seccion', 'Usuarios')

@section('title', 'Permisos')

@section('content')
{{-- <div class="container"> --}}
<div class="row mt-3 ml-3">
    {{-- <button class="btn btn-primary mb-3 " id="btnAgregar"><i class="fas fa-user-plus"></i> Agregar </button> --}}
    {{-- <button class="btn btn-danger mb-3 " id="btnCancelar"><i class="fas fa-window-close"></i></button> --}}
</div>

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
                <h4>Permisos</h4>
            </div>
            <div class="card-body">
                <form action="" id="formulario" class="form-group carta panel-body">
                    <h5 class="text-white text-center font-weight-bold">Formulario de asignacion de permisos de acceso</h5>
                    <hr>
                    <div class="row" id="fila1">
                        <div class="col-md-5">
                            <label for="">Accesos</label>
                            <select name="tags[]" id="permisos" class="form-control select2">
                                {{-- <option disabled>DASHBOARD</option>
                                <option value="Dashboard">Dashboard</option>
                                <option  disabled>_______________________________________________________</option> --}}
                                <option disabled>USUARIOS</option>
                                <option value="Usuarios">Usuarios</option>
                                <option  disabled>_______________________________________________________</option>
                                <option disabled>Ingredientes</option>
                                <option value="Categoria ingredientes">Categoria</option>
                                <option value="Ingredientes">Ingredientes</option>
                                <option  disabled>_______________________________________________________</option>
                                <option disabled>Producto</option>
                                <option value="Categoria producto">Categoria</option>
                                <option value="Producto">Producto</option>
                                <option  disabled>_______________________________________________________</option>
                                <option disabled>Ordenes</option>
                                <option value="Menu">Menu</option>
                                <option value="Ordenes">Cocinero</option>
                                <option value="Pago">Cobros</option>
                            </select>
                        </div>
               
                        <div class="col-md-5">
                            <label for="">Usuario</label>
                            <select name="usuario" id="usuario" class="form-control select2">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-md-2 mt-4">
                            <button type="button" id="btn-agregar" name="btn-agregar" class="btn btn-dark mt-1"><i class="fas fa-key"></i> Agregar</button>
                        </div>
                    </div>
          
                  
                    <br>
                    <div class="row mt-4">
                        <table class="table table-bordered text-center text-white">
                            <thead class="text-center bg-dark">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Acceso</th>
                                    <th id="editar-permisos">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="permisos-agregados">

                            </tbody>
                        </table>
                    </div>


            </div>
            <div class="card-footer  text-muted ">
                <button class="btn  btn-danger mt-1" id="btnCancelar"><i class="fas fa-arrow-alt-circle-left fa-lg"></i> Cancelar</button>
                <button type="submit" id="btn-guardar" class="btn btn-primary mt-1 float-right"><i class="far fa-save fa-lg"></i> Guardar</button>
                <button type="submit" id="btn-edit" class="btn btn-warning mt-1 float-right"><i class="far fa-edit fa-lg"></i> Editar</button>

            </div>
            </form>
        </div>
    </div>
</div>
{{-- </div> --}}

<div class="card card-listado" id="listadoUsers">
    <div class="card-header text-center bg-dark">
        <h4 > Listado de usuarios</h4>
    </div>
    <div class="card-body">

        <table id="users" class="table table-bordered table-hover datatables" style="width: 100%" >
            <thead>
                <tr>
                    <th></th>
                    <th>Permisos</th>
                    <th>Nombre</th>
                    {{-- <th>Permiso</th> --}}
                    <th>Rol</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Permisos</th>
                    <th>Nombre</th>
                    {{-- <th>Permiso</th> --}}
                    <th>Rol</th>
                    <th>Email</th>
                </tr>
            </tfoot>
        </table>
    </div>

</div>



@include('adminlte/scripts')
<script src="{{asset('js/user/permiso.js')}}"></script>

<script>

</script>

@endsection
