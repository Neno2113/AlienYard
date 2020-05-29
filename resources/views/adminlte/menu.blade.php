<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{asset('/adminlte/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AlenYard</span>
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
        <a href="#" class="d-block">{{Auth::user()->name}} {{Auth::user()->surname}}</a>
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
              <a href="/AlienYard/public/home" class="nav-link">
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
              Usuarios
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/AlienYard/public/user" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Usuarios</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/AlienYard/public/permisos" class="nav-link">
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
              <a href="/AlienYard/public/categoria-ingredientes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categoria ingredientes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/AlienYard/public/ingredientes" class="nav-link">
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
              Producto
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/AlienYard/public/categoria-producto" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categoria</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/AlienYard/public/productos" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Producto</p>
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
              <a href="/AlienYard/public/menu" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/AlienYard/public/ordenes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ordenes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/AlienYard/public/cobro" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pago</p>
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
              <a href="/sistemaCCH/public/home" class="nav-link">
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
              Menu de acceso
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/AlienYard/public/user" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Usuarios</p>
              </a>
            </li>
            @if (Auth::user()->permisos()->where('permiso', 'Categoria ingredientes')->first())
            <li class="nav-item">
              <a href="/AlienYard/public/categoria-ingredientes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categoria ingredientes</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Ingredientes')->first())
            <li class="nav-item">
              <a href="/AlienYard/public/ingredientes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ingredientes</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Categoria producto')->first())
            <li class="nav-item">
              <a href="/AlienYard/public/categoria-producto" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categoria</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Producto')->first())
            <li class="nav-item">
              <a href="/AlienYard/public/productos" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Producto</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Menu')->first())
            <li class="nav-item">
              <a href="/AlienYard/public/menu" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Ordenes')->first())
            <li class="nav-item">
              <a href="/AlienYard/public/ordenes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ordenes</p>
              </a>
            </li>
            @endif
            @if (Auth::user()->permisos()->where('permiso', 'Pago')->first())
            <li class="nav-item">
              <a href="/AlienYard/public/cobro" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pago</p>
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