CREATE TABLE tb_plano (
    id_plano INT AUTO_INCREMENT PRIMARY KEY,
    nome_plano VARCHAR(40) NOT NULL,
    preco_mensal_plano DECIMAL(6,2) NOT NULL,
    descricao_plano VARCHAR(150) NOT NULL,
    preco_anual_plano DECIMAL(6,2) NOT NULL
);


CREATE TABLE tb_adm_empresa (
    id_administrador_empresa INT AUTO_INCREMENT PRIMARY KEY,
    email_adm VARCHAR(30) NOT NULL,
    senha_adm VARBINARY(500) NOT NULL
);


CREATE TABLE tb_empresa (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    razao_social_empresa VARCHAR(80) UNIQUE NOT NULL,
    cnpj_empresa CHAR(14) UNIQUE NOT NULL,
    nome_fantasia_empresa VARCHAR(100) NOT NULL,
    inscricao_estadual_empresa VARCHAR(250),
    inscricao_municipal_empresa VARCHAR(250) NOT NULL,
    status_contrato_empresa VARCHAR(20) NOT NULL,
    data_inicio_contrato_empresa DATETIME NOT NULL,
    data_fim_contrato_empresa DATETIME,
    fk_id_administrador_empresa INT NOT NULL,

    CONSTRAINT fk_empresa_administrador
        FOREIGN KEY (fk_id_administrador_empresa)
        REFERENCES tb_adm_empresa(id_administrador_empresa)
);


CREATE TABLE tb_assinatura (
    id_assinatura INT AUTO_INCREMENT PRIMARY KEY,
    fk_id_empresa INT NOT NULL,
    fk_id_plano INT NOT NULL,
    status_assinatura VARCHAR(20) NOT NULL,
    data_inicio_assinatura DATETIME NOT NULL,
    data_vencimento_assinatura DATETIME NOT NULL,
    modo_pagamento_assinatura VARCHAR(20) NOT NULL,
    qtd_parcelas_assinatura INT,
    tipo_assinatura VARCHAR(20) NOT NULL,

    CONSTRAINT fk_assinatura_empresa
        FOREIGN KEY (fk_id_empresa)
        REFERENCES tb_empresa(id_empresa),

    CONSTRAINT fk_assinatura_plano
        FOREIGN KEY (fk_id_plano)
        REFERENCES tb_plano(id_plano)
);


CREATE TABLE tb_dados_bancarios (
    id_dados_bancarios INT AUTO_INCREMENT PRIMARY KEY,
    fk_id_empresa INT NOT NULL,
    nome_banco VARCHAR(50) NOT NULL,
    bandeira_banco VARCHAR(10) NOT NULL,
    nome_titular_banco VARCHAR(100) NOT NULL,
    numero_cartao_banco VARCHAR(20) NOT NULL,
    data_validade_cartao_banco VARCHAR(10) NOT NULL,
    codigo_seguranca_cartao_banco VARCHAR(4) NOT NULL,

    CONSTRAINT fk_dados_bancarios_empresa
        FOREIGN KEY (fk_id_empresa)
        REFERENCES tb_empresa(id_empresa)
);


CREATE TABLE tb_pagamento (
    id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
    fk_id_assinatura INT NOT NULL,
    valor_pagamento DECIMAL(6,2) NOT NULL,
    status_pagamento VARCHAR(20) NOT NULL,
    data_hora_pagamento DATETIME NOT NULL,
    data_vencimento_pagamento DATE NOT NULL,
    referencia_parcela_pagamento VARCHAR(20),

    CONSTRAINT fk_pagamento_assinatura
        FOREIGN KEY (fk_id_assinatura)
        REFERENCES tb_assinatura(id_assinatura)
);


CREATE TABLE tb_usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    fk_id_empresa INT NOT NULL,
    nome_usuario VARCHAR(90) NOT NULL,
    email_usuario VARCHAR(40) NOT NULL UNIQUE,
    tipo_usuario VARCHAR(20) NOT NULL,
    -- SUPORTE, CLIENTE, ADM

    privilegio_usuario VARCHAR(20) NOT NULL,
    -- CLIENTE, SUPORTE, OPERACIONAL, OPERACIONAL_ADM

    status_usuario VARCHAR(20) NOT NULL,
    -- ATIVO, INATIVO

    CONSTRAINT fk_usuario_empresa
        FOREIGN KEY (fk_id_empresa)
        REFERENCES tb_empresa(id_empresa)
);


CREATE TABLE tb_log_atividade (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    fk_id_usuario INT NOT NULL,
    acao_log VARCHAR(150) NOT NULL,
    data_hora_log DATETIME NOT NULL,

    CONSTRAINT fk_log_usuario
        FOREIGN KEY (fk_id_usuario)
        REFERENCES tb_usuario(id_usuario)
);


CREATE TABLE tb_chamado (
    id_chamado INT AUTO_INCREMENT PRIMARY KEY,
    fk_id_cliente INT NOT NULL,
    fk_id_suporte INT NOT NULL,
    fk_id_empresa INT NOT NULL,
    nome_chamado VARCHAR(100) NOT NULL,
    status_chamado VARCHAR(30) NOT NULL,
    prioridade_chamado VARCHAR(30) NOT NULL,
    data_hora_abertura_chamado DATETIME NOT NULL,
    data_hora_fechamento_chamado DATETIME NULL,

    CONSTRAINT fk_chamado_cliente
        FOREIGN KEY (fk_id_cliente)
        REFERENCES tb_usuario(id_usuario),

    CONSTRAINT fk_chamado_suporte
        FOREIGN KEY (fk_id_suporte)
        REFERENCES tb_usuario(id_usuario),

    CONSTRAINT fk_chamado_empresa
        FOREIGN KEY (fk_id_empresa)
        REFERENCES tb_empresa(id_empresa)
);


CREATE TABLE tb_chatbot (
    id_chatbot INT AUTO_INCREMENT PRIMARY KEY,
    fk_id_empresa INT NOT NULL,
    nome_chatbot VARCHAR(30) NOT NULL,
    status_chatbot VARCHAR(20) NOT NULL,

    CONSTRAINT fk_chatbot_empresa
        FOREIGN KEY (fk_id_empresa)
        REFERENCES tb_empresa(id_empresa)
);


CREATE TABLE tb_chatonline (
    id_chatonline INT AUTO_INCREMENT PRIMARY KEY,
    fk_id_chamado INT NOT NULL,
    fk_id_cliente INT NOT NULL,
    fk_id_suporte INT NOT NULL,
    status_chatonline VARCHAR(20) NOT NULL,

    CONSTRAINT fk_chatonline_cliente
        FOREIGN KEY (fk_id_cliente)
        REFERENCES tb_usuario(id_usuario),

    CONSTRAINT fk_chatonline_suporte
        FOREIGN KEY (fk_id_suporte)
        REFERENCES tb_usuario(id_usuario),

    CONSTRAINT fk_chatonline_chamado
        FOREIGN KEY (fk_id_chamado)
        REFERENCES tb_chamado(id_chamado)
);


CREATE TABLE tb_mensagem (
    id_mensagem INT AUTO_INCREMENT PRIMARY KEY,
    fk_id_chat INT NOT NULL,
    fk_id_remetente INT NOT NULL,
    fk_id_destinatario INT NOT NULL,
    conteudo_mensagem TEXT NOT NULL,
    data_hora_mensagem DATETIME NOT NULL,

    CONSTRAINT fk_mensagem_remetente
        FOREIGN KEY (fk_id_remetente)
        REFERENCES tb_usuario(id_usuario),

    CONSTRAINT fk_mensagem_destinatario
        FOREIGN KEY (fk_id_destinatario)
        REFERENCES tb_usuario(id_usuario),

    CONSTRAINT fk_mensagem_chat
        FOREIGN KEY (fk_id_chat)
        REFERENCES tb_chatonline(id_chatonline)
);