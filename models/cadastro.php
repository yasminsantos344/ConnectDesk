<?php
# Dados pessoais
$razao_social          = $_POST["razao_social"];
$cnpj                  = $_POST["cnpj"];
$nome_fantasia         = $_POST["nome_fantasia"];
$inscricao_estadual    = $_POST["inscricao_estadual"];
$inscricao_municipal   = $_POST["inscricao_municipal"];
$email_adm             = $_POST["email_adm"];
$senha_adm             = $_POST["senha_adm"];


#Dados de assinatura/plano
$id_plano                   = $_POST["id_plano"];
$modo_pagamento_assinatura  = $_POST["forma_pag"];
$tipo_assinatura            = $_POST["tipo_assinatura"];
$qtd_parcelas_assinatura    = $_POST["qtd_parcelas"];

#Dados bancários - caso houver
$banco                          = $_POST["banco"];
$bandeira_banco                 = $_POST["bandeira_banco"];
$nome_titular_banco             = $_POST["nome_titular_banco"];
$numero_cartao_banco            = $_POST["numero_cartao_banco"];
$data_validade_cartao_banco     = $_POST["data_validade_cartao_banco"];
$codigo_seguranca_cartao_banco  = $_POST["codigo_seguranca_cartao_banco"];


if($tipo_assinatura == "M") {
    $data_vencimento_assinatura = date('Y-m-d', strtotime("+1 month"));
}else if($tipo_assinatura == "A") {
    $data_vencimento_assinatura = date('Y-m-d', strtotime("+1 year"));
}

include_once '../config/database.php';

# QUERIES

$sql_adm = "INSERT INTO tb_adm_empresa (email_adm, senha_adm)
        VALUES(:email_adm, :senha_adm)";

$sql_empresa = "INSERT INTO tb_empresa (razao_social_empresa, cnpj_empresa, nome_fantasia_empresa, inscricao_estadual_empresa,
                                        inscricao_municipal_empresa, status_contrato_empresa, data_inicio_contrato_empresa, data_fim_contrato_empresa,
                                        fk_id_administrador_empresa)
                VALUES(:razao_social, :cnpj, :nome_fantasia, :inscricao_estadual, :inscricao_municipal, 'ATIVO', NOW(), NULL, :id_adm )";

$sql_assinatura = "INSERT INTO tb_assinatura (fk_id_empresa, fk_id_plano,status_assinatura, data_inicio_assinatura, data_vencimento_assinatura, modo_pagamento_assinatura, qtd_parcelas_assinatura)
                VALUES(:id_empresa, :id_plano, 'ATIVO', NOW(), :data_vencimento_assinatura, :modo_pagamento_assinatura, :qtd_parcelas_assinatura)";


$sql_dados_bancarios = "INSERT INTO tb_dados_bancarios (banco, bandeira_banco, nome_titular_banco, numero_cartao_banco, data_validade_cartao_banco, codigo_seguranca_cartao_banco, fk_id_empresa)
                VALUES(:banco, :bandeira_banco, :nome_titular_banco, :numero_cartao_banco, :data_validade_cartao_banco, :codigo_seguranca_cartao_banco, :id_empresa)";


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

    #Inserindo assinatura
    $id_empresa = $pdo ->lastInsertId();
    $stmt = $pdo->prepare($sql_assinatura);
    $stmt->execute([
        ':id_empresa' => $id_empresa,
        ':id_plano' => $_POST['id_plano'],
        ':data_vencimento_assinatura' => $data_vencimento_assinatura,
        ':modo_pagamento_assinatura' => $_POST['modo_pagamento_assinatura'],
        ':qtd_parcelas_assinatura' => $_POST['qtd_parcelas_assinatura']
    ]);

}
catch(PDOException $e) {
    echo "Erro: " + $e->getMessage();
}




