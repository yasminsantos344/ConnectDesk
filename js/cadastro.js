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

// Display default

window.onload = function() {
    form_dados.style.display = "block";
    dados.classList.add("dados_active");

    form_planos.style.display = "none";
    form_pagamento.style.display = "none";
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



