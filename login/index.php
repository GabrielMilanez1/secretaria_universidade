<?php

require_once '../class/Usuario.php';
require_once '../session/session_start.php';
require_once '../services/UsuarioService.php';
require_once '../class/Session.php';



$_SESSION = [];

$falha_login = false;

if ($_POST) {

  if (isset($_POST['email']) && isset($_POST['senha'])) {
    
    $correspondencia = UsuarioService::login($_POST['email'], $_POST['senha']);

    if ($correspondencia) {      
      header('location: /');
      exit();
    } else {
      $falha_login = true;
    }
    
  }
    
}

?>

<?php if(!$falha_login): ?>
  <style>
    .erro-login {
      display: none;
      visibility: hidden;
    }
  </style>
<?php endif; ?>


<link rel="stylesheet" href="../css/login-style.css">
<meta charset="UTF-8">

<title>Login | Secretaria da Universidade</title>


<body>

<div class="container">
    <h2>Secretaria da Universidade</h2>
  
    <div class="erro-login">
      <h4 style="text-align: center; color:red">Usuário ou senha inválidos!</h4>
      <h5 style="text-align: center; color:red">Tente novamente</h4>
    </div>
  
    <form method="post">
        <input type="text" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input type="submit" value="Logar">
    </form>

</div>

</body>
</html>
