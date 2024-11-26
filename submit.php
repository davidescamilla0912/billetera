<?php
include 'db.php';

$table = $_POST['table'] ?? '';
$id = $_POST['id'] ?? '';  
unset($_POST['table'], $_POST['id']);  


if ($table && in_array($table, ['usuario', 'cuenta', 'transaccion'])) {
    $fields = array_keys($_POST);
    $values = array_values($_POST);

    if ($id) {
        
        $primaryKey = getPrimaryKey($pdo, $table);
        $setClause = implode(' = ?, ', $fields) . ' = ?';
        $sql = "UPDATE $table SET $setClause WHERE $primaryKey = ?";
        $values[] = $id;
    } else {
        
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));
        $sql = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES ($placeholders)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);

    echo $id ? "Registro actualizado exitosamente." : "Registro creado exitosamente.";
} else {
    echo "Error: Tabla no especificada o tabla no válida.";
}

function getPrimaryKey($pdo, $table) {
    // Obtener la clave primaria de la tabla
    $stmt = $pdo->prepare("SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['Column_name'] : null;
}
?>
