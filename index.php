<?php include "header.php"; ?>
<?php include "connect.php"; ?>
<?php
$objconexion = new Connect();
$mostrar = $objconexion->consultar("SELECT * FROM `pelicula`");
$destacadas = $objconexion->consultar("SELECT * FROM `pelicula` WHERE destacado = 1");

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
<?php if(count($destacadas) > 0) { ?>
    <div class="container">
        <h2>Películas destacadas</h2>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
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
    </div>
    <br>
<?php } ?>
    
    <!-- Contenido Principal -->
    <div class="container">
        <h2 class="mb-4">Todas las películas</h2>
        <!-- Grid de películas -->
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
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