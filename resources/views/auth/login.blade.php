<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../img/3putra.png">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- my css -->
    <link rel="stylesheet" href="{{ asset('css/bg.css') }}">

    <title>TigaPutraNet</title>
</head>

<body>
    <div class="center">
        <h1>Login</h1>
        <form action="{{ route('login.create') }}" method="POST">
            @csrf
            <div class="txt_field">
                <input type="text" name="name" id="name" placeholder="Username">
            </div>

            <div class="txt_field position-relative">
                <input type="password" name="password" id="password" placeholder="Password">
                <span class="eye-icon position-absolute" id="togglePassword"
                    onclick="togglePasswordVisibility('password','eyeOffIcon','eyeIcon')">
                    <i data-feather="eye-off" id="eyeOffIcon"></i>
                    <i data-feather="eye" id="eyeIcon" class="eye"></i>
                </span>
            </div>

            <input type="submit">
            <div class="signup_link">
                Don't have account? <a href="{{ route('register') }}">Register</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/functions.js') }}"></script>
    <script>
        feather.replace()
    </script>

</body>

</html>
