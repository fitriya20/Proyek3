<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title }}</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('public/template/main.css') }}"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('template/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('template/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ asset('template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" href="{{ asset('template/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('template/js/select.dataTables.min.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('template/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('template/images/favicon.png') }}" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.html">Obatin</a>
        <a class="navbar-brand brand-logo-mini" href="index.html">Ob</a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>        
        <ul class="navbar-nav navbar-nav-right">          
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              {{-- <img src="{{ asset('template/images/faces/face28.jpg') }}" alt="profile"/> --}}
              {{ auth()->user()->nama }} &nbsp;&nbsp;&nbsp; <i class="ti-angle-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">              
              <a class="dropdown-item" href="{{ route('logout') }}">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>          
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">     
      <!-- partial:partials/_sidebar.html -->
      @include('layouts.sidebar')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">        
            @yield('content')
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright Obatin © {{ date('Y') }}.</span>
          </div>          
        </footer> 
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>   
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <div class="modal-content">        
        <div class="modal-body py-3">
            <h4 class="font-weight-bold text-center">Anda yakin ingin menghapus data ini?</h4>
            <div class="d-flex justify-content-center mt-4">
              <button type="button" onclick="" id="btn-delete-modals" class="btn btn-sm rounded-sm btn-danger mr-1">Hapus</button>
              <button type="button" class="btn btn-sm rounded-sm text-white btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>        
    </div>
    </div>
</div>
  @yield('modals')


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <script src="{{ asset('template/vendors/js/vendor.bundle.base.js') }}"></script>

  <script src="{{ asset('template/vendors/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('template/vendors/datatables.net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('template/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('template/js/dataTables.select.min.js') }}"></script>
  <!-- End plugin js for this page --> 
  @include('layouts.script')
  @yield('script')

</body>

</html>

