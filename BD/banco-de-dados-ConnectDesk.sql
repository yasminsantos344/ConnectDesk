/*

*/

CREATE DATABASE connectDeskDB;

USE DATABASE connectDeskDB;

CREATE TABLE tb_plano(
    id_plano            INT(2) AUTO_INCREMENT PRIMARY KEY,
    nome_plano          VARCHAR(40) NOT NULL,
    preco_mensal_plano  DECIMAL(4,2) NOT NULL,
    descricao_plano     VARCHAR(150) NOT NULL
);


CREATE TABLE tb_adm_empresa(
    id_administrador_empresa INT(6) AUTO_INCREMENT PRIMARY KEY,
    email_adm                VARCHAR(30) NOT NULL,
    senha_adm                VARBINARY(500) NOT NULL
); /* PARA INSERIR : ENCRYPTBYPASSPHRASE('ChaveMestra123', nome_campo)
      PARA ACESSAE: CAST(DECRYPTBYPASSPHRASE('ChaveMestra123', nome_campo) AS VARCHAR(100)) AS senha*/

CREATE TABLE tb_empresa(
    id_empresa                      INT(6) AUTO_INCREMENT PRIMARY KEY,
    razao_social_empresa            VARCHAR(80) UNIQUE NOT NULL,
    cnpj_empresa                    CHAR(14) UNIQUE NOT NULL,
    nome_fantasia_empresa           VARCHAR(100) NOT NULL,
    inscricao_estadual_empresa      VARCHAR(250),
    inscricao_municipal_empresa     VARCHAR(250) NOT NULL,
    status_contrato_empresa         VARCHAR(20) NOT NULL,
    data_inicio_contrato_empresa    DATETIME NOT NULL,
    data_fim_contrato_empresa       DATETIME
    fk_id_administrador_empresa     INT(6) NOT NULL,

    CONSTRAINT fk_id_administrador_empresa FOREIGN KEY (id_administrador_empresa) REFERENCES tb_adm_empresa(id_administrador_empresa)
);


CREATE TABLE tb_assinatura(
    id_assinatura               INT(6) AUTO_INCREMENT PRIMARY KEY,
    fk_id_empresa                  INT(6) NOT NULL,
    fk_id_plano                    INT(2) NOT NULL,
    status_assinatura           VARCHAR(20) NOT NULL,
    data_inicio_assinatura      DATETIME NOT NULL,
    data_vencimento_assinatura  DATETIME NOT NULL,

    CONSTRAINT fk_id_empresa FOREIGN KEY (id_empresa) REFERENCES tb_empresa(id_empresa),
    CONSTRAINT fk_id_plano FOREIGN KEY (id_plano) REFERENCES tb_plano(id_plano)
);


CREATE TABLE tb_pagamento(
    id_pagamento                INT(10) AUTO_INCREMENT PRIMARY KEY,
    fk_id_assinatura            INT(6) NOT NULL,
    valor_pagamento             DECIMAL(6,2) NOT NULL,
    status_pagamento            VARCHAR(20) NOT NULL,
    data_hora_pagamento         DATETIME NOT NULL,
    data_vencimento_pagamento   DATE NOT NULL,

    CONSTRAINT fk_id_assinatura FOREIGN KEY (id_assinatura) REFERENCES tb_assinatura(id_assinatura)
);

CREATE TABLE tb_usuario(
    id_usuario          INT(6) AUTO_INCREMENT PRIMARY KEY,
    fk_id_empresa       INT(6) NOT NULL,
    nome_usuario        VARCHAR(90) NOT NULL,
    email_usuario       VARCHAR(40) NOT NULL UNIQUE,
    tipo_usuario        VARCHAR(20) NOT NULL, /* SUPORTE, CLIENTE, ADM */
    privilegio_usuario  VARCHAR(20) NOT NULL, /* CLIENTE, SUPORTE, OPERACIONAL, OPERACIONAL_ADM */
    status_usuario      VARCHAR(20) NOT NULL, /* ATIVO, INATIVO */

    CONSTRAINT fk_id_empresa FOREIGN KEY (id_empresa) REFERENCES tb_empresa(id_empresa)
);


CREATE TABLE tb_log_atividade(
    id_log         INT(10) AUTO_INCREMENT PRIMARY KEY,
    fk_id_usuario  INT(6) NOT NULL,
    acao_log       VARCHAR(150) NOT NULL,
    data_hora_log  DATETIME NOT NULL,

    CONSTRAINT fk_id_usuario FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario)
);


CREATE TABLE tb_chamado(
    id_chamado                      INT(12) AUTO_INCREMENT PRIMARY KEY,
    fk_id_cliente                   INT(6) NOT NULL,
    fk_id_suporte                   INT(6) NOT NULL,
    fk_id_empresa                   INT(6) NOT NULL,
    nome_chamado                    VARCHAR(100) NOT NULL,
    status_chamado                  VARCHAR(30) NOT NULL,
    prioridade_chamado              VARCHAR(30) NOT NULL,
    data_hora_abertura_chamado      DATETIME NOT NULL,
    data_hora_fechamento_chamado    DATETIME NOT NULL,

    CONSTRAINT fk_id_cliente FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario),
    CONSTRAINT fk_id_suporte FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario),
    CONSTRAINT fk_id_empresa FOREIGN KEY (id_empresa) REFERENCES tb_empresa(id_empresa)
);


CREATE TABLE tb_chatbot(
    id_chatbot          INT(6) AUTO_INCREMENT PRIMARY KEY,
    fk_id_empresa       INT(6) NOT NULL,
    nome_chatbot        VARCHAR(30) NOT NULL,
    status_chatbot      VARCHAR(20) NOT NULL
);


CREATE TABLE tb_chatonline(
    id_chatonline       INT(12) AUTO_INCREMENT PRIMARY KEY,
    fk_id_chamado       INT(12) NOT NULL,
    fk_id_cliente       INT(6) NOT NULL,
    fk_id_suporte       INT(6) NOT NULL,
    status_chatonline   VARCHAR(20) NOT NULL

    CONSTRAINT fk_id_cliente FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario),
    CONSTRAINT fk_id_suporte FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario),
    CONSTRAINT fk_id_chamado FOREIGN KEY (id_chamado) REFERENCES tb_empresa(id_chamado)
);


CREATE TABLE tb_mensagem(
    id_mensagem         INT(20) AUTO_INCREMENT PRIMARY KEY,
    fk_id_chat          INT(12) NOT NULL,
    fk_id_remetente     INT(6) NOT NULL,
    dk_id_destinatario  INT(6) NOT NULL,
    conteudo_mensagem   TEXT NOT NULL,
    data_hora_mensagem  DATETIME NOT NULL

    CONSTRAINT fk_id_remetente FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario),
    CONSTRAINT dk_id_destinatario FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario),
    CONSTRAINT fk_id_chat FOREIGN KEY (id_chatonline) REFERENCES tb_chatonline(fk_id_chatonline)
);