<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MN Express Livraison</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
  @yield('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>

      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->nomComplet }}
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Déconnexion') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">MN Express Livraison</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->nomComplet}}</a>
        </div>
      </div>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
              @if (Auth::user()->role == 'admin')
              <li class="nav-item has-treeview menu-open">
              <a href="{{ route('toutColis') }}" class="nav-link @yield('toutColis')">
                <i class="nav-icon fas fa-box-open"></i>
                <p>
                  Colis
                </p>
              </a>
              </li>
              @endif
              {{-- <li class="nav-item has-treeview menu-open">
                <a href="{{ route('stock') }}" class="nav-link @yield('stock')">
                  <i class="nav-icon fas fa-cubes"></i>
                  <p>
                    Stock
                  </p>
                </a>
              </li>--}}
              @if (Auth::user()->role == 'admin')
              <li class="nav-item has-treeview menu-open">
                <a href="{{ route('Reception') }}" class="nav-link @yield('Reception')">
                  <i class="nav-icon fas fa-inbox"></i>
                  <p>
                    Reception Colis
                  </p>
                </a>
              </li>
              @endif
              @if (Auth::user()->role == 'client')
              <li class="nav-item has-treeview menu-open">
                <a href="{{ route('home') }}" class="nav-link @yield('home')">
                  <i class="nav-icon fas fa-home"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link @yield('colis')">
                  <i class="nav-icon fas fa-box-open"></i>
                  <p>
                  Colis
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('newColis') }}" class="nav-link @yield('nouveauColis')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Nouveau colis</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('colis') }}" class="nav-link  @yield('mesColis')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Mes Colis</p>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="{{ route('retour') }}" class="nav-link  @yield('retour')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>En Retour</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('refuses') }}" class="nav-link  @yield('refuses')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Refuses</p>
                    </a>
                  </li> --}}
                </ul>
              </li> 
              @endif
              @if (Auth::user()->role == 'client')
              <li class="nav-item has-treeview menu-open">
                <a href="{{ route('bonsLivraion') }}" class="nav-link @yield('livraison')">
                  <i class="nav-icon fas fa-file-signature"></i>
                  <p>
                    Bons de Livraison
                  </p>
                </a>
              </li>
              @endif
              @if (Auth::user()->role == 'client')
              <li class="nav-item has-treeview menu-open">
                <a href="{{ route('stock') }}" class="nav-link @yield('stock')">
                  <i class="nav-icon fas fa-cubes"></i>
                  <p>
                    Gestion de Stock
                  </p>
                </a>
              </li>
              @endif
              @if (Auth::user()->role == 'admin')
              <li class="nav-item has-treeview menu-open">
                <a href="{{ route('Envoi') }}" class="nav-link @yield('Envoi')">
                  <i class="nav-icon fas fa-paper-plane"></i>
                  <p>
                    Bons d'envoie
                  </p>
                </a>
              </li> 
              <li class="nav-item has-treeview menu-open">
                <a href="{{ route('Distribution') }}" class="nav-link @yield('Distribution')">
                  <i class="nav-icon fas fa-cubes"></i>
                  <p>
                    Bons distribution
                  </p>
                </a>
              </li> 


              {{-- <li class="nav-item has-treeview menu-open">
                <a href="{{ route('stock') }}" class="nav-link @yield('stock')">
                  <i class="nav-icon fas fa-cubes"></i>
                  <p>
                    Gestion de Stock
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('article') }}" class="nav-link @yield('article')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Nouveau Article</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('nouveauStock') }}" class="nav-link  @yield('nouveauStock')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Nouveau Stock</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('stock') }}" class="nav-link @yield('stock_actu')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Stock Actuel</p>
                    </a>
                  </li>
                  
                </ul>
              </li>  --}}
              @endif
              @if (Auth::user()->role == 'admin')
              <li class="nav-item has-treeview menu-open">
                <a href="{{ route('factures') }}" class="nav-link @yield('factures')">
                  <i class=" nav-icon fas fa-file-invoice"></i>
                  <p>
                   Factures
                  </p>
                </a>
              </li>
              <li class="nav-item has-treeview menu-open">
                <a href="{{ route('villes') }}" class="nav-link @yield('villes')">
                  {{-- <i class="nav-icon fas fa-home"></i> --}}
                  <i class="nav-icon fas fa-city"></i>
                  <p>
                    Régions et Villes
                  </p>
                </a>
              </li>

              <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link @yield('users')">
                  <i class="nav-icon fas fa-cubes"></i>
                  <p>
                    Les Utilisateurs
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('clients') }}" class="nav-link @yield('clients')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Les Clients</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('livreurs') }}" class="nav-link  @yield('livreurs')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Les Livreurs</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admins') }}" class="nav-link  @yield('admins')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Les Admins</p>
                    </a>
                  </li>
                </ul>
              </li> 
              @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-white">

    <!-- Content Header (Page header) -->

    <!-- Main content -->
   @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021-2022 <a href="www.soft.ma">YAN SOFT</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b>1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
@yield('script')
</body>
</html>
