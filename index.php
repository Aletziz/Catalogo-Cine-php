<?php include "header.php"; ?>
<?php include "connect.php"; ?>
<?php
$objconexion = new Connect();
$mostrar = $objconexion->consultar("SELECT * FROM `pelicula`");
$destacadas = $objconexion->consultar("SELECT * FROM `pelicula` WHERE destacado = 1");
$noticias = $objconexion->consultar("SELECT * FROM `news` ORDER BY id DESC");

    $objconexion = new Connect();
    $mostrar = $objconexion->consultar("SELECT p.*, 
    COALESCE(AVG(pt.puntuacion), 0) as promedio_puntuacion,
    COALESCE(COUNT(pt.puntuacion), 0) as total_votos
    FROM pelicula p 
    LEFT JOIN puntuaciones pt ON p.id = pt.pelicula_id 
    GROUP BY p.id");
    $destacadas = $objconexion->consultar("SELECT p.*, 
    COALESCE(AVG(pt.puntuacion), 0) as promedio_puntuacion,
    COALESCE(COUNT(pt.puntuacion), 0) as total_votos
    FROM pelicula p 
    LEFT JOIN puntuaciones pt ON p.id = pt.pelicula_id 
    WHERE p.destacado = 1 
    GROUP BY p.id");
?>
<!-- Barra lateral de filtros fija -->
<div class="sidebar-fixed d-none d-md-block">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter"></i> Filtros</h5>
        </div>
        <div class="card-body">
                        <!-- Filtro por género -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Género</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="accion" value="Acción">
                                <label class="form-check-label" for="accion">Acción</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="drama" value="Drama">
                                <label class="form-check-label" for="drama">Drama</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="comedia" value="Comedia">
                                <label class="form-check-label" for="comedia">Comedia</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terror" value="Terror">
                                <label class="form-check-label" for="terror">Terror</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="ciencia-ficcion" value="Ciencia Ficción">
                                <label class="form-check-label" for="ciencia-ficcion">Ciencia Ficción</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="romance" value="Romance">
                                <label class="form-check-label" for="romance">Romance</label>
                            </div>
                        </div>

                        <!-- Filtro por puntuación -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Puntuación mínima</label>
                            <select class="form-select" id="puntuacion-minima">
                                <option value="">Todas las puntuaciones</option>
                                <option value="1">1 estrella o más</option>
                                <option value="2">2 estrellas o más</option>
                                <option value="3">3 estrellas o más</option>
                                <option value="4">4 estrellas o más</option>
                                <option value="5">5 estrellas</option>
                            </select>
                        </div>

                        <!-- Filtro por año -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Año de estreno</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control" id="año-desde" placeholder="Desde" min="1900" max="2024">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" id="año-hasta" placeholder="Hasta" min="1900" max="2024">
                                </div>
                            </div>
                        </div>

                        <!-- Ordenar por -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ordenar por</label>
                            <select class="form-select" id="ordenar-por">
                                <option value="nombre">Nombre (A-Z)</option>
                                <option value="nombre-desc">Nombre (Z-A)</option>
                                <option value="puntuacion">Mejor puntuación</option>
                                <option value="fecha">Más recientes</option>
                                <option value="fecha-desc">Más antiguas</option>
                            </select>
                        </div>

                        <!-- Solo destacadas -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="solo-destacadas">
                                <label class="form-check-label" for="solo-destacadas">
                                    Solo películas destacadas
                                </label>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary" id="aplicar-filtros">
                                <i class="fas fa-search"></i> Aplicar filtros
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="limpiar-filtros">
                                <i class="fas fa-times"></i> Limpiar filtros
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Sistema de Noticias -->
                <div class="card mt-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Noticias</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="news-container" style="max-height: 400px; overflow-y: auto;">
                            <!-- Noticia 1 -->
                            <?php if(count($noticias) > 0){ ?>
                            <?php foreach($noticias as $noticia): ?>
                            <div class="news-item border-bottom p-3">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-dark"><?php echo $noticia['titulo'] ?></h6>
                                        <p class="mb-1 text-muted small"><?php echo $noticia['descripcion'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver todas las noticias</a>
                    </div>
                </div>
            </div>

<!-- Contenido principal -->
<div class="container-fluid">
    <div class="content-with-sidebar">
        <?php if(count($destacadas) > 0) { ?>
            <h2>Películas destacadas</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
           <?php foreach($destacadas as $destacada) { ?>
            <div class="col">
                <div class="card">
                    <img src="imgs/<?php echo $destacada['ruta'] ?>" class="card-img-top" alt="Película destacada">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $destacada['nombre'] ?></h5>
                        <p class="card-text"><?php echo $destacada['descripcion'] ?></p>
                        
                        <!-- Sistema de puntuación compacto -->
                        <div class="rating-compact mb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="stars-display" data-rating="<?php echo round($destacada['promedio_puntuacion']); ?>">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="star-sm <?php echo ($i <= round($destacada['promedio_puntuacion'])) ? 'filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                    <small class="ms-1 text-muted"><?php echo number_format($destacada['promedio_puntuacion'], 1); ?></small>
                                </div>
                                <small class="text-muted"><?php echo $destacada['total_votos']; ?> votos</small>
                            </div>
                        </div>
                        
                        <!-- Puntuación interactiva -->
                        <div class="rating-interactive mb-2" data-pelicula-id="<?php echo $destacada['id']; ?>">
                            <div class="d-flex align-items-center">
                                <small class="me-2">Calificar:</small>
                                <div class="stars interactive">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="star-sm interactive" data-rating="<?php echo $i; ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary"><?php echo $destacada['accion'] ?></span>
                            <button class="btn btn-sm btn-outline-secondary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#movieModalDestacada<?php echo $destacada['id']; ?>">Ver más</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal para cada película destacada -->
            <div class="modal fade" id="movieModalDestacada<?php echo $destacada['id']; ?>" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?php echo $destacada['nombre']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="imgs/<?php echo $destacada['ruta'] ?>" 
                                        class="img-fluid rounded" 
                                        alt="<?php echo $destacada['nombre'] ?>">
                                </div>
                                <div class="col-md-8">
                                    <h6 class="fw-bold">Información General</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>Género:</strong> <?php echo $destacada['accion']; ?></li>
                                        <li><strong>Fecha de Estreno:</strong> <?php echo $destacada['fecha_estreno'] ?? 'No disponible'; ?></li>
                                        <li><strong>Duración:</strong> <?php echo $destacada['duracion'] ?? 'No disponible'; ?></li>
                                        <li><strong>Director:</strong> <?php echo $destacada['director'] ?? 'No disponible'; ?></li>
                                    </ul>

                                    <h6 class="fw-bold mt-3">Reparto</h6>
                                    <p><?php echo $destacada['reparto'] ?? 'Información no disponible'; ?></p>

                                    <h6 class="fw-bold mt-3">Sinopsis</h6>
                                    <p><?php echo $destacada['descripcion']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            </div>
            <br>
        <?php } ?>
    
        <!-- Todas las películas -->
        <h2 class="mb-4">Todas las películas</h2>
        <!-- Grid de películas -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach($mostrar as $mostrado) {?>
            <div class="col">
                <div class="card">
                    <img src="imgs/<?php echo $mostrado['ruta'] ?>" class="card-img-top" alt="Película 1">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $mostrado['nombre'] ?></h5>
                        <p class="card-text"><?php echo $mostrado['descripcion'] ?></p>
                        
                        <!-- Sistema de puntuación compacto -->
                        <div class="rating-compact mb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="stars-display" data-rating="<?php echo round($mostrado['promedio_puntuacion']); ?>">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="star-sm <?php echo ($i <= round($mostrado['promedio_puntuacion'])) ? 'filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                    <small class="ms-1 text-muted"><?php echo number_format($mostrado['promedio_puntuacion'], 1); ?></small>
                                </div>
                                <small class="text-muted"><?php echo $mostrado['total_votos']; ?> votos</small>
                            </div>
                        </div>
                        
                        <!-- Puntuación interactiva más pequeña -->
                        <div class="rating-interactive mb-2" data-pelicula-id="<?php echo $mostrado['id']; ?>">
                            <div class="d-flex align-items-center">
                                <small class="me-2">Calificar:</small>
                                <div class="stars interactive">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="star-sm interactive" data-rating="<?php echo $i; ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary"><?php echo $mostrado['accion'] ?></span>
                            <button class="btn btn-sm btn-outline-secondary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#movieModal<?php echo $mostrado['id']; ?>">Ver más</button>
                        </div>
                    </div>
                </div>
            </div>
                <!-- Modal para cada película -->
        <div class="modal fade" id="movieModal<?php echo $mostrado['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $mostrado['nombre']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="imgs/<?php echo $mostrado['ruta'] ?>" 
                                    class="img-fluid rounded" 
                                    alt="<?php echo $mostrado['nombre'] ?>">
                            </div>
                            <div class="col-md-8">
                                <h6 class="fw-bold">Información General</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Género:</strong> <?php echo $mostrado['accion']; ?></li>
                                    <li><strong>Fecha de Estreno:</strong> <?php echo $mostrado['fecha_estreno'] ?? 'No disponible'; ?></li>
                                    <li><strong>Duración:</strong> <?php echo $mostrado['duracion'] ?? 'No disponible'; ?></li>
                                    <li><strong>Director:</strong> <?php echo $mostrado['director'] ?? 'No disponible'; ?></li>
                                </ul>

                                <h6 class="fw-bold mt-3">Reparto</h6>
                                <p><?php echo $mostrado['reparto'] ?? 'Información no disponible'; ?></p>

                                <h6 class="fw-bold mt-3">Sinopsis</h6>
                                <p><?php echo $mostrado['descripcion']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
     <script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar clics en estrellas interactivas
    document.querySelectorAll('.rating-interactive .star, .rating-interactive .star-sm').forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            const starsContainer = this.parentElement;
            const ratingContainer = this.closest('.rating-interactive');
            const peliculaId = ratingContainer.dataset.peliculaId;
            
            // Actualizar visualización de estrellas interactivas
            const allStars = starsContainer.querySelectorAll('.star, .star-sm');
            allStars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
            
            // Enviar puntuación
            enviarPuntuacion(peliculaId, rating, starsContainer);
        });
    });
    
    // Efecto hover para estrellas interactivas
    document.querySelectorAll('.rating-interactive .star, .rating-interactive .star-sm').forEach(star => {
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            const starsContainer = this.parentElement;
            const allStars = starsContainer.querySelectorAll('.star, .star-sm');
            
            allStars.forEach((s, index) => {
                if (index < rating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            const starsContainer = this.parentElement;
            const allStars = starsContainer.querySelectorAll('.star, .star-sm');
            
            allStars.forEach(s => {
                if (s.classList.contains('active')) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
    });
    
    function enviarPuntuacion(peliculaId, rating, starsContainer) {
        fetch('puntuar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `pelicula_id=${peliculaId}&puntuacion=${rating}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar la visualización
                const card = starsContainer.closest('.card');
                const ratingInfo = card.querySelector('.rating-compact small, .rating-display .rating-info');
                if (ratingInfo) {
                    ratingInfo.textContent = `${data.promedio}/5 (${data.total_votos} votos)`;
                }
                
                // Actualizar estrellas de visualización
                const displayStars = card.querySelectorAll('.stars-display .star-sm, .rating-display .star');
                displayStars.forEach((star, index) => {
                    if (index < Math.round(data.promedio)) {
                        star.classList.add('filled');
                    } else {
                        star.classList.remove('filled');
                    }
                });
                
                alert('¡Puntuación guardada exitosamente!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al enviar la puntuación');
        });
    }
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include "footer.php" ?>