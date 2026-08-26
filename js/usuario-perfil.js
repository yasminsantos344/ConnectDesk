// Botão de editar informações pessoais
const editBtn = document.getElementById("editBtn");
const cancelBtn = document.getElementById("cancelBtn");
const formActions = document.getElementById("formActions");
const infoForm = document.getElementById("infoForm");
const inputs = infoForm.querySelectorAll("input");
const campoNomeUsuario = document.getElementById("nomeUsuario");
const nomeTopo = document.getElementById("nomeTopo");
const nomePerfil = document.getElementById("nomePerfil");

campoNomeUsuario.addEventListener("input", () => {
  const novoNome = campoNomeUsuario.value;
  nomeTopo.textContent = novoNome;
  nomePerfil.textContent = novoNome;
});

let valoresOriginais = {};

function habilitarEdicao() {
  valoresOriginais = {};
  inputs.forEach((input) => {
    valoresOriginais[input.name] = input.value;
    input.disabled = false;
  });
  formActions.hidden = false;
  editBtn.disabled = true;
}

function cancelarEdicao() {
  inputs.forEach((input) => {
    input.value = valoresOriginais[input.name];
    input.disabled = true;
  });
  formActions.hidden = true;
  editBtn.disabled = false;
}

function formatarTelefone(valor) {
  // Remove tudo que não for número
  const numeros = valor.replace(/\D/g, "").slice(0, 11);

  if (numeros.length <= 2) {
    return `(${numeros}`;
  }
  if (numeros.length <= 7) {
    return `(${numeros.slice(0, 2)}) ${numeros.slice(2)}`;
  }
  return `(${numeros.slice(0, 2)}) ${numeros.slice(2, 7)}-${numeros.slice(7)}`;
}


editBtn.addEventListener("click", habilitarEdicao);
cancelBtn.addEventListener("click", cancelarEdicao);

infoForm.addEventListener("submit", (event) => {
  event.preventDefault();

   telefone.value = formatarTelefone(telefone.value);

  // Aqui entraria a chamada para salvar no backend (fetch/AJAX)
  // Exemplo:
  // fetch("/api/perfil", { method: "PUT", body: new FormData(infoForm) })

  inputs.forEach((input) => (input.disabled = true));
  formActions.hidden = true;
  editBtn.disabled = false;

  console.log("Dados salvos:", Object.fromEntries(new FormData(infoForm)));
});

// Navegação simples entre "páginas" da sidebar (troque pelos seus links reais)
document.querySelectorAll(".nav-item").forEach((item) => {
  item.addEventListener("click", (event) => {
    window.location.href = `${item.dataset.page}.html`;
    document.querySelectorAll(".nav-item").forEach((i) => i.classList.remove("active"));
    item.classList.add("active");
  });
});