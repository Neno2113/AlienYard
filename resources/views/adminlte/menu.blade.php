<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{URL('/adminlte/img/alienyardLogo.jpg')}}" alt="alienyard Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AlienYard</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{URL('/avatar').'/'.Auth::user()->avatar}}" id="test" class="img-circle elevation-2"
          alt="User Image">
      </div>
      <div class="info">
        <a href="/user-only" class="d-block">{{Auth::user()->name}} {{Auth::user()->surname}}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    @if (Auth::user()->role == "1")
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent " data-widget="treeview" role="menu"
        data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/home" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-users"></i>
            <p>
              Manejo de usuarios
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/user" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Crear, Editar, Eliminar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/user-only" class="nav-link" >
                <i class="far fa-circle nav-icon"></i>
                <p>Perfil</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/permisos" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Permisos</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-bacon"></i>
            <p>
              Ingredientes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/categoria-ingredientes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categoria</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/ingredientes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ingredientes</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-hamburger"></i>
            <p>
              Platos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/categoria-producto" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categoria</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/productos" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Platos</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-utensils"></i>
            <p>
              Ordenes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/menu" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Menú</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/ordenes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ordenes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/cobro" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pago</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-list-alt"></i>
            <p>
              Reportes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/consulta-orden" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ordenes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/consulta-facturas" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Facturas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/consulta-inventario" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inventario</p>
              </a>
            </li>
        
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-clone"></i>
            <p>
              Copias de seguridad
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href='/respaldos' class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Respaldos</p>
              </a>
            </li>
          
        
          </ul>
        </li>
    </nav>
    @elseif (Auth::user()->role != "1")
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent " data-widget="treeview" role="menu"
        data-accordion="false">

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/sistemaCCH/home" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="far fa-list-alt"></i>
            {{-- <li class="nav-header">CORTE Y FASES</li> --}}
            <p>
              Menú de acceso
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/user-only" class="nav-link" >
                <i class="far fa-circle nav-icon"></i>
                <p>Perfil</p>
              </a>
            </li>
            @if (Auth::user()->permisos()->where('permiso', 'Cat-ingredientes')->first())
            <li class="nav-item">
              <a href="/categoria-ingredientes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categoria ingredientes</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Ingredientes')->first())
            <li class="nav-item">
              <a href="/ingredientes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ingredientes</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Cat-platos')->first())
            <li class="nav-item">
              <a href="/categoria-producto" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categoria</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Platos')->first())
            <li class="nav-item">
              <a href="/productos" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Platos</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Menu')->first())
            <li class="nav-item">
              <a href="/menu" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Menú</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Cocina')->first())
            <li class="nav-item">
              <a href="/ordenes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ordenes</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Pago')->first())
            <li class="nav-item">
              <a href="/cobro" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pago</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Rep-ordenes')->first())
            <li class="nav-item">
              <a href="/consulta-orden" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte Ordenes</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Rep-facturas')->first())
            <li class="nav-item">
              <a href="/consulta-facturas" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte Facturas</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Rep-inventario')->first())
            <li class="nav-item">
              <a href="/consulta-inventario" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte Inventario</p>
              </a>
            </li>
            @endif
        </li>
      </ul>

      </ul>
    </nav>
    @endif
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>