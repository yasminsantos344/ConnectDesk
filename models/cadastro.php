<?php

$razao_social           = $_POST["razao_social"];
$cnpj                   = $_POST["cnpj"];
$nome_fantasia          = $_POST["nome_fantasia"];
$inscricao_estadual     = $_POST["inscricao_estadual"];
$inscricao_municipal    = $_POST["inscricao_municipal"];
$email_adm              = $_POST["email_adm"];
$senha_adm              = $_POST["senha_adm"];
$id_plano               = $_POST["id_plano"];
$forma_pag              = $_POST["forma_pag"];


include_once '../config/database.php';

# QUERIES

$sql_adm = "INSERT INTO tb_adm_empresa (email_adm, senha_adm)
        VALUES(:email_adm, :senha_adm)";

$sql_empresa = "INSERT INTO tb_empresa (razao_social_empresa, cnpj_empresa, nome_fantasia_empresa, inscricao_estadual_empresa,
                                        inscricao_municipal_empresa, status_contrato_empresa, data_inicio_contrato_empresa, data_fim_contrato_empresa,
                                        fk_id_administrador_empresa)
                VALUES(:razao_social, :cnpj, :nome_fantasia, :inscricao_estadual, :inscricao_municipal, 'ATIVO', NOW(), NULL, :id_adm )";

# INSERTS

try{
    # Inserindo adm da empresa

    $stmt = $pdo->prepare($sql_adm);
    $stmt->execute([
    ':email_adm' => $_POST['email_adm'],
    ':senha_adm' => $_POST['senha_adm'],]); 

    $id_adm = $pdo ->lastInsertId();

    #Inserindo a empresa
    $stmt = $pdo->prepare($sql_empresa);
    $stmt->execute([
    ':razao_social'         => $_POST['razao_social'],
    ':cnpj'                 => $_POST['cnpj'],
    ':nome_fantasia'        => $_POST['nome_fantasia'],
    ':inscricao_estadual'   => $_POST['inscricao_estadual'],
    ':inscricao_municipal'  => $_POST['inscricao_municipal'],
    ':id_adm'               => $id_adm,]);
}
catch(PDOException $e) {
    echo "Erro: " + $e->getMessage();
}




