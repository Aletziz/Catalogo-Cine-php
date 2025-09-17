<?php
include "connect.php";

header('Content-Type: application/json');

if ($_POST && isset($_POST['pelicula_id']) && isset($_POST['puntuacion'])) {
    $objconexion = new Connect();
    $pelicula_id = intval($_POST['pelicula_id']);
    $puntuacion = intval($_POST['puntuacion']);
    $usuario_ip = $_SERVER['REMOTE_ADDR'];
    
    // Validar puntuación
    if ($puntuacion < 1 || $puntuacion > 5) {
        echo json_encode(['success' => false, 'message' => 'Puntuación inválida']);
        exit;
    }
    
    try {
        // Verificar si el usuario ya puntuó esta película
        $existe = $objconexion->consultar("SELECT id FROM puntuaciones WHERE pelicula_id = $pelicula_id AND usuario_ip = '$usuario_ip'");
        
        if (count($existe) > 0) {
            // Actualizar puntuación existente
            $sql = "UPDATE puntuaciones SET puntuacion = $puntuacion WHERE pelicula_id = $pelicula_id AND usuario_ip = '$usuario_ip'";
        } else {
            // Insertar nueva puntuación
            $sql = "INSERT INTO puntuaciones (pelicula_id, usuario_ip, puntuacion) VALUES ($pelicula_id, '$usuario_ip', $puntuacion)";
        }
        
        $objconexion->ejecutar($sql);
        
        // Calcular nuevo promedio
        $stats = $objconexion->consultar("SELECT AVG(puntuacion) as promedio, COUNT(*) as total FROM puntuaciones WHERE pelicula_id = $pelicula_id");
        $promedio = round($stats[0]['promedio'], 1);
        $total_votos = $stats[0]['total'];
        
        echo json_encode([
            'success' => true, 
            'promedio' => $promedio,
            'total_votos' => $total_votos
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al guardar puntuación']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}
?>