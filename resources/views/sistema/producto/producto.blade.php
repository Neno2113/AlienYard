@extends('adminlte.layout')

@section('seccion', 'Producto')

@section('title', 'Recetas')

@section('content')
{{-- <div class="container"> --}}
<div class="row mt-3 ml-3">
    <button class="btn btn-primary mb-3 " id="btnAgregar"><i class="fas fa-plus-circle"></i> Agregar</button>
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
                <h4>Producto</h4>
            </div>
            <div class="card-body">
                <div class="row" id="producto-div">
                    <div class="col-md-4">
                        <label for="">Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="">Categoria</label>
                        <select name="categoria" id="categoria" class="form-control select2">
                            <option value="" disabled>Elige una categoria</option>
                        </select>
                        <input type="hidden" name="id" id="id">
                    </div>
               
                    <div class="col-md-4">
                        <label for="">Costo</label>
                        <input type="text" name="costo" id="costo" placeholder="Costo" class="form-control text-center"
                            data-inputmask='"mask": "RD$ 9[9[9[9]]]"' data-mask>
                    </div>

                </div>
                <div class="row mt-4 pl-2" id="vatar">
                    <form action="" method="POST" id="formUpload" enctype="multipart/form-data">
                        <div class="form-group">
                            {{-- <label for="exampleInputFile">Avatar</label> --}}
                         
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="form-control" name="producto_imagen" id="producto_imagen">
                                    <input type="hidden" name="image_name" id="image_name" value="">
                                    {{-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> --}}
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="btn-primary" id="btn-upload">
                                        <i class="fas fa-upload"></i> Subir</button>
                                </div>
                            </div>
                        </div>
                    </form>
                  
                </div>
           
                <div class="" id="button-div">
                    <hr>
                    <button type="button" class="btn btn-primary float-right" id="btn-crear"><i class="fas fa-plus"></i> Crear</button>
                </div>
                <div id="receta-div">
                    <div class="row mt-4" >
                        <div class="col-md-6">
                            <label for="">Categoria</label>
                            <input type="hidden" name="producto_id" id="producto_id">
                            <select name="ingrediente_cat" id="ingrediente_cat" class="form-control">
                                <option value="" >Elige un tipo de ingrediente</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Ingredientes</label>
                            <select name="ingrediente" id="ingrediente" class="form-control">
                                <option value="" disabled>Elige un ingrediente</option>
                            </select>
                        </div>
                     
                        
                    </div>
                    <div class="col-md-3 mt-4 pt-2">
                        <button type="button" id="btn-agregar" class="btn btn-primary "><i class="fas fa-plus-circle"></i> Agregar</button>
                    </div>
                    <div class="row mt-4">
                        <h5 class="">Receta</h5>
                        <hr>
                        <table class="table tabla-existencia table-bordered text-center" id="table-receta">
                            <thead class="text-center bg-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th>Ingredientes</th>
                                    <th id="editar-permisos">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="ingredientes">
    
                            </tbody>
                        </table>
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
    <div class="card-header text-center bg-dark">
        <h4> Listado de productos</h4>
    </div>
    <div class="card-body">

        <table id="users" class="table table-bordered table-hover datatables" style="width: 100%">
            <thead>
                <tr>
                    <th>Receta</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Costo</th>
                    <th>Actions</th>
                    <th>Estatus</th>

                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th>Receta</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Costo</th>
                    <th>Actions</th>
                    <th>Estatus</th>
                </tr>
            </tfoot>
        </table>
    </div>

</div>



@include('adminlte/scripts')
<script src="{{asset('js/producto/producto.js')}}"></script>

@endsection