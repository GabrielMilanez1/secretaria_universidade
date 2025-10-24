<?php
require_once '../session/session_start.php';
require_once '../header.php';

require_once '../class/Usuario.php';
require_once '../class/Cargo.php';

if (!$admin) {
  header('location: /');
  exit();
}

$id_usuario = $_GET['u'];

if ($_POST) {

    $_GET = [];
    $falha = false;
    $mensagem_erro = '';

    $action = $_POST['action'];

    if ($action && $id_usuario) {

        switch ($action) {
            case 'editar':
                $objusuario = new Usuario();   

                $parametros = $_POST;
                unset($parametros['action']);
                unset($parametros['id_usuario']);

                $insert = $objusuario->editar($id_usuario, $parametros);

                if ($insert['sucesso'] == true) {
                    $url_atual = "/editar-usuario/?u={$id_usuario}&s=1";
                    header("location: {$url_atual}");
                    exit();
                } else {
                    $mensagem_erro = $insert['mensagem'];
                    $falha = true;
                }
 

        }         
    }
}

if (!$id_usuario || !is_numeric($id_usuario)) {
    header('location: /listar-usuarios');
    exit();
}

$objusuario = new Usuario();

$usuario = $objusuario->getById($id_usuario);

if (!$usuario) {
    header('location: /listar-usuarios');
    exit();
}

$cargos = Cargo::getCargos();

?>

<?php if(!$falha): ?>
  <style>
    .erro {
      display: none;
      visibility: hidden;
    }
  </style>
<?php endif; ?>

<head>
  <title>Página Inicial | Editar usuário</title>
</head>

<body>

<?php if (isset($_GET['s']) && $_GET['s'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Sucesso!</strong> Usuário editado com sucesso. 🎉
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<div class="erro">
    <h4 style="text-align: center; color:red"><?= $mensagem_erro ?></h4>
    <h5 style="text-align: center; color:red">Tente novamente</h5>
    <br>
</div>

<div class="container" style="display: flex; flex-direction: column; justify-content: center;">
    <h2 style="margin-bottom: 1em;">Editar Usuário: <?= htmlspecialchars($usuario['nome']); ?></h2>

    <form method="POST">

        <input type="hidden" name="action" value="editar">

        <div class="form-group">
            <label for="nome">Nome:</label>
            <input 
                type="text" 
                class="form-control" 
                id="nome" 
                name="nome" 
                value="<?= htmlspecialchars($usuario['nome']); ?>" 
                required
            >
        </div>

        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input 
                type="date" 
                class="form-control" 
                id="data_nascimento" 
                name="data_nascimento" 
                value="<?= htmlspecialchars($usuario['data_nascimento']); ?>" 
                required
            >
        </div>

        <div class="form-group" style="margin-bottom: 1em;">
            <label for="id_cargo">Cargo:</label>
            <select class="form-control" id="id_cargo" name="id_cargo" required>
                <?php foreach ($cargos as $cargo): ?>
                    <option value="<?= $cargo['id'] ?>" <?= $cargo['id'] == $usuario['id_cargo'] ? 'selected' : '' ?> ><?= htmlspecialchars($cargo['nome']) ?></option>;
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        
        <a href="/listar-usuarios" class="btn btn-secondary">Voltar</a>
        
    </form>
</div>


</body>

</html>

<?php require_once '../footer.php';