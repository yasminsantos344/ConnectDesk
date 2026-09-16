

<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "connectdesk_bd"; // Substitua pelo nome do banco que criou no phpMyAdmin

try {
    // Cria a conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    
    // Configura o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    // Exibe a mensagem se a conexão falhar
    echo "Erro na conexão: " . $erro->getMessage();
}
