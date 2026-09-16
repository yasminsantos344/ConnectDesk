<?php

include_once("../config/database.php");
include_once("../models/cadastro.php");

$adm            = new AdministradorEmpresa($pdo);
$empresa        = new Empresa($pdo);
$assinatura     = new Assinatura($pdo);
$dadosBancarios = new DadosBancarios($pdo);

$email_adm = filter_input(INPUT_GET,"email_adm", FILTER_SANITIZE_EMAIL);
$senha_adm = filter_input(INPUT_GET,"senha_adm");

$razao_social           = filter_input(INPUT_GET,"razao_social");
$cnpj                   = filter_input(INPUT_GET,"cnpj",);
$nome_fantasia          = filter_input(INPUT_GET, "nome_fantasia");
$inscricao_estadual     = $_FILES['inscricao_estadual']['name'] ?? null; 
$inscricao_municipal    = $_FILES['inscricao_municipal']['name'] ?? null;

$id_plano                   = filter_input(INPUT_GET,"id_plano");
$modo_pagamento_assinatura  = filter_input(INPUT_GET,"modo_pagamento_assinatura");
$tipo_assinatura            = filter_input(INPUT_GET,"tipo_assinatura");
$qtd_parcelas_assinatura    = filter_input(INPUT_GET,"qtd_parcelas_assinatura");
$data_vencimento_assinatura = filter_input(INPUT_GET,"data_vencimento_assinatura");

$banco                          = filter_input(INPUT_GET,"banco");
$bandeira_banco                 = filter_input(INPUT_GET,"bandeira_banco");
$nome_titular_banco             = filter_input(INPUT_GET,"nome_titular_banco");
$numero_cartao_banco            = filter_input(INPUT_GET,"numero_cartao_banco");
$data_validade_cartao_banco     = filter_input(INPUT_GET,"data_validade_cartao_banco");
$codigo_seguranca_cartao_banco  = filter_input(INPUT_GET,"codigo_seguranca_cartao_banco");


$adm ->setEmailAdm($email_adm);
$adm ->setSenhaAdm($senha_adm);

$empresa ->razao_social = $razao_social;
$empresa ->setCnpj($cnpj);
$empresa ->nome_fantasia = $nome_fantasia;
$empresa ->inscricao_estadual = $inscricao_estadual;
$empresa ->inscricao_municipal = $inscricao_municipal;

$assinatura ->id_plano = $id_plano;
$assinatura ->modo_pagamento_assinatura = $modo_pagamento_assinatura;
$assinatura ->tipo_assinatura = $tipo_assinatura;
$assinatura ->qtd_parcelas_assinatura = $qtd_parcelas_assinatura;
$assinatura ->data_vencimento_assinatura = $data_vencimento_assinatura;

$dadosBancarios ->setBanco($banco);
$dadosBancarios ->setBandeiraBanco(identificarBandeira($numero_cartao_banco));
$dadosBancarios ->setNomeTitularBanco($nome_titular_banco);
$dadosBancarios ->setNumeroCartaoBanco($numero_cartao_banco);
$dadosBancarios ->setDataValidadeCartao($data_validade_cartao_banco);
$dadosBancarios ->setCodigoSegurancaCartao($codigo_seguranca_cartao_banco);


if(isset($_GET['Cadastrar'])){
    try{
        $id_adm = $adm -> cadastrarAdm();
        $empresa_id = $empresa -> cadastrarEmpresa($id_adm);
        $assinatura -> registrarAssinatura($empresa_id);

        if($modo_pagamento_assinatura === 'cartao') {
            $dadosBancarios -> cadastrarDadosBancarios($empresa_id);
        }
        $dadosBancarios -> cadastrarDadosBancarios($empresa_id);

        echo "Cadastro realizado com sucesso!";
    }
    catch(Exception $e){
        echo "Erro: " . $e->getMessage();
    }
}


// MÉTODO AUXILIAR 


function identificarBandeira($numero_cartao_banco){
    $numeroStr = strval($numero_cartao_banco);
        // Remove quaisquer espaços ou caracteres não numéricos
        $numero = preg_replace('/\D/', '', $numeroStr);

        // Expressões regulares para cada bandeira
        $padroes = [
            'Visa'             => '/^4[0-9]{12}(?:[0-9]{3})?$/',
            'Mastercard'       => '/^(5[1-5][0-9]{14}|222[1-9][0-9]{12}|22[3-9][0-9]{13}|2[3-6][0-9]{14}|27[0-1][0-9]{13}|2720[0-9]{12})$/',
            'Amex'             => '/^3[47][0-9]{13}$/',
            'Elo'              => '/^(401178|401179|431274|438935|451416|457393|457631|457632|504175|506699|5067[0-7][0-9]|509000|509[0-9]{3}|627780|636297|636368|65003[1-3]|65003[5-9]|65004[0-9]|65005[0-1]|65040[5-9]|6504[1-3][0-9]|65048[5-9]|65049[0-9]|6505[0-2][0-9]|65053[0-8]|65054[1-9]|6505[5-9][0-9]|65070[0-9]|65071[0-8]|65072[0-7]|65090[1-9]|65091[0-9]|650920|65165[2-9]|6516[6-7][0-9]|65500[0-9]|65501[0-9]|65502[1-8]|65503[0-9]|65504[0-8]|65505[0-8])/',
            'Discover'         => '/^6(?:011|5[0-9]{2})[0-9]{12}$/',
            'Hipercard'        => '/^(606282|3841[0-9]{2})[0-9]{10,12}$/',
            'Diners'           => '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',
            'JCB'              => '/^(?:2131|1800|35\d{3})\d{11}$/'
        ];

        // Valida o número contra cada padrão
        foreach ($padroes as $bandeira => $regex) {
            if (preg_match($regex, $numero)) {
                return $bandeira;
            }
        }

        return 'Desconhecida';
}