<?php

class AdministradorEmpresa{
    private $email_adm;
    private $senha_adm;

    // Getter / Setters

    public function getEmailAdm() {
        return $this->email_adm;
    }
    public function setEmailAdm($email_adm) {
        $this->email_adm = $email_adm;
    }

    public function getSenhaAdm(){
        return $this->senha_adm;
    }
    public function setSenhaAdm($senha_adm) {
        $this->senha_adm = $senha_adm;
    }

    // Métodos

    public function cadastrarAdm(){
        include_once '../config/database.php';

        $sql_adm = "INSERT INTO tb_adm_empresa (email_adm, senha_adm)
            VALUES(:email_adm, :senha_adm)";

        try{
        $stmt = $pdo->prepare($sql_adm);
        $stmt->execute([
        ':email_adm' => $_POST['email_adm'],
        ':senha_adm' => $_POST['senha_adm'],]);

        $id_adm = $pdo ->lastInsertId();

        return $id_adm;
        }
        catch(PDOException $e) {
            echo "Erro: " + $e->getMessage();
        }
    }

}

class Empresa{
    public $razao_social;
    private $cnpj;
    public $nome_fantasia;
    public $inscricao_estadual;
    public $inscricao_municipal;

// getter / setter

    public function getCnpj() {
        return $this->cnpj;
    }
    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

// Métodos

    public function cadastrarAdm($id_adm){
        include_once '../config/database.php';

        $sql_empresa = "INSERT INTO tb_empresa (razao_social_empresa, cnpj_empresa, nome_fantasia_empresa, inscricao_estadual_empresa,
                                        inscricao_municipal_empresa, status_contrato_empresa, data_inicio_contrato_empresa, data_fim_contrato_empresa,
                                        fk_id_administrador_empresa)
                        VALUES(:razao_social, :cnpj, :nome_fantasia, :inscricao_estadual, :inscricao_municipal, 'ATIVO', NOW(), NULL, :id_adm )";

        try{
        $stmt = $pdo->prepare($sql_empresa);
        $stmt->execute([
        ':razao_social'         => $_POST['razao_social'],
        ':cnpj'                 => $_POST['cnpj'],
        ':nome_fantasia'        => $_POST['nome_fantasia'],
        ':inscricao_estadual'   => $_POST['inscricao_estadual'],
        ':inscricao_municipal'  => $_POST['inscricao_municipal'],
        ':id_adm'               => $id_adm,]);

        $id_empresa = $pdo ->lastInsertId();

        return $id_empresa;
        }
        catch(PDOException $e) {
            echo "Erro: " + $e->getMessage();
        }
    }
}

class Assinatura{
    public $id_plano;
    public $modo_pagamento_assinatura;
    public $tipo_assinatura;
    public $qtd_parcelas_assinatura;
    public $data_vencimento_assinatura;

    // Métodos

    public function registrarAssinatura($id_empresa){
        include_once '../config/database.php';

        $sql_assinatura = "INSERT INTO tb_assinatura (fk_id_empresa, fk_id_plano,status_assinatura, data_inicio_assinatura, data_vencimento_assinatura, modo_pagamento_assinatura, qtd_parcelas_assinatura)
                VALUES(:id_empresa, :id_plano, 'ATIVO', NOW(), :data_vencimento_assinatura, :modo_pagamento_assinatura, :qtd_parcelas_assinatura)";

        try{
        $stmt = $pdo->prepare($sql_assinatura);
        $stmt->execute([
        ':id_empresa' => $id_empresa,
        ':id_plano' => $_POST['id_plano'],
        ':data_vencimento_assinatura' => $_POST['data_vencimento_assinatura'],
        ':modo_pagamento_assinatura' => $_POST['modo_pagamento_assinatura'],
        ':qtd_parcelas_assinatura' => $_POST['qtd_parcelas_assinatura']]);

        $id_assinatura = $pdo ->lastInsertId();

        return true;
        }
        catch(PDOException $e) {
            echo "Erro: " + $e->getMessage();
        }
    }
}

class DadosBancarios{
    private $banco;
    private $bandeira_banco;
    private $nome_titular_banco;
    private $numero_cartao_banco;
    private $data_validade_cartao_banco;
    private $codigo_seguranca_cartao_banco;

    // Getter / Setter

    public function getBanco() {
        return $this->banco;
    }
    public function setBanco($banco) {
        $this->banco = $banco;
    }

    public function getBandeiraBanco() {
        return $this->bandeira_banco;
    }
    public function setBandeiraBanco($bandeira_banco) {
        $this->bandeira_banco = $bandeira_banco;
    }

    public function getNomeTitularBanco() {
        return $this->nome_titular_banco;
    }
    public function setNomeTitularBanco($nome_titular_banco) {
        $this->nome_titular_banco = $nome_titular_banco;
    }

    public function getNumeroCartaoBanco() {
        return $this->numero_cartao_banco;
    }
    public function setNumeroCartaoBanco($numero_cartao_banco) {
        $this->numero_cartao_banco = $numero_cartao_banco;
    }

    public function getDataValidadeCartao() {
        return $this->data_validade_cartao_banco;
    }
    public function setDataValidadeCartao($data_validade_cartao_banco) {
        $this->data_validade_cartao_banco = $data_validade_cartao_banco;
    }

    public function getCodigoSegurancaCartao() {
        return $this->codigo_seguranca_cartao_banco;
    }
    public function setCodigoSegurancaCartao($codigo_seguranca_cartao) {
        $this->codigo_seguranca_cartao_banco = $codigo_seguranca_cartao;
    }

    // Métodos

    public function cadastrarDadosBancarios($id_empresa){
        include_once '../config/database.php';

        $sql_dados_bancarios = "INSERT INTO tb_dados_bancarios (banco, bandeira_banco, nome_titular_banco, numero_cartao_banco, data_validade_cartao_banco, codigo_seguranca_cartao_banco, fk_id_empresa)
                VALUES(:banco, :bandeira_banco, :nome_titular_banco, :numero_cartao_banco, :data_validade_cartao_banco, :codigo_seguranca_cartao_banco, :id_empresa)";

        try{
        $stmt = $pdo->prepare($sql_dados_bancarios);
        $stmt->execute([
        ':banco' => $_POST['banco'],
        ':bandeira_banco' => $_POST['bandeira_banco'],
        ':nome_titular_banco' => $_POST['nome_titular_banco'],
        ':numero_cartao_banco' => $_POST['numero_cartao_banco'],
        ':data_validade_cartao_banco' => $_POST['data_validade_cartao_banco'],
        ':codigo_seguranca_cartao_banco' => $_POST['codigo_seguranca_cartao_banco'],
        ':id_empresa' => $id_empresa]);

        return true;
        }
        catch(PDOException $e) {
            echo "Erro: " + $e->getMessage();
        }
    }

}