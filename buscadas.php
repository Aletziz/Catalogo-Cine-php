<?php include "header.php" ?>
<?php include "connect.php" ?>
<?php
$objconexion = new Connect();
$buscar = $objconexion->consultar("SELECT p.*, 
    COALESCE(AVG(pt.puntuacion), 0) as promedio_puntuacion,
    COALESCE(COUNT(pt.puntuacion), 0) as total_votos
    FROM pelicula p 
    LEFT JOIN puntuaciones pt ON p.id = pt.pelicula_id 
    WHERE p.nombre LIKE '%".$_POST['buscar']."%'
    GROUP BY p.id");

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




<div class="container">
        <h2 class="mb-4">Resultados</h2>
        <!-- Grid de películas -->
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <?php if(count($buscar) > 0) { ?>
            <?php foreach($buscar as $buscado) {?>
            <div class="col">
                <div class="card">
                    <img src="imgs/<?php echo $buscado['ruta'] ?>" class="card-img-top" alt="Película 1">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $buscado['nombre'] ?></h5>
                        <p class="card-text"><?php echo $buscado['descripcion'] ?></p>
                        
                        <!-- Sistema de puntuación compacto -->
                        <div class="rating-compact mb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="stars-display" data-rating="<?php echo round($buscado['promedio_puntuacion']); ?>">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="star-sm <?php echo ($i <= round($buscado['promedio_puntuacion'])) ? 'filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                    <small class="ms-1 text-muted"><?php echo number_format($buscado['promedio_puntuacion'], 1); ?></small>
                                </div>
                                <small class="text-muted"><?php echo $buscado['total_votos']; ?> votos</small>
                            </div>
                        </div>
                        
                        <!-- Puntuación interactiva más pequeña -->
                        <div class="rating-interactive mb-2" data-pelicula-id="<?php echo $buscado['id']; ?>">
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
                            <span class="badge bg-primary"><?php echo $buscado['accion'] ?></span>
                            <button class="btn btn-sm btn-outline-secondary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#movieModal<?php echo $buscado['id']; ?>">Ver más</button>
                        </div>
                    </div>
                </div>
            </div>
                <!-- Modal para cada película -->
        <div class="modal fade" id="movieModal<?php echo $buscado['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $buscado['nombre']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="imgs/<?php echo $buscado['ruta'] ?>" 
                                    class="img-fluid rounded" 
                                    alt="<?php echo $buscado['nombre'] ?>">
                            </div>
                            <div class="col-md-8">
                                <h6 class="fw-bold">Información General</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Género:</strong> <?php echo $buscado['accion']; ?></li>
                                    <li><strong>Fecha de Estreno:</strong> <?php echo $buscado['fecha_estreno'] ?? 'No disponible'; ?></li>
                                    <li><strong>Duración:</strong> <?php echo $buscado['duracion'] ?? 'No disponible'; ?></li>
                                    <li><strong>Director:</strong> <?php echo $buscado['director'] ?? 'No disponible'; ?></li>
                                </ul>

                                <h6 class="fw-bold mt-3">Reparto</h6>
                                <p><?php echo $buscado['reparto'] ?? 'Información no disponible'; ?></p>

                                <h6 class="fw-bold mt-3">Sinopsis</h6>
                                <p><?php echo $buscado['descripcion']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
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