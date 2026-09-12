const form_dados = document.getElementById("forms_dados");
const form_planos = document.getElementById("forms_planos");
const form_pagamento = document.getElementById("forms_pagamento");

const btn_proximo_dados = document.getElementById("btn_proximo_dados");

const btn_proximo_planos = document.getElementById("btn_proximo_planos");
const btn_voltar_planos = document.getElementById("btn_voltar_planos");

const btn_finalizar_pagamento = document.getElementById("btn_finalizar_pagamento");
const btn_voltar_pagamento = document.getElementById("btn_voltar_pagamento");

const successCard = document.getElementById("success-card");

const dados = document.getElementById("dados");
const planos = document.getElementById("planos");
const pagamento = document.getElementById("pagamento");

// Planos disponíveis (nome de exibição + valores)
const planosDados = {
    plano_basico: { nome: "PLANO BÁSICO", mensal: 29.00, anual: 319.00, mesesGratis: 1 },
    plano_pro: { nome: "PLANO PRO", mensal: 79.00, anual: 869.00, mesesGratis: 1 },
    plano_enterprise: { nome: "PLANO ENTERPRISE", mensal: 149.00, anual: 1490.00, mesesGratis: 2 }
};

const radiosPlano = document.querySelectorAll('input[name="plano"]');

// Tabela de tipos de assinatura (aparece após escolher um plano)
const tabelaWrapper = document.getElementById("tabela-assinatura-wrapper");
const planoEscolhidoNome = document.getElementById("planoEscolhidoNome");
const precoMensalTabela = document.getElementById("precoMensalTabela");
const precoAnualTabela = document.getElementById("precoAnualTabela");
const linhaTipoMensal = document.getElementById("linha_tipo_mensal");
const linhaTipoAnual = document.getElementById("linha_tipo_anual");
const tipoMensalRadio = document.getElementById("tipo_mensal");
const tipoAnualRadio = document.getElementById("tipo_anual");

// Elementos do resumo (tela de pagamento)
const resumoPlano = document.getElementById("resumoPlano");
const resumoTipo = document.getElementById("resumoTipo");
const resumoSubtotal = document.getElementById("resumoSubtotal");
const resumoLinhaDesconto = document.getElementById("resumoLinhaDesconto");
const resumoDesconto = document.getElementById("resumoDesconto");
const resumoTotal = document.getElementById("resumoTotal");
const resumoDropdownProduto = document.getElementById("resumoDropdownProduto");
const resumoDropdownValor = document.getElementById("resumoDropdownValor");

function formatarMoeda(valor) {
    return "R$ " + valor.toFixed(2).replace(".", ",");
}

radiosPlano.forEach((radio) =>{
    radio.addEventListener("change", () => {
        radiosPlano.forEach((r) => {
            r.closest("label.plano-opcao").classList.toggle("selecionada", r.checked);
        });
        abrirTabelaAssinatura(radio.id);
    });
});

// Display default

window.onload = function() {
    form_dados.style.display = "block";
    dados.classList.add("dados_active");

    form_planos.style.display = "none";
    form_pagamento.style.display = "none";
}

// Ao escolher um plano, mostra a tabela com os tipos de assinatura (mensal/anual) e seus preços
function abrirTabelaAssinatura(planoId) {
    const plano = planosDados[planoId];
    if (!plano) return;

    planoEscolhidoNome.textContent = plano.nome;

    precoMensalTabela.innerHTML = `${formatarMoeda(plano.mensal)} <small>/usuário</small>`;
    precoAnualTabela.innerHTML = `${formatarMoeda(plano.anual)} <small>/usuário</small>`;

    // Reseta a escolha de tipo sempre que o plano muda
    tipoMensalRadio.checked = false;
    tipoAnualRadio.checked = false;
    linhaTipoMensal.classList.remove("selecionada");
    linhaTipoAnual.classList.remove("selecionada");

    tabelaWrapper.style.display = "block";
    tabelaWrapper.scrollIntoView({ behavior: "smooth", block: "nearest" });
}

radiosPlano.forEach((radio) => {
    radio.addEventListener("change", () => abrirTabelaAssinatura(radio.id));
});

// Permite clicar em qualquer parte da linha para selecionar o tipo de assinatura
linhaTipoMensal.addEventListener("click", () => {
    tipoMensalRadio.checked = true;
    atualizarSelecaoTipo();
});

linhaTipoAnual.addEventListener("click", () => {
    tipoAnualRadio.checked = true;
    atualizarSelecaoTipo();
});

function atualizarSelecaoTipo() {
    linhaTipoMensal.classList.toggle("selecionada", tipoMensalRadio.checked);
    linhaTipoAnual.classList.toggle("selecionada", tipoAnualRadio.checked);
}

// Retorna o id do plano selecionado (radio marcado), ou null se nenhum
function getPlanoSelecionado() {
    const selecionado = document.querySelector('input[name="plano"]:checked');
    return selecionado ? selecionado.id : null;
}

// Retorna "mensal" ou "anual" conforme o tipo escolhido na tabela, ou null se nenhum
function getTipoSelecionado() {
    const selecionado = document.querySelector('input[name="tipo_assinatura"]:checked');
    return selecionado ? selecionado.value : null;
}

// Atualiza o card de resumo na tela de pagamento com o plano e tipo escolhidos
function atualizarResumoPagamento() {
    const planoId = getPlanoSelecionado();
    const tipo = getTipoSelecionado();
    if (!planoId || !planosDados[planoId] || !tipo) return;

    const plano = planosDados[planoId];
    const anual = tipo === "anual";

    resumoPlano.textContent = plano.nome;
    resumoDropdownProduto.textContent = `${plano.nome} - ConnectDesk`;

    if (anual) {
        const subtotal = plano.mensal * 12;
        const desconto = plano.mensal * plano.mesesGratis;
        const total = plano.anual;

        resumoTipo.textContent = "Anual";
        resumoLinhaDesconto.style.display = "flex";
        resumoSubtotal.textContent = formatarMoeda(subtotal);
        resumoDesconto.textContent = "- " + formatarMoeda(desconto);
        resumoTotal.textContent = formatarMoeda(total);
        resumoDropdownValor.textContent = formatarMoeda(total);
    } else {
        resumoTipo.textContent = "Mensal";
        resumoLinhaDesconto.style.display = "none";
        resumoSubtotal.textContent = formatarMoeda(plano.mensal);
        resumoTotal.textContent = formatarMoeda(plano.mensal);
        resumoDropdownValor.textContent = formatarMoeda(plano.mensal);
    }
}


btn_proximo_dados.addEventListener("click", function(event) {
    event.preventDefault();
    form_dados.style.display = "none";
    form_planos.style.display = "block";
    planos.classList.add("planos_active");
});

btn_voltar_planos.addEventListener("click", function(event) {
    event.preventDefault();
    form_planos.style.display = "none";
    form_dados.style.display = "block";
    dados.classList.add("dados_active");
});

btn_proximo_planos.addEventListener("click", function(event) {
    event.preventDefault();

    if (!getPlanoSelecionado()) {
        alert("Selecione um plano para continuar.");
        return;
    }

    if (!getTipoSelecionado()) {
        alert("Selecione o tipo de assinatura (mensal ou anual) para continuar.");
        return;
    }

    atualizarResumoPagamento();

    form_planos.style.display = "none";
    form_pagamento.style.display = "block";
    pagamento.classList.add("pagamento_active");
});

// Lógica para mostrar o card de sucesso
btn_finalizar_pagamento.addEventListener("click", (e) => {
    e.preventDefault();

    successCard.classList.add("show");

    // some depois de 4s (opcional)
    setTimeout(() => {
        successCard.classList.remove("show");
    }, 4000);
});

btn_voltar_pagamento.addEventListener("click", function(event) {
    event.preventDefault();
    form_pagamento.style.display = "none";
    form_planos.style.display = "block";
});



