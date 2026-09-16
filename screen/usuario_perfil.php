<?php

session_start();

if (!isset($_SESSION['email_adm'])) {
    header("Location: http://localhost/ConnectDesk/screen/login.html");
    exit();
}

$id = $_SESSION['id_adm'];
$email = $_SESSION['email_adm'];
$nome_fantasia = $_SESSION['nome_fantasia_empresa'];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perfil</title>

<link rel="stylesheet" href="../css/usuario-perfil.css">

<script src="https://kit.fontawesome.com/4b7f2b17a4.js" crossorigin="anonymous"></script>

</head>
<body>

  <div class="app">

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <img src="/assets/logo.png" class="img_logo">
      </div>

      <nav class="nav">
        <a href="#" class="nav-item" data-page="dashboard">
          <span class="nav-icon"><i class="fa-solid fa-chart-simple"></i></span> Dashboard
        </a>
        <a href="#" class="nav-item" data-page="tickets">
          <span class="nav-icon"><i class="fa-solid fa-ticket"></i></span> Tickets
        </a>
        <a href="#" class="nav-item active" data-page="usuario_perfil">
          <span class="nav-icon"><i class="fa-solid fa-face-smile"></i></span> Perfil
        </a>
        <a href="#" class="nav-item" data-page="chatbot">
          <span class="nav-icon"><i class="fa-solid fa-robot"></i></span> ChatBot
        </a>
        <a href="#" class="nav-item" data-page="faq">
          <span class="nav-icon"><i class="fa-regular fa-comments"></i></span> FAQ
        </a>
        <a href="#" class="nav-item" data-page="chat">
          <span class="nav-icon"><i class="fa-solid fa-message"></i></span> Chat
        </a>
        <a href="#" class="nav-item" data-page="relatorio">
          <span class="nav-icon"><i class="fa-solid fa-file"></i></span> Relatório
        </a>
        <a href="#" class="nav-item" data-page="usuarios">
          <span class="nav-icon"><i class="fa-solid fa-user"></i></span> Usuários
        </a>
      </nav>

      <nav class="nav nav-bottom">
        <a href="#" class="nav-item" data-page="config">
          <span class="nav-icon"><i class="fa-solid fa-gear"></i></span> Configurações
        </a>
        <a href="#" class="nav-item" data-page="config-avancadas">
          <span class="nav-icon"><i class="fa-solid fa-gears"></i></span> Configurações avançadas
        </a>
        <a href="#" class="nav-item" data-page="ajuda">
          <span class="nav-icon"><i class="fa-solid fa-circle-question"></i></span> Ajuda
        </a>
      </nav>
    </aside>

    <!-- Main -->
    <div class="main">

      <!-- Topbar -->
      <header class="topbar">
        <button class="icon-btn" aria-label="Notificações"><i class="fa-solid fa-bell"></i></button>
        <div class="user-chip">
          <i class="fa-solid fa-circle-user" style="color: rgb(138, 143, 156);"></i>
            <span id="nomeTopo">
                <?php echo $nome_fantasia; ?>
            </span>
        </div>
      </header>

      <!-- Content -->
      <main class="content">

        <!-- dados do usuário -->
        <section class="card-de-perfil">
            <h1 class="nome-do-perfil" id="nomePerfil">
                <?php echo $nome_fantasia; ?>
            </h1>
            <p class="cargo">Administrador</p>
            <i class="fa-solid fa-circle-user icone-perfil"></i>
        </section>

        <!-- informações pessoais -->
        <section class="card info-card">
          <div class="info-card-header">
            <h2>Corporative Information</h2>
            <button class="icon-btn edit-btn" id="editBtn" aria-label="Editar informações"><i class="fa-solid fa-pen-to-square"></i></button>
          </div>

          <form id="infoForm" class="info-grid">
            <div class="field">
              <label for="empresa">Empresa</label>
             <input type="text" id="empresa" name="empresa" value="<?php echo $nome_fantasia; ?>" disabled>
            </div>

            <div class="field">
              <label for="userId">ID</label>
              <input type="text" id="userId" name="userId" value="<?php echo $id; ?>" disabled>
            </div>
            
            <div class="field">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" value="<?php echo $email; ?>" disabled>
            </div>

            <div class="form-actions" id="formActions" hidden>
              <button type="submit" class="btn btn-primary">Salvar</button>
              <button type="button" class="btn btn-ghost" id="cancelBtn">Cancelar</button>
            </div>
          </form>
        </section>

      </main>
    </div>
  </div>

  <script src="/js/usuario_perfil.js"></script>
</body>
</html>