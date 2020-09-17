@extends('adminlte.layout')

@section('seccion', 'Dashboard')

@section('title', 'Home')

@section('content')


<div class="row mt-2" style="backgroung-colod">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3 id="cant_orden"></h3>

        <p>Nuevas Ordenes Tomadas</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-cart"></i>
      </div>
      {{-- @if (Auth::user()->role == 1)
      <a href="/AlienYard/public/ordenes" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
      @endif --}}
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3 id="ordenes_proceso"></h3>

        <p>Ordenes en cocina</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-briefcase"></i>
      </div>
      {{-- @if (Auth::user()->role == 1)
      <a href="/AlienYard/public/ordenes" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
      @endif --}}
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3 id="ordenes_listas"></h3>

        <p>Ordenes Listas</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-restaurant"></i>
      </div>
      {{-- @if (Auth::user()->role == 1)
      <a href="/AlienYard/public/cobro" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
      @endif --}}
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3 id="ventaDeldia"><sup style="font-size: 20px"></sup></h3>

        <p>Ventas del dia</p>
      </div>
      <div class="icon">
        <i class="ion ion-cash"></i>
      </div>
      {{-- @if (Auth::user()->role == 1)
      <a href="/sistemaCCH/public/orden_pedido" class="small-box-footer">Ver más <i
          class="fas fa-arrow-circle-right"></i></a>
      @endif --}}
    </div>
  </div>
</div>
<!-- Main row -->
<div class="row  ml-1 mr-1">
  <!-- Left col -->
  <section class="col-md-7 connectedSortable">
    <!-- Custom tabs (Charts with tabs)-->
    @if (Auth::user()->role == 1)

    <div class="card card-default">
      <div class="card-header text-white header-chart">
        <h3 class="card-title">
          <i class="fas fa-exclamation-triangle"></i>
           Avisos
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-info"></i> Recuerde!</h5>
          <p class="p-alertas">En caso de dudas sobre el funcionamiento del sistema favor revisar el manual de usuario.</p> 
        </div>
        <div class="alert alert-info alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-info"></i> Aviso!</h5>
          <p class="p-alertas">Recuerde realizar una copia de seguridad al final de la jornada.</p> 
        </div>
      
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->


    <div class="card">
      <div class="card-header header-chart">
        <h3 class="card-title text-white">
          <i class="fas fa-chart-pie mr-1"></i>
          Ventas ultimos 12 meses
        </h3>
        <div class="card-tools">

        </div>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content p-0">
          <!-- Morris chart - Sales -->
          <div class="chart tab-pane active" id="revenue-chart">
            <canvas id="ventas12meses" width="400" height="300"></canvas>
          </div>
          <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
            <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
          </div>
        </div>
      </div><!-- /.card-body -->
    </div>
    @endif

    <!-- /.card -->
    <!-- TABLE: LATEST ORDERS -->
 

    <!-- TABLE: LATEST CORTES -->
    {{-- <div class="card ">
      <div class="card-header border-transparent text-black bg-gradient-primary">
        <h3 class="card-title">Ultimos cortes creados</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0 ">
        <div class="table-responsive">
          <table class="table m-0">
            <thead>
              <tr class="">
                <th>Corte ID</th>
                <th>Fase</th>
                <th>Producto</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody id="latest_cortes">

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer clearfix">
        <a href="/sistemaCCH/public/cortes" class="btn btn-sm btn-secondary float-right">Ver todos los cortes</a>
      </div>
      <!-- /.card-footer -->
    </div> --}}


    <!-- /.card -->
  </section>
  <!-- /.Left col -->
  <!-- right col (We are only adding the ID to make the widgets sortable)-->
  <section class="col-md-5 connectedSortable">

    <!-- Custom tabs (Charts with tabs)-->
    @if (Auth::user()->role == 1)
    <div class="card">
      <div class="card-header header-chart">
        <h3 class="card-title text-white">
          <i class="fas fa-chart-pie mr-1"></i>
          Ventas ultimos 10 dias
        </h3>
        <div class="card-tools">
          <ul class="nav nav-pills ml-auto">

          </ul>
        </div>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content p-0">
          <!-- Morris chart - Sales -->
          <div class="chart tab-pane active" id="revenue-chart">
            <canvas id="ventas10dias" width="400" height="300"></canvas>
          </div>
          <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
            <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
          </div>
        </div>
      </div><!-- /.card-body -->
    </div>
    <div class="card">
      <div class="card-header header-chart">
        <h3 class="card-title text-white"><i class="fas fa-warehouse"></i> Productos a reabastecer pronto</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <thead class="text-white">
              <tr>
                <th>Ingrediente</th>
                <th>Nota</th>
                <th>Disponible</th>
                <th>Fecha Ingreso</th>
              </tr>
            </thead>
            <tbody class="text-white" id="latest_orders" style="font-size: 16px;">


            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer clearfix">
        <a href="/AlienYard/public/consulta-inventario" class="btn btn-sm btn-secondary float-right">Reporte de
          inventario</a>
      </div>
      <!-- /.card-footer -->
    </div>
    @endif

    <!-- PRODUCT LIST -->
    {{-- <div class="card">
      <div class="card-header">
        <h3 class="card-title">Referencias creadas recientemente</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <ul class="products-list product-list-in-card pl-2 pr-2" id="productos">

        </ul>
      </div>
      <!-- /.card-body -->
      <div class="card-footer text-center">
        <a href="javascript:void(0)" class="uppercase">Ver todos los productos</a>
      </div>
      <!-- /.card-footer -->
    </div> --}}

  </section>
  <!-- right col -->
</div>




@include('adminlte/scripts')
<script src="js/dashboard.js"></script>



@endsection