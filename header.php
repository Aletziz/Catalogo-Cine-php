<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Películas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Agrega esto en el head de tu documento -->
<style>
    .card {
        height: 350px;
        overflow: hidden;
    }

    .card-img-top {
        height: 150px;
        width: 100%;
        object-fit: cover; /* Mantiene la proporción y cubre el contenedor */
        object-position: center; /* Centra la imagen */
        transition: transform 0.3s ease; /* Efecto suave al hacer hover */
    }

    /* Efecto hover opcional para las imágenes */
    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-body {
        height: 200px; /* Aumentado para dar más espacio al contenido */
        overflow-y: auto;
        padding: 1rem;
        background: #fff; /* Asegura fondo blanco */
    }

    .card-text {
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Aumentado a 3 líneas */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .card-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    /* Estilo para el contenedor de botones/badges */
    .card-body .mt-auto {
        margin-top: 0.5rem !important;
        position: sticky;
        bottom: 0;
        background-color: #fff;
        padding-top: 0.5rem;
    }

    /* Sistema de estrellas */
.rating {
    display: flex;
    align-items: center;
    gap: 5px;
    margin: 10px 0;
}

.stars {
    display: flex;
    gap: 2px;
}

/* Estrellas más compactas */
.star-sm {
    font-size: 14px;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
    margin-right: 1px;
}

.star-sm.filled {
    color: #ffc107;
}

.star-sm.interactive:hover {
    color: #ffc107;
}

.star-sm.active {
    color: #ffc107;
}

.rating-compact {
    font-size: 0.85rem;
}

.rating-interactive {
    font-size: 0.8rem;
}

/* Mantener las clases originales para compatibilidad */
.star {
    font-size: 18px;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.star:hover,
.star.active {
    color: #ffc107;
}

.star.filled {
    color: #ffc107;
}

.rating-info {
    font-size: 0.9rem;
    color: #666;
    margin-left: 10px;
}

.rating-display {
    display: flex;
    align-items: center;
    gap: 5px;
    margin: 5px 0;
}

.rating-display .stars {
    pointer-events: none;
}
</style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">CineCatálogo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CerrarSesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
