<<<<<<< HEAD
<?php include "connect.php" ?>

<?php 
$objconexion = new Connect();
if(isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['categoria'])){
    session_start();
    $_SESSION['Admin'] = "Admin";
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $director = $_POST['director'];
    $duracion = $_POST['duracion'];
    $reparto = $_POST['reparto'];
    $fecha = new DateTime();
    $imagen = $fecha->getTimestamp()."-".$_FILES['imagen']['name'];
    $imagen_temporal = $_FILES['imagen']['tmp_name'];
    move_uploaded_file($imagen_temporal,"imgs/".$imagen);
    $sql = "INSERT INTO `pelicula` (`id`, `nombre`, `descripcion`, `ruta`, `accion`,`duracion`,`reparto`,`director`) VALUES (NULL, '$nombre', '$descripcion', '$imagen', '$categoria','$duracion','$reparto','$director');";
    $objconexion->ejecutar($sql);
    header("location:admin.php");
}
    if($_GET){
    $id = $_GET['borrar'];
    $objconexion = new connect();
    $imagen=$objconexion->consultar("SELECT ruta FROM `pelicula` WHERE id=".$id);
    unlink("imgs/".$imagen[0]['ruta']);
    $sql = "DELETE FROM pelicula WHERE `pelicula`.`id` = ".$id;
    $objconexion->ejecutar($sql);
    header("location:admin.php");
}
if(isset($_POST['guardar_destacados'])) {
    $objconexion->ejecutar("UPDATE pelicula SET destacado = 0");
    if(isset($_POST['destacado'])) {
        foreach($_POST['destacado'] as $id) {
            $sql = "UPDATE pelicula SET destacado = 1 WHERE id = " . intval($id);
            $objconexion->ejecutar($sql);
        }
    }
    header("location:admin.php");
}
$peliculas = $objconexion->consultar("SELECT * FROM `pelicula`");
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestión de Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Panel de Administración</a>
            <div>
                <a href="index.php" class="btn btn-secondary">Ver Catálogo</a>
                <a href="login.php" class="btn btn-outline-light">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <!-- Formulario para agregar películas -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Agregar Nueva Película</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" name="imagen" id="imagen" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select class="form-select" name="categoria" id="categoria" required>
                                    <option value="Acción">Acción</option>
                                    <option value="Aventura">Aventura</option>
                                    <option value="Comedia">Comedia</option>
                                    <option value="Drama">Drama</option>
                                    <option value="Terror">Terror</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                    <label for="director" class="form-label">Director</label>
                                    <input type="text" class="form-control" name="director" id="director" required>
                                </div>
                                <div class="mb-3">
                                    <label for="duracion" class="form-label">Duración (ej: 2h 30min)</label>
                                    <input type="text" class="form-control" name="duracion" id="duracion" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reparto" class="form-label">Reparto Principal</label>
                                    <textarea class="form-control" name="reparto" id="reparto" rows="2" required></textarea>
                                </div>
                            <button type="submit" class="btn btn-primary">Agregar Película</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de películas -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Películas Registradas</h5>
                        <button type="submit" form="form-destacados" name="guardar_destacados" class="btn btn-success btn-sm">
                Guardar Destacados
            </button>
                    </div>
                    
                    <div class="card-body">
                        <form id="form-destacados" method="post">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Imagen</th>
                                    <th>Director</th>
                                    <th>Duracion</th>
                                    <th>Reparto</th>
                                    <th>Destacadas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($peliculas as $pelicula) { ?>
                                <tr>
                                    <td><?php echo $pelicula['nombre']; ?></td>
                                    <td><?php echo $pelicula['accion']; ?></td>
                                    <td>
                                        <img width="100" src="imgs/<?php echo $pelicula['ruta']; ?>" alt="">
                                    </td>
                                    <td><?php echo $pelicula['director']; ?></td>
                                    <td><?php echo $pelicula['duracion']; ?></td>
                                    <td><?php echo $pelicula['reparto']; ?></td>
                                    <td><input class="form-check-input" 
                                       type="checkbox" 
                                       name="destacado[]"  
                                       value="<?php echo $pelicula['id']; ?>" 
                                       id="destacado_<?php echo $pelicula['id']; ?>"
                                       <?php echo ($pelicula['destacado'] == 1) ? 'checked' : ''; ?>>
                                    <td>
                                        <a href="?borrar=<?php echo $pelicula['id']; ?>" 
                                           class="btn btn-danger btn-sm">
                                            Eliminar </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
=======
<?php include "connect.php" ?>

<?php 
$objconexion = new Connect();
if(isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['categoria'])){
    session_start();
    $_SESSION['Admin'] = "Admin";
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $director = $_POST['director'];
    $duracion = $_POST['duracion'];
    $reparto = $_POST['reparto'];
    $fecha = new DateTime();
    $imagen = $fecha->getTimestamp()."-".$_FILES['imagen']['name'];
    $imagen_temporal = $_FILES['imagen']['tmp_name'];
    move_uploaded_file($imagen_temporal,"imgs/".$imagen);
    $sql = "INSERT INTO `pelicula` (`id`, `nombre`, `descripcion`, `ruta`, `accion`,`duracion`,`reparto`,`director`) VALUES (NULL, '$nombre', '$descripcion', '$imagen', '$categoria','$duracion','$reparto','$director');";
    $objconexion->ejecutar($sql);
    header("location:admin.php");
}
    if($_GET){
    $id = $_GET['borrar'];
    $objconexion = new connect();
    $imagen=$objconexion->consultar("SELECT ruta FROM `pelicula` WHERE id=".$id);
    unlink("imgs/".$imagen[0]['ruta']);
    $sql = "DELETE FROM pelicula WHERE `pelicula`.`id` = ".$id;
    $objconexion->ejecutar($sql);
    header("location:admin.php");
}
if(isset($_POST['guardar_destacados'])) {
    $objconexion->ejecutar("UPDATE pelicula SET destacado = 0");
    if(isset($_POST['destacado'])) {
        foreach($_POST['destacado'] as $id) {
            $sql = "UPDATE pelicula SET destacado = 1 WHERE id = " . intval($id);
            $objconexion->ejecutar($sql);
        }
    }
    header("location:admin.php");
}
$peliculas = $objconexion->consultar("SELECT * FROM `pelicula`");
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestión de Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Panel de Administración</a>
            <div>
                <a href="index.php" class="btn btn-secondary">Ver Catálogo</a>
                <a href="login.php" class="btn btn-outline-light">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <!-- Formulario para agregar películas -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Agregar Nueva Película</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" name="imagen" id="imagen" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select class="form-select" name="categoria" id="categoria" required>
                                    <option value="Acción">Acción</option>
                                    <option value="Aventura">Aventura</option>
                                    <option value="Comedia">Comedia</option>
                                    <option value="Drama">Drama</option>
                                    <option value="Terror">Terror</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                    <label for="director" class="form-label">Director</label>
                                    <input type="text" class="form-control" name="director" id="director" required>
                                </div>
                                <div class="mb-3">
                                    <label for="duracion" class="form-label">Duración (ej: 2h 30min)</label>
                                    <input type="text" class="form-control" name="duracion" id="duracion" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reparto" class="form-label">Reparto Principal</label>
                                    <textarea class="form-control" name="reparto" id="reparto" rows="2" required></textarea>
                                </div>
                            <button type="submit" class="btn btn-primary">Agregar Película</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de películas -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Películas Registradas</h5>
                        <button type="submit" form="form-destacados" name="guardar_destacados" class="btn btn-success btn-sm">
                Guardar Destacados
            </button>
                    </div>
                    
                    <div class="card-body">
                        <form id="form-destacados" method="post">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Imagen</th>
                                    <th>Director</th>
                                    <th>Duracion</th>
                                    <th>Reparto</th>
                                    <th>Destacadas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($peliculas as $pelicula) { ?>
                                <tr>
                                    <td><?php echo $pelicula['nombre']; ?></td>
                                    <td><?php echo $pelicula['accion']; ?></td>
                                    <td>
                                        <img width="100" src="imgs/<?php echo $pelicula['ruta']; ?>" alt="">
                                    </td>
                                    <td><?php echo $pelicula['director']; ?></td>
                                    <td><?php echo $pelicula['duracion']; ?></td>
                                    <td><?php echo $pelicula['reparto']; ?></td>
                                    <td><input class="form-check-input" 
                                       type="checkbox" 
                                       name="destacado[]"  
                                       value="<?php echo $pelicula['id']; ?>" 
                                       id="destacado_<?php echo $pelicula['id']; ?>"
                                       <?php echo ($pelicula['destacado'] == 1) ? 'checked' : ''; ?>>
                                    <td>
                                        <a href="?borrar=<?php echo $pelicula['id']; ?>" 
                                           class="btn btn-danger btn-sm">
                                            Eliminar </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
>>>>>>> bd9cae4598b15a47091906aae594b1af9e1b6164
</html>