<<<<<<< HEAD
<?php include "connect.php"; ?>




<?php
if($_POST){
    $user = $_POST['user'];
    $pass = $_POST['password'];
    $objconexion = new Connect();
    $sql = "SELECT * FROM `usuarios` WHERE `nombre` = '".$_POST['user']."' AND `contrasena` = '".$_POST['password']."'";
    $consulta = $objconexion->consultar($sql);

    if(($user=='Admin' && $pass=='Admin123')){
        session_start();
        $_SESSION['Admin']='Admin';
        header("location:admin.php");
    }else if(count($consulta) > 0){
        session_start();
        $_SESSION['user']= "User";
        header("location:index.php");
    }else{
        echo "<script>alert('error');</script>";
    }
}

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h3 class="card-title text-center mb-4">Iniciar Sesión</h3>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="text" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="user"  required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="recordar">
                                <label class="form-check-label" for="recordar">Recordar sesión</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                            <div class="text-center mt-3">
                                <a href="register.php" class="text-decoration-none">¿No tienes cuenta? Regístrate</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>










    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
=======
<?php include "connect.php"; ?>




<?php
if($_POST){
    $user = $_POST['user'];
    $pass = $_POST['password'];
    $objconexion = new Connect();
    $sql = "SELECT * FROM `usuarios` WHERE `nombre` = '".$_POST['user']."' AND `contrasena` = '".$_POST['password']."'";
    $consulta = $objconexion->consultar($sql);

    if(($user=='Admin' && $pass=='Admin123')){
        session_start();
        $_SESSION['Admin']='Admin';
        header("location:admin.php");
    }else if(count($consulta) > 0){
        session_start();
        $_SESSION['user']= "User";
        header("location:index.php");
    }else{
        echo "<script>alert('error');</script>";
    }
}

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h3 class="card-title text-center mb-4">Iniciar Sesión</h3>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="text" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="user"  required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="recordar">
                                <label class="form-check-label" for="recordar">Recordar sesión</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                            <div class="text-center mt-3">
                                <a href="register.php" class="text-decoration-none">¿No tienes cuenta? Regístrate</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>










    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
>>>>>>> bd9cae4598b15a47091906aae594b1af9e1b6164
</html>