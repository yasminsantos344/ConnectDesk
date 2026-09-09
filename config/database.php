<?php

$host = 'acela.proxy.rlwy.net';
$port = '10835';
$database = 'railway';
$user = 'root';
$password = 'myknbYMUdlgVOVxqHgaQkCAPwBsyitkT';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexão realizada com sucesso!";

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}