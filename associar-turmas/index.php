<?php
require_once '../session/session_start.php';
require_once '../header.php';

require_once '../class/Usuario.php';
require_once '../class/Turma.php';
require_once '../class/RelUsuarioTurma.php';
require_once '../class/Cargo.php';

if (!$admin) {
  header('location: /');
  exit();
}

$id_usuario = $_GET['u'];

$id_usuario_responsavel = $sessao->getId();

if ($_POST) {
    
    $objrelusuarioturma = new RelUsuarioTurma();

    $turmas_para_associar = $_POST['turmas'];

    $insert = $objrelusuarioturma->salvarAssociacoes($id_usuario, $turmas_para_associar, $id_usuario_responsavel);

    if ($insert['sucesso'] == true) {
        $url_atual = $_SERVER['PHP_SELF'];
        header("location: /associar-turmas/?u={$id_usuario}&s=1");
        exit();
    } else {
        $mensagem_erro = $insert['mensagem'];
        $falha = true;
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

$objturma = new Turma();

$turmas_ja_associadas = [];

foreach ($objusuario->getTurmasAssociadas($id_usuario) as $turma_ja_associada) {
    $turmas_ja_associadas[] = $turma_ja_associada['id_turma'];
}

$turmas_disponiveis = $objturma->getTurmas();

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
  <title>Página Inicial | Associar turmas</title>
</head>

<body>

<?php if (isset($_GET['s']) && $_GET['s'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Sucesso!</strong> Turmas associadas com sucesso. 🎉
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<div class="erro">
    <h4 style="text-align: center; color:red"><?= $mensagem_erro ?></h4>
    <h5 style="text-align: center; color:red">Tente novamente</h5>
    <br>
</div>

<div class="container" style="display: flex; flex-direction: column; justify-content: center; margin-bottom: 1em;">
    <h2 style="margin-bottom: 1em;">Associar turmas ao Usuário: <?= htmlspecialchars($usuario['nome']); ?></h2>

    <form method="POST">

        <table class="table table-condensed table-striped">
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Selecionar</th>
            </tr>          
            <?php foreach ($turmas_disponiveis as $turma): ?>
                <tr>
                    <td><?= $turma['nome'] ?></td>
                    <td><?= $turma['descricao'] ?></td>
                    <td><input type="checkbox" <?= in_array($turma['id'], $turmas_ja_associadas) ? 'checked' : '' ?> value="<?= $turma['id'] ?>" name="turmas[]"></td>
                </tr>
            <?php endforeach; ?>
        </table>

        

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        
        <a href="/listar-usuarios" class="btn btn-secondary">Voltar</a>
        
    </form>
</div>


</body>

</html>

<?php require_once '../footer.php';