<?php
    include 'global/config.php';
    include 'global/conexion.php';

    if (!empty($_POST['credential'])){
        if (empty($_COOKIE['g_csrf_token']) || empty($_POST['g_csrf_token']) || $_COOKIE['g_csrf_token'] != $_POST['g_csrf_token']){
            echo "ERROR";
            exit();
        }
        
        $clientId = "857374696865-48jkdksttcis670q2q7vgn7dsr5pordq.apps.googleusercontent.com";
        $client = new Google_Client(['client_id' => $clientId]);  // Specify the CLIENT_ID of the app that accesses the backend

        $idToken = $_POST['credential'];
        $user = $client->verifyIdToken($idToken);
        if ($user) {
            $_SESSION['user'] = $user;
            $url = $_SERVER['HTTP_REFERER'];
            if ($url && substr($url, 0, 23) == "http://localhost/tienda/" && $url != "http://localhost/tienda/login.php") {
                header('Location:' .$url);
            } else {
                header('Location: ./index.php');
            }
            exit();
        } else {
            echo "Error de autenticación";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Login</title>
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
    }

    .form-signin .checkbox {
        font-weight: 400;
    }

    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }

    .form-signin .form-control:focus {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>
</head>

<body class="text-center">
    <form class="form-signin">
        <div id="g_id_onload" data-client_id="857374696865-48jkdksttcis670q2q7vgn7dsr5pordq.apps.googleusercontent.com"
            data-login_uri="http://localhost/tienda/login.php" data-auto_prompt="false">
        </div>
        <div class="g_id_signin d-flex justify-content-center" data-type="standard" data-size="large"
            data-theme="filled_blue" data-text="sign_in_with" data-shape="rectangular" data-logo_alignment="left">
        </div>
        <h1 class="h3 mb-3 mt-3 font-weight-normal">Bienvenido!!!</h1>
        <label for="inputEmail" class="sr-only">Correo electrónico</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Recuerdamelo
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
    </form>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
</body>

</html>