<?php
$host = 'localhost';
$dbname = 'dane'; // Nombre de tu base de datos
$username = 'root'; // Usuario de MySQL
$password = ''; // Contraseña de MySQL
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>