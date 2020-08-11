@extends('adminlte.layout')

@section('seccion', 'Usuario')

@section('title', 'Perfil de usuario')

@section('content')
{{-- <div class="container"> --}}
<div class="row mt-3 ml-3">
    {{-- <button class="btn btn-primary mb-3 " id="btnAgregar"><i class="fas fa-user-plus"></i> Agregar</button> --}}
    {{-- <button class="btn btn-danger mb-3 " id="btnCancelar"><i class="fas fa-window-close"></i></button> --}}
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">

                <!-- Profile Image -->
                <div class="card card-danger card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{URL('/avatar').'/'.Auth::user()->avatar}}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center text-white">{{Auth::user()->name}} {{Auth::user()->surname}}</h3>

                        <p class="text-center text-white">
                            @if (Auth::user()->role == 1)
                            Administrador
                            @elseif(Auth::user()->role == 2)
                            Mesero
                            @elseif(Auth::user()->role == 3)
                            Cocinero
                            @elseif(Auth::user()->role == 4)
                            Cajero
                            @elseif(Auth::user()->role == 5)
                            General
                            @endif
                        </p>

                        <ul class="list-group list-group mb-3">
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{Auth::user()->email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Username</b> <a class="float-right">{{Auth::user()->username}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Edad</b> <a class="float-right">{{Auth::user()->edad}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Dirección</b> <a class="float-right">{{Auth::user()->direccion}}</a>
                            </li>

                            <li class="list-group-item">
                                <b>Celular</b> <a class="float-right">{{Auth::user()->celular}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Telefono</b> <a class="float-right">{{Auth::user()->telefono}}</a>
                            </li>
                        </ul>

                        <button class="btn btn-danger btn-block"
                            onclick="mostrar({{Auth::user()->id}})"><b>Editar</b></button>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->


                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-danger p-2">

                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="" id="">
                            <form class="form-horizontal" id="formulario">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" placeholder="Name">
                                        <input type="hidden" name="id" id="id" value="">
                                        <input type="hidden" name="role" id="role" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Apellido</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="surname" placeholder="Surname">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Edad</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-center" id="edad" placeholder="Edad"
                                        data-inputmask='"mask": "99"' data-mask>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="username" placeholder="UserName">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">Contraseña</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Cel</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="celular" placeholder="Celular"
                                            data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                    </div>
                                    <label for="inputName2" class="col-sm-1 col-form-label">Tel</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="telefono" placeholder="Telefono"
                                            data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Direccion</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="direccion"
                                            placeholder="Direccion"></textarea>
                                    </div>
                                </div>
                            </form>
                            <div class="form-group row" id="avatar-form">
                                <label for="inputExperience" class="col-sm-2 col-form-label">Avatar</label>
                                <form action="" method="POST" id="formUpload" enctype="multipart/form-data">
                                    <div class="form-group col-sm-10">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="avatar" id="avatar">
                                                <input type="hidden" name="avatar_name" id="avatar_name">
                                                <label class="custom-file-label" for="exampleInputFile">Choose
                                                    file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button type="submit" class="input-group-text"
                                                    id="btn-upload">Subir</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            {{-- <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> I agree to the <a href="#">terms and
                                                    conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div> --}}
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" id="btn-edit" class="btn btn-danger">Guardar</button>
                                </div>
                            </div>

                        </div>
                        <div class="tab-content">

                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->







    @include('adminlte/scripts')
    <script src="{{asset('js/user/perfil.js')}}"></script>

    @endsection