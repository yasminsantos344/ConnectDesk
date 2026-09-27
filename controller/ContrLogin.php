<?php

include_once("../config/database.php");
include_once("../models/login.php");

$login = new Login($pdo);

$email_adm = filter_input(INPUT_POST, "email");
$senha_adm = filter_input(INPUT_POST, "senha");

$login->setEmailAdm($email_adm);
$login->setSenhaAdm($senha_adm);

if (isset($_GET['LoginAdm'])) {
    try {
        $result = $login->loginAdm();

        if ($result) {
            session_start();

            $_SESSION['id_adm'] = $result['id_administrador_empresa'];
            $_SESSION['email_adm'] = $result['email_adm'];
            $_SESSION['nome_fantasia_empresa'] = $result['nome_fantasia_empresa'];

            echo "Login realizado com sucesso!";
        } else {
            echo "Email ou senha incorretos!";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}