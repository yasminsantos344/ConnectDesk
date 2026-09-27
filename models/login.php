<?php
class Login{
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    private $email_adm;
    private $senha_adm;

    // Getter / Setters
    public function getEmailAdm() {
        return $this->email_adm;
    }
    public function setEmailAdm($email_adm) {
        $this->email_adm = $email_adm;
    }
    public function getSenhaAdm() {
        return $this->senha_adm;
    }
    public function setSenhaAdm($senha_adm) {
        $this->senha_adm = $senha_adm;
    }

    // Métodos

    public function loginAdm(){
        $sql_login = "SELECT adm.*, emp.nome_fantasia_empresa 
                    FROM tb_adm_empresa adm 
                    INNER JOIN tb_empresa emp 
                        ON adm.id_administrador_empresa = emp.fk_id_administrador_empresa 
                    WHERE adm.email_adm = :email_adm 
                    AND adm.senha_adm = :senha_adm";
        try{
            $stmt = $this->pdo->prepare($sql_login);
            $stmt->execute([
                ':email_adm' => $this->getEmailAdm(),
                ':senha_adm' => $this->getSenhaAdm(),
            ]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}