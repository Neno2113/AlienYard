@extends('adminlte.layout')

@section('seccion', 'Usuarios')

@section('title', 'Manejo de usuarios')

@section('content')
{{-- <div class="container"> --}}
<div class="row mt-3 ml-3">
    <button class="btn btn-primary mb-3 " id="btnAgregar"><i class="fas fa-user-plus"></i> Agregar</button>
    {{-- <button class="btn btn-danger mb-3 " id="btnCancelar"><i class="fas fa-window-close"></i></button> --}}
</div>

<div class="row ">
    <div class="col-md-12">
        <div class="card mb-3" id="registroForm">
            <div class="card-header text-center bg-dark">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                            class="fas fa-remove"></i></button>
                </div>
                <h4>Registro de usuario</h4>
            </div>
            <div class="card-body">
                <form action="" id="formulario" class="form-group carta panel-body">
                    {{-- <h5 class="font-weight-bold text-center text-white">Formulario de registro de Usuarios</h5> --}}
                    <hr>
                    <div class="row ">
                        <div class="col-md-4">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" placeholder="Nombre" id="name" class="form-control" pattern="[a-zA-Z]">
                            @if ($errors->has('name'))
                            <div class="error">{{ $errors->name('name') }}</div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label for="surname">Apellido</label>
                            <input type="text" name="surname" placeholder="Apellido"  id="surname" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="edad">Edad</label>
                            <input type="text" name="edad" placeholder="Edad" id="edad" class="form-control text-center" ]
                                data-inputmask='"mask": "99"' data-mask>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <label for="name">Telefono</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" placeholder="Telfono" id="telefono" class="form-control"
                                    data-inputmask='"mask": "(999) 999-9999"' data-mask>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="celular">Celular</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" id="celular" placeholder="Celular" class="form-control"
                                    data-inputmask='"mask": "(999) 999-9999"' data-mask>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="direccion">Direccion</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                </div>
                                <input type="text" id="direccion" placeholder="Direccio" class="form-control">
                            </div>

                        </div>
                    </div>
                    {{-- <h5 class="text-center mt-4 font-weight-bold text-white">Datos de acceso</h5> --}}
                    <hr>
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <label for="name">Email</label>
                            <input type="Email" name="email" placeholder="Email" id="email" class="form-control">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="name">Nombre Usuario</label>
                            <input type="text" name="username" id="username" placeholder="Nombre de usuario" class="form-control">
                        </div>
                        <div class="col-md-4 mt-3" id="ver-contra">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" placeholder="Contraseña" class="form-control">
                        </div>
                        
                    </div>
                </form>
                <div class="row mt-3" id="avatar">
                    <div class="col-md-4">
                        <form action="" method="POST" id="formUpload" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputFile">Avatar</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="avatar" id="avatar">
                                        <input type="hidden" name="avatar_name" id="avatar_name">
                                        <label class="custom-file-label" for="exampleInputFile">Elegir imagen...</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text" id="btn-upload">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
              

                    <div class="col-md-4 ">
                        <label for="name">Rol:</label>
                        <select name="" id="role" class="form-control">
                            <option value="General"></option>
                            <option value="1">Adminitrador</option>
                            <option value="2">Mesero</option>
                            <option value="3">Cocinero</option>
                            <option value="4">General</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <ul class="error" id="error">

                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-footer  text-muted ">
                <button class="btn  btn-danger mt-1" id="btnCancelar"><i class="fas fa-arrow-alt-circle-left fa-lg"></i>
                    Cancelar</button>
                <button type="button" id="btn-guardar" class="btn btn-primary mt-1 float-right"><i
                        class="far fa-save fa-lg"></i> Guardar</button>
                <button type="submit" id="btn-edit" class="btn btn-warning mt-1 float-right"><i
                        class="far fa-edit fa-lg"></i> Editar</button>

            </div>

        </div>
    </div>
    {{-- <div class="col-md-4">
        <div class="card  mb-3" id="permisoForm">
            <div class="card-header text-center ">
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
                    <h5>Asignacion de permisos:</h5>
                    <hr>

            </div>
            <div class="card-footer  text-muted ">

                <button type="submit" id="btn-guardar" class="btn btn-info mt-1 float-right"><i
                        class="far fa-save fa-lg"></i> Guardar</button>


            </div>
            </form>
        </div>
    </div> --}}
</div>
{{-- </div> --}}

<div class="card card-listado" id="listadoUsers">
    <div class="card-header text-center bg-dark">
        <h4> Listado de usuarios</h4>
    </div>
    <div class="card-body">

        <table id="users" class="table table-bordered table-hover datatables" style="width: 100%">
            <thead>
                <tr>
                    <th></th>
                  
                    <th>Actions</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Edad</th>
                    <th>Celular</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th></th>
                   
                    <th>Actions</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Edad</th>
                    <th>Celular</th>
                </tr>
            </tfoot>
        </table>
    </div>

</div>



@include('adminlte/scripts')
<script src="{{asset('js/user/user.js')}}"></script>

@endsection