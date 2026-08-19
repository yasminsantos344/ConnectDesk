function validarCampos(){

    let email = document.getElementById("email");
    let senha = document.getElementById("senha");

    let validado = true;

    // Remove erros anteriores
    email.classList.remove("erro");
    senha.classList.remove("erro");

    // Validação Usuário
    if(email.value.trim() === ""){

        email.classList.add("erro");
        email.placeholder = "PREENCHER AQUI";

        validado = false;
    }

    // Validação Senha
    if(senha.value.trim() === ""){

        senha.classList.add("erro");
        senha.placeholder = "PREENCHER AQUI";

        validado = false;
    }

    // Se estiver tudo preenchido
    if(validado){

        document.getElementById("janelaSucesso").style.display = "flex";
    }

}

function fecharJanela(){

    document.getElementById("janelaSucesso").style.display = "none";
}