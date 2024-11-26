<?php
include 'db.php'; // Conexión a la base de datos

$table = $_GET['table'] ?? ''; // Obtiene el nombre de la tabla desde la URL
$id = $_GET['id'] ?? ''; // Obtiene el ID del registro desde la URL

if ($table && $id) {
    
    $primaryKey = getPrimaryKey($pdo, $table);
    
    if ($primaryKey) {
       
        $stmt = $pdo->prepare("DELETE FROM $table WHERE $primaryKey = ?");
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() > 0) {
            echo "Registro eliminado exitosamente.";
        } else {
            echo "No se pudo eliminar el registro. Puede que ya no exista.";
        }
    } else {
        echo "Error: No se pudo determinar la clave primaria de la tabla.";
    }
} else {
    echo "Error: Tabla o ID no especificados.";
}


function getPrimaryKey($pdo, $table) {
    $stmt = $pdo->prepare("SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['Column_name'] : null;
}
?>
