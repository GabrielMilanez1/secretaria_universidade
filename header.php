<?php

require_once 'class/Utilidades.php';
require_once 'class/Session.php';

$sessao = new Session();
$logado = $sessao->usuarioLogado();
$admin = $sessao->usuarioAdm();
$aluno = $sessao->usuarioAluno();

if (!$logado) {
    header('location: /login');
}

$nome = Utilidades::formataNome($_SESSION['nome']);

$paginas_admin = [
    <<<HTML
        <li><a href="/adicionar-turma">Adicionar turma</a></li>
        <li><a href="/listar-usuarios">Listar usuários</a></li>
    HTML,
];

$paginas_logado = [
    <<<HTML
        <li><a href="/logout">Sair</a></li>
    HTML,
];

$paginas_deslogado = [
    <<<HTML
        <li><a href="/login">Login</a></li>
    HTML,
];

$links_clicaveis = '';

if ($logado) {

    if ($admin) {
        foreach ($paginas_admin as $item) {
            $links_clicaveis .= $item;
        }
    }

    foreach ($paginas_logado as $item) {
        $links_clicaveis .= $item;
    }

    } else {

    foreach ($paginas_deslogado as $item) {
        $links_clicaveis .= $item;
    }
}

?>

<!DOCTYPE html>

<html lang="pt-BR">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  
<link rel="stylesheet" href="../css/style-cabecalho.css">
  
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
  
<header>

  <div class="header-container esconde-mobile">
    <div class="container">
      <div style="display: flex; flex-direction: column; align-items: center; align-content: center; justify-content: center;">
        <a href="/">
          <p class="titulo-header">Secretaria da Universidade</p>
        </a>
        <?php if ($logado): ?>
          <p class="segundo-titulo-header">Olá <strong><?= $nome ?> <?= $admin ? '(Administrador)' : '' ?> </strong></p>
        <?php endif; ?>
      </div>
      <nav>
        <ul>
          <?= $links_clicaveis ?>
        </ul>
      </nav>
    </div>
  </div>

  <div class="topnav esconde-desktop">
    
    <a href="/">
      <p class="titulo-header">Secretaria da universidade</p>
    </a>

    <div id="links_hamburger">

        <?php if ($logado): ?>
            <p class="segundo-titulo-header" style="text-align: center;">Olá <strong><?= $nome ?> <?= $admin ? '(Administrador)' : '' ?> </strong></p>
        <?php endif; ?>

        <?= $links_clicaveis ?>
      
    </div>

    <a href="javascript:void(0);" class="icon" onclick="abrirHamburger()">
      <i class="fa fa-bars"></i>
    </a>
    
  </div>
  
</header>

<script>
  function abrirHamburger() {
    var x = document.getElementById("links_hamburger");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }
</script>