function login() {
    console.log("Iniciando login...");

    var form_login = document.getElementById('form_login');
    var dados_login = new FormData(form_login);

    console.log("Email:", dados_login.get("email"));
    console.log("Senha:", dados_login.get("senha"));

    $.ajax({
        method: 'POST',
        url: '../controller/ContrLogin.php?LoginAdm',
        data: dados_login,

        processData: false,
        contentType: false,

        beforeSend: function() {
            console.log("Dados enviados para o servidor");
        }
    })

    .done(function(dadosPHP) {
        if (dadosPHP.trim() === "Login realizado com sucesso!") {
            window.location.href = "../screen/usuario_perfil.php";
        } else {
            alert(dadosPHP);
        }
    })

    .fail(function(xhr) {
        console.log("Falha na solicitação");
        console.log(xhr.responseText);
    });
}
