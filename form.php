<?php
include 'db.php'; 

$table = $_GET['table'] ?? ''; 
$id = $_GET['id'] ?? ''; 
$fields = []; 
$values = [];


if ($table) {
   
    $primaryKey = getPrimaryKey($pdo, $table);

    if ($id) {
       
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE $primaryKey = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $fields = array_keys($row); 
            $values = array_values($row); 
        }
    } else {
       
        $stmt = $pdo->prepare("DESCRIBE $table");
        $stmt->execute();
        $fields = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    echo "<h1>" . ($id ? 'Editar' : 'Crear') . " $table</h1>";
    echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='table' value='$table'>"; 
    if ($id) {
        echo "<input type='hidden' name='id' value='$id'>"; 


    for ($i = 0; $i < count($fields); $i++) {
        $field = $fields[$i];
        $value = $values[$i] ?? ''; 
        echo "<label for='$field'>$field:</label>";
        echo "<input type='text' id='$field' name='$field' value='" . htmlspecialchars($value) . "' required><br>";
    }

   
    echo "<button type='submit'>" . ($id ? 'Actualizar' : 'Crear') . "</button>";
    echo "</form>";

   
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /
        $fields = $_POST;
        $table = $_POST['table'];
        $id = $_POST['id'] ?? null;

      
        if ($id) {
            $columns = array_keys($fields);
            $placeholders = array_map(fn($col) => "$col = ?", $columns);
            $sql = "UPDATE $table SET " . implode(", ", $placeholders) . " WHERE Id_Usuario = ?"; // Cambiar según la clave primaria
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array_merge(array_values($fields), [$id]));

            echo "<p>Registro actualizado exitosamente.</p>";
        } else {
           
            $columns = array_keys($fields);
            $placeholders = array_fill(0, count($columns), '?');
            $sql = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array_values($fields));

            echo "<p>Registro creado exitosamente.</p>";
        }
    }
} else {
    echo "<p>Tabla no especificada.</p>";
}


function getPrimaryKey($pdo, $table) {
    $stmt = $pdo->prepare("SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['Column_name'] : null;
}

// Eliminar registro
if (isset($_GET['delete']) && isset($_GET['table']) && isset($_GET['id'])) {
    $tableToDelete = $_GET['table'];
    $idToDelete = $_GET['id'];

    // Verificar que la tabla y el ID existen
    if ($tableToDelete && $idToDelete) {
        $primaryKey = getPrimaryKey($pdo, $tableToDelete);
        
        if ($primaryKey) {
            $stmt = $pdo->prepare("DELETE FROM $tableToDelete WHERE $primaryKey = ?");
            $stmt->execute([$idToDelete]);

            if ($stmt->rowCount() > 0) {
                echo "<p>Registro eliminado exitosamente.</p>";
            } else {
                echo "<p>No se pudo eliminar el registro. Puede que ya no exista.</p>";
            }
        } else {
            echo "<p>No se pudo determinar la clave primaria de la tabla.</p>";
        }
    }
}
}
?>
