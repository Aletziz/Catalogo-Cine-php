<?php include "connect.php";?>
<?php
if($_POST){
    $usuario = $_POST['username'];
    $contrasenna = $_POST['password'];
    $objconexion = new Connect();
    $usuarioexistente = $objconexion->consultar("SELECT * FROM `usuarios` WHERE `nombre` = '$usuario'");
    if(count($usuarioexistente) > 0){
        echo "<script>alert('El usuario ya existe. Por favor, elige otro nombre.');</script>";
    }else{
        $sql = "INSERT INTO `usuarios` (`id`, `nombre`, `contrasena`) VALUES (NULL, '$usuario', '$contrasenna')";
        $objconexion->ejecutar($sql);
        header("location:login.php");
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h3 class="card-title text-center mb-4">Crear Cuenta</h3>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                            <div class="text-center mt-3">
                                <a href="login.php" class="text-decoration-none">¿Ya tienes cuenta? Inicia sesión</a>
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
</html>