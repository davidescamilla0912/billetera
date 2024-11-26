<?php
//editar o eliminar por id
include 'db.php'; // Conexión a la base de datos

$table = $_GET['table'] ?? ''; 


$allowedTables = ['usuario', 'cuenta', 'transaccion'];

if (in_array($table, $allowedTables)) { a
    try {
        
        $stmt = $pdo->prepare("SELECT * FROM $table");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) > 0) {
            echo "<table border='1'>";  
            echo "<tr>";
            
            foreach (array_keys($rows[0]) as $header) {
                echo "<th>" . htmlspecialchars($header) . "</th>";
            }
            echo "<th>Acciones</th>";  
            echo "</tr>";

           
            foreach ($rows as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";  
                }
                $id = $row[array_key_first($row)];  
                echo "<td>";
                echo "<button class='edit-btn' data-id='$id' data-table='$table'>Editar</button>";
                echo "<button class='delete-btn' data-id='$id' data-table='$table'>Eliminar</button>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay datos para mostrar en la tabla '$table'.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error al ejecutar la consulta: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>Tabla no especificada o no válida.</p>";  
}
?>
