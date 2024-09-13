<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - Obatin</title>
  <!-- plugins:css -->
   
  <link rel="stylesheet" href="{{ asset('public/template/main.css') }}"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('template/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('template/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('template/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('template/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('template/images/favicon.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo text-center my-3">
                <h2>Obatin</h2>
              </div>
              <h4 class="text-center">Silahkan login dengan username dan password anda.</h4>
              <form id="form-login" method="POST" action="{{ route(('login.process')) }}" class="pt-3">
                @csrf
                <div class="form-group">
                  <input type="username" class="form-control form-control-lg" id="username" name="username" placeholder="Username">
                  <div class="invalid-feedback username"></div>                    
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password">
                    <div class="invalid-feedback password"></div>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-login btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                </div>                                
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  
<script src="{{ asset('template/vendors/js/vendor.bundle.base.js') }}"></script>
  @include('layouts.script')

  <script>
      
        $(document).ready(function(){            
            $('#form-login').ajaxForm({
                beforeSend:() => {
                    $('#username').removeClass('is-invalid')
                    $('#password').removeClass('is-invalid')
                },
                uploadProgress: () => {
                    $('.auth-form-btn').attr('disabled',true)
                    $('.auth-form-btn').text('Harap tunggu...')
                },
                success: (res) => {
                    if ($.isEmptyObject(res.error)) {
                        window.location.href = "{{ route('dashboard') }}"               
                    }else{                            
                        $('.auth-form-btn').attr('disabled',false)
                        $('.auth-form-btn').text('SIGN IN')
                        printMsg(res.error)
                    }
                }
            })
        })
  </script>
</body>

</html>
