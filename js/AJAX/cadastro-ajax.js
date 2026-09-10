function cadastro() {

    // Pega os três formulários
    var dados = new FormData();

    // Formulário de dados da empresa
    var formDados = document.getElementById('forms_dados');
    var dadosEmpresa = new FormData(formDados);

    dadosEmpresa.forEach(function(valor, chave) {
        dados.append(chave, valor);
    });

    // Formulário de planos
    var plano = $('#forms_planos input[name="plano"]:checked').val();

    if (plano) {
        dados.append('plano', plano);
    }

    // Formulário de pagamento
    var formaPagamento = $('#forms_pagamento input[name="forma_pag"]:checked').val();

    if (formaPagamento) {
        dados.append('forma_pag', formaPagamento);
    }

    $.ajax({
        method: 'POST',
        url: 'ContrEmpresa.php',
        data: dados,

        processData: false,
        contentType: false,

        beforeSend: function() {
            console.log("Dados enviados para o servidor");
        }
    })

    .done(function(dadosPHP) {
        console.log("Dados recebidos do servidor: " + dadosPHP);
    })

    .fail(function(xhr) {
        console.log("Falha na solicitação");
        console.log(xhr.responseText);
    });
}

