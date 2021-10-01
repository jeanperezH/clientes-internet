<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Gestión Internet</title>

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/style.css" rel="stylesheet">

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
  <div id="app">
    <header class="app-header navbar bg-dark">
      <a class="navbar-brand mr-1" href="#">Harry Perez</a>
      
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="fas fa-bars"></span>
      </button>
      <ul class="nav navbar-nav d-md-down-none">
          <li class="nav-item px-3">
              <a class="nav-link" href="#">Escritorio</a>
          </li>
          
      </ul>
      <ul class="nav navbar-nav ml-auto">
          <li class="nav-item d-md-down-none">
              <a class="nav-link" href="#" data-toggle="dropdown">
                  <i class="icon-bell"></i>
                  <span class="badge badge-pill badge-danger">5</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                  <div class="dropdown-header text-center">
                      <strong>Notificaciones</strong>
                  </div>
                  <a class="dropdown-item" href="#">
                      <i class="fa fa-envelope-o"></i> Cobros
                      <span class="badge badge-success">3</span>
                  </a>
                  <a class="dropdown-item" href="#">
                      <i class="fa fa-tasks"></i> Pagos
                      <span class="badge badge-danger">2</span>
                  </a>
              </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                  <img src="vendors/img/avatars/h.png" class="img-avatar" alt="admin@bootstrapmaster.com">
                  <span class="d-md-down-none">Admin </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                  <div class="dropdown-header text-center">
                      <strong>Cuenta</strong>
                  </div>
                  <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Perfil</a>
                  <a class="dropdown-item" href="#"><i class="fa fa-lock"></i> Cerrar sesión</a>
              </div>
          </li>
      </ul>
    </header>


    <div class="app-body">

      
      @include('sidebar.sidebar')
      <!-- Contenido-->
      @yield('contenido')
      <!-- end contenido -->
    </div>
    
  </div>
  <!-- /#wrapper -->
  <footer class="app-footer">
    <span><a href="#">J34N</a> &copy; 2021</span>
    <span class="ml-auto">Desarrollado por <a href="#">J3</a></span>
  </footer>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <script src="js/estilos.js"></script>
  <script src="js/app.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/pace.min.js"></script>
  <script src="js/iconos.js"></script>
  <script src="js/sweetalert2.all.js"></script>

</body>

</html>