<?php
    
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Tienda</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="index.php">Empresa</a>
        <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="my-nav" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link"
                        href="mostrarCarrito.php">Carrito(<?php echo (empty($_SESSION['CARRITO']))?0:count($_SESSION['CARRITO']); ?>)</a>
                </li>
            </ul>

            <?php
                if (empty($_SESSION['user'])):
            ?>

            <div id="g_id_onload"
                data-client_id="857374696865-48jkdksttcis670q2q7vgn7dsr5pordq.apps.googleusercontent.com"
                data-context="signin" data-login_uri="http://localhost/tienda/login.php" data-auto_select="true">
            </div>
            <a class="btn btn-primary" href="./login.php">Iniciar sesión</a>
            
            <?php
                else:
                    //echo "sdljsdljs";
                    $user = $_SESSION['user'];
                    //echo $user['picture'];
                    // $sql = $pdo->prepare("SELECT * FROM `users` WHERE token={$user['sub']}");
                    // $sql->execute();
                    // // $sql = "SELECT * FROM users WHERE token ={$user['sub']}";
                    // // $result = mysqli_query($conn, $sql);
                    // if($sql->fetchColumn() == 0) {                        
                    //     $sql_insert = $pdo->prepare("INSERT INTO users (email, first_name, last_name, full_name, picture, verifiedEmail, token) VALUES ('{$user['email']}', '{$user['given_name']}', '{$user['family_name']}', '{$user['name']}', '{$user['picture']}', '{$user['email_verified']}', '{$user['sub']}')");
                    //     $sql_insert->execute();
                    //     if($sql_insert->fetchColumn() == 0) {
                    //         echo "USER CREATED";
                    //     }else{
                    //         echo "USER NOT CREATED";
                    //     }
                    // }
            ?>

            <ul class="nav py-profile justify-content-end">
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle avatar" role="button"
                        aria-haspopup="true" aria-expanded="false" title="bhotopp">
                        <img src="<?= $user['picture']; ?>"
                            alt="" width="40" height="40">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="./profile.php" class="dropdown-item">Editar perfíl</a>                        
                        <div class="dropdown-divider"></div>
                        <a href="./logout.php" class="dropdown-item">Cerrar sesión</a>
                    </div>
                </li>
            </ul>

            <?php
                endif;
            ?>

        </div>
    </nav>
    <br />
    <br />
    <div class="container">