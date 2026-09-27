function cadastro() {

    // Pega os três formulários
    var dados = new FormData();

    // Formulário de dados da empresa
    var form_dados = document.getElementById('forms_dados');
    var dadosEmpresa = new FormData(form_dados);

    var forms_planos = document.getElementById('forms_planos');
    var dadosPlanos = new FormData(forms_planos);

    var forms_pagamento = document.getElementById('forms_pagamento');
    var dadosPagamento = new FormData(forms_pagamento);

    console.log("Dados da empresa: " + dadosEmpresa + " | Dados do plano: " + dadosPlanos + " | Dados do pagamento: " + dadosPagamento);


    for (let [chave, valor] of dadosEmpresa.entries()) {
        console.log(chave, "=", valor);
    }

    dadosEmpresa.forEach(function(valor, chave) {
        dados.append(chave, valor);
    });


    for (let [chave, valor] of dadosPlanos.entries()) {
        console.log(chave, "=", valor);
    }

    dadosPlanos.forEach(function(valor, chave) {
        dados.append(chave, valor);
    });
    

    for (let [chave, valor] of dadosPagamento.entries()) {
        console.log(chave, "=", valor);
    }

    dadosPagamento.forEach(function(valor, chave) {
        dados.append(chave, valor);
    });


    // Formulário de pagamento
    var formaPagamento = $('#forms_pagamento input[name="modo_pagamento_assinatura"]:checked').val();
    console.log("formaPagamento: " + formaPagamento);

    if (formaPagamento) {
        dados.append('modo_pagamento_assinatura', formaPagamento);
    }

    $.ajax({
        method: 'POST',
        url: '../controller/ContrCadastro.php?Cadastrar',
        data: dados,

        processData: false,
        contentType: false,

        beforeSend: function() {
            console.log("Dados enviados para o servidor");
        }
    })

    .done(function(dadosPHP) {
        console.log("Dados recebidos do servidor: " + dadosPHP);
        successCard.classList.add("show");
        
        setTimeout(() => {
            successCard.classList.remove("show");
            window.location.href = "http://localhost/ConnectDesk/screen/login.html";
            }, 4000);
        })

    .fail(function(xhr) {
        console.log("Falha na solicitação");
        console.log(xhr.responseText);
    });
}

