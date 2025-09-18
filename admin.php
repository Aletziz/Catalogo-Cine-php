
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
if(isset($_GET['borrar'])){
    $id = intval($_GET['borrar']);
    $objconexion = new connect();
    $imagen=$objconexion->consultar("SELECT ruta FROM `pelicula` WHERE id=".$id);
    if($imagen && count($imagen) > 0) {
        unlink("imgs/".$imagen[0]['ruta']);
    }
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
if(isset($_POST['titulo_noticia']) && isset($_POST['descripcion_noticia'])) {
    $titulo_noticia = $_POST['titulo_noticia'];
    $descripcion_noticia = $_POST['descripcion_noticia'];
    $objconexion->ejecutar("INSERT INTO `news` (`id`, `titulo`, `descripcion`) VALUES (NULL, '$titulo_noticia', '$descripcion_noticia');");
    header("location:admin.php");
}
if(isset($_GET['borrar_noticia'])){
    $id_noticia = intval($_GET['borrar_noticia']);
    $objconexion = new connect();
    $objconexion->ejecutar("DELETE FROM news WHERE id = $id_noticia");
    header("location:admin.php");
}

$peliculas = $objconexion->consultar("SELECT * FROM pelicula ORDER BY id DESC");
$noticias = $objconexion->consultar("SELECT * FROM news ORDER BY id DESC");
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
                            <!-- Contenedor con scroll para la tabla -->
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem;">
                                <table class="table table-striped table-hover mb-0">
                                    <thead class="table-dark sticky-top">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Imagen</th>
                                            <th>Director</th>
                                            <th>Duración</th>
                                            <th>Reparto</th>
                                            <th>Destacada</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($peliculas)) { ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="fas fa-film fa-2x mb-2"></i><br>
                                                No hay películas registradas
                                            </td>
                                        </tr>
                                        <?php } else { ?>
                                            <?php foreach($peliculas as $pelicula) { ?>
                                            <tr>
                                                <td class="fw-bold"><?php echo htmlspecialchars($pelicula['nombre']); ?></td>
                                                <td>
                                                    <span class="badge bg-primary"><?php echo htmlspecialchars($pelicula['accion']); ?></span>
                                                </td>
                                                <td>
                                                    <img width="60" height="90" 
                                                         src="imgs/<?php echo htmlspecialchars($pelicula['ruta']); ?>" 
                                                         alt="<?php echo htmlspecialchars($pelicula['nombre']); ?>"
                                                         class="img-thumbnail" 
                                                         style="object-fit: cover;">
                                                </td>
                                                <td><?php echo htmlspecialchars($pelicula['director']); ?></td>
                                                <td>
                                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($pelicula['duracion']); ?> min</span>
                                                </td>
                                                <td class="text-truncate" style="max-width: 150px;" title="<?php echo htmlspecialchars($pelicula['reparto']); ?>">
                                                    <?php echo htmlspecialchars($pelicula['reparto']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               name="destacado[]"  
                                                               value="<?php echo $pelicula['id']; ?>" 
                                                               id="destacado_<?php echo $pelicula['id']; ?>"
                                                               <?php echo ($pelicula['destacado'] == 1) ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="destacado_<?php echo $pelicula['id']; ?>">
                                                            <i class="fas fa-star text-warning"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="?borrar=<?php echo $pelicula['id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('¿Estás seguro de eliminar esta película?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Información de películas -->
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Total de películas: <strong><?php echo count($peliculas); ?></strong>
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-scroll"></i>
                                    Desplázate para ver más películas
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sección de Noticias -->
        <div class="row mt-5">
            <!-- Formulario para agregar noticias -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Agregar Nueva Noticia</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="titulo_noticia" class="form-label">Título de la Noticia</label>
                                <input type="text" class="form-control" name="titulo_noticia" id="titulo_noticia" placeholder="Titulo de la noticia" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_noticia" class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion_noticia" id="descripcion_noticia" rows="4" placeholder="Escribe aquí la descripción de la noticia..." required></textarea>
                            </div>
                            <button type="submit" name="agregar_noticia" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Agregar Noticia
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Lista de noticias -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Noticias Publicadas</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <?php if(count($noticias) > 0){ ?>
                                <?php foreach($noticias as $noticia): ?>
                                <thead class="table-light">
                                    
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de noticias (aquí conectarás con tu base de datos) -->
                                    <tr>
                                        <td><?php echo $noticia['id'] ?></td>
                                        <td><?php echo $noticia['titulo'] ?></td>
                                        <td><?php echo $noticia['descripcion'] ?></td>
                                        <td>
                                            <a href="?borrar_noticia=<?php echo $noticia['id'] ?>" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash" data-id="<?php echo $noticia['id'] ?>"></i> Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php endforeach; ?>
                                <?php } ?>
                            </table>
                        </div>
                        
                        <!-- Mensaje cuando no hay noticias -->
                        <div class="text-center text-muted py-4" style="display: none;" id="no-noticias">
                            <i class="fas fa-newspaper fa-3x mb-3"></i>
                            <p>No hay noticias publicadas aún.</p>
                            <p class="small">Agrega tu primera noticia usando el formulario de la izquierda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
