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
        height: 380px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .card-img-top {
        height: 150px;
        width: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.3s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-body {
        flex: 1;
        padding: 1rem;
        background: #fff;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-text {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-body .mt-auto {
        margin-top: auto !important;
        padding-top: 0.5rem;
    }

    /* Sistema de estrellas */
.rating {
    display: flex;
    align-items: center;
    gap: 5px;
    margin: 0.5rem 0;
}

.stars {
    display: flex;
    gap: 2px;
}

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
    margin-bottom: 0.5rem;
}

.rating-interactive {
    font-size: 0.8rem;
    margin-bottom: 0.5rem;
}

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
            <a class="navbar-brand" href="index.php">CineCatálogo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Buscador simple -->
                    <form action="buscadas.php" method="post">
                        <div class="d-flex me-auto ms-3">
                            <div class="input-group" style="width: 300px;">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Buscar películas..."
                                    id="navbarSearch"
                                    name="buscar"
                                >
                            </div>
                        </div>
                    </form>
            
                <ul class="navbar-nav">
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
