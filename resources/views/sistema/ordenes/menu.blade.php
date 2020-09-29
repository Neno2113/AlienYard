@extends('adminlte.layout')

@section('seccion', 'Ordenes')

@section('title', 'Menú')

@section('content')

<div id="listadoUsers">
  <div class="card card-solid">
    <div class="card-body pb-0 carta-menu">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="page-header">
              <h1 class="text-center" style="color: #fff;">Menú</h1>
            </div>
            {{-- <hr class="menuLineUp"> --}}
          </div>
        </div>


        <ul class="nav nav-pills" id="myTab" role="tablist">
          <div class="" style="margin-right: 561px;" >
            <button class="btn btn-danger mb-3 mr-4 " id="btnAgregar"><i class="fas fa-utensils"></i> Tomar
              Pedido</button>
          </div>
          {{-- <hr> --}}
        </ul>

        <div class="tab-content" id="myTabContent">
          

        </div>
      </div>
    </div>
  </div>
  {{-- <nav aria-label="Page navigation example">
    <hr>
    <ul class="pagination justify-content-end">
      <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
      </li>
      <div id="paginas">

      </div>

      <li class="page-item">
        <a class="page-link" id="next-page" href="">Next</a>
      </li>
    </ul>
  </nav> --}}
</div>

<div id="registroForm">
  <div class="row">
    <div class="col-12">
      <div class="card  mb-3">
        <div class="card-header text-center bg-dark">
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
          </div>
          <h4>Orden</h4>
        </div>
        <div class="card-body">
          <div class="row" id="producto-div">
            <input type="hidden" name="numeroOrden" id="numeroOrden">
            <input type="hidden" name="orden_id" id="orden_id">
            {{-- <div class="col-md-4">
              <label for="">Metodo de pago</label>
              <select name="metodo_pago" id="metodo_pago" class="form-control select2">
                <option value="" disabled>Elige un metodo de pago</option>
              </select>
            </div> --}}

            <div class="col-md-6">
              <label for="">Canal</label>
              <select name="canal" id="canal" class="form-control select2">
                <option value="" disabled>Elige un canal</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="">Entrega</label>
              <select name="delivery" id="delivery" class="form-control">
                <option value="" disabled>Elige una opcion de servir el plato </option>
                <option value="001" >Para comer aqui</option>
                <option value="002" >Para llevar</option>
                <option value="003" >Delivery</option>
                <option  ></option>
              </select>
            </div>

          </div>






        </div>
        <div class="card-footer  text-muted ">
          <button class="btn  btn-danger mt-1" id="btnCancelar"><i class="fas fa-arrow-alt-circle-left fa-lg"></i>
            Cancelar</button>
          <button type="submit" id="btn-guardar" class="btn btn-primary mt-1 float-right"><i
              class="fas fa-clipboard-check fa-lg"></i>
            Crear</button>
          <button type="submit" id="btn-edit" class="btn btn-warning mt-1 float-right"><i class="far fa-edit fa-lg"></i>
            Editar</button>

        </div>

      </div>
    </div>

  </div>
</div>




<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="ingredientes" class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
        {{-- <button type="button" class="btn btn-primary"></button> --}}
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-comentarios-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Comentarios Pedido <span id="nombre_plato" class="font-weight-bold"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="" class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="card bg-dark">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                  Terminos de la carne
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" id="terminosCarne">
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" name="termino" type="checkbox" id="customCheckbox2"
                      value="Carne: Termino medio">
                    <label for="customCheckbox2" class="custom-control-label">Termino medio</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" name="termino" type="checkbox" id="customCheckbox3"
                      value="Carne: Tres cuartos">
                    <label for="customCheckbox3" class="custom-control-label">Tres cuartos</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" name="termino" type="checkbox" id="customCheckbox4"
                      value="Carne: Bien cocida">
                    <label for="customCheckbox4" class="custom-control-label">Bien cocida</label>
                  </div>

                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-6">
            <div class="card bg-dark">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                  Entrega del plato
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" id="terminosCarne">
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="entrega" id="entrega1"
                      value="001">
                    <label for="entrega1" class="custom-control-label">Para comer aqui</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" name="entrega" type="checkbox" id="entrega2"
                      value="002">
                    <label for="entrega2" class="custom-control-label">Para llevar</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" name="entrega" type="checkbox" id="entrega3"
                      value="003">
                    <label for="entrega3" class="custom-control-label">Delivery</label>
                  </div>
               
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
     
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card bg-dark">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                  Eliminar ingredientes del plato
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" id="recetaProducto">
                  {{-- <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="termino1" id="customCheckbox1"
                      value="Termino rojo o crudo">
                    <label for="customCheckbox1" class="custom-control-label">Termino rojo o crudo</label>
                  </div>
              --}}

                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
         
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Comentarios</label>
              <textarea class="form-control" rows="1" id="comentario"
                placeholder="Escriba un comentario aqui..."></textarea>
            </div>
          </div>

        </div>
        <div class="row justify-content-end">
          <button type="button" class="btn btn-info mr-3" id="btnComment"><i class="far fa-comment"></i>
            Comentar</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times fa-lg"></i></button>

      </div>
    </div>

  </div>
</div>
</div>







@include('adminlte/scripts')
<script src="{{asset('js/ordenes/menu.js')}}"></script>

@endsection

@section('orden')
<h4 class="text-center font-weight-bold">Pedido</h4>
<hr class="mb-2">
<div class="">
  <h5 class="text-center bg-warning">Pedido #<strong id="pNorden"></strong></h5>

  <div class="color-palette-set" id="">
    <div class="bg-warning color-palette"><strong>Canal: </strong><span id="pCanal"> </span></div>
    <input type="hidden" name="pedido" id="pedido">
    <div class="bg-warning color-palette"><strong>Creado Por: </strong><span id="pUser"> </span></div>
    <div class="bg-warning color-palette"><strong>Metodo de pago: </strong><span id="pMetodo"> </span></div>
    <div id="pedidoProductos">

    </div>
    {{-- <div class="bg-warning color-palette"><strong>Canal:</strong><span>  Personal</span></div>
      <div class="bg-warning color-palette"><strong>Canal:</strong><span>  Personal</span></div> --}}
    {{-- <div class="bg-warning disabled color-palette text-center"><span><Strong id="pProducto"></Strong></span></div>
    <div class="bg-warning  color-palette">
      <div class="btn-group d-flex justify-content-center" role="group" aria-label="Basic example">
        <button type="button" id="btn-eliminar" class="btn btn-primary"><i class="fas fa-align-justify"></i></button>
        <button type="button" class="btn btn-warning"></button>
        <button type="button" id="btn-delProducto" class="btn btn-danger"><i class="far fa-minus-square"></i></button>
      </div>
    </div> --}}
  </div>
</div>
<button type="button" id="btn-save" class="btn btn-primary btn-block btn-sm"><i class="far fa-save fa-lg"></i></button>


@endsection