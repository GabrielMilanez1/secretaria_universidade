<?php
require_once '../session/session_start.php';
require_once '../header.php';

require_once '../class/Turma.php';

if (!$admin) {
  header('location: /');
  exit();
}

$id_turma = $_GET['u'];

if ($_POST) {

    $_GET = [];
    $falha = false;
    $mensagem_erro = '';

    $action = $_POST['action'];

    if ($action && $id_turma) {

        switch ($action) {
            case 'editar':
                $objturma = new Turma();   

                $parametros = $_POST;
                unset($parametros['action']);
                unset($parametros['id_turma']);

                $insert = $objturma->editar($id_turma, $parametros);

                if ($insert['sucesso'] == true) {
                    $url_atual = "/editar-turma/?u={$id_turma}&s=1";
                    header("location: {$url_atual}");
                    exit();
                } else {
                    $mensagem_erro = $insert['mensagem'];
                    $falha = true;
                }
 

        }         
    }
}

if (!$id_turma || !is_numeric($id_turma)) {
    header('location: /listar-turmas');
    exit();
}

$objturma = new Turma();

$turma = $objturma->getById($id_turma);

if (!$turma) {
    header('location: /listar-turmas');
    exit();
}

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
  <title>Página Inicial | Editar turma</title>
</head>

<body>

<?php if (isset($_GET['s']) && $_GET['s'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Sucesso!</strong> Turma editada com sucesso. 🎉
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<div class="erro">
    <h4 style="text-align: center; color:red"><?= $mensagem_erro ?></h4>
    <h5 style="text-align: center; color:red">Tente novamente</h5>
    <br>
</div>

<div class="container" style="display: flex; flex-direction: column; justify-content: center;">
    <h2 style="margin-bottom: 1em;">Editar Turma: <?= htmlspecialchars($turma['nome']); ?></h2>

    <form method="POST">

        <input type="hidden" name="action" value="editar">

        <div class="form-group">
            <label for="nome">Nome:</label>
            <input 
                type="text" 
                class="form-control" 
                id="nome"
                name="nome" 
                value="<?= htmlspecialchars($turma['nome']); ?>" 
                required
                maxlength="50"
            >
        </div>

        <div class="form-group" style="margin-bottom: 1em;">
            <label for="descricao">Descrição:</label>
            <input 
                type="text" 
                class="form-control" 
                id="descricao" 
                name="descricao" 
                value="<?= htmlspecialchars($turma['descricao']); ?>" 
                maxlength="255"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        
        <a href="/listar-turmas" class="btn btn-secondary">Voltar</a>
        
    </form>
</div>


</body>

</html>

<?php require_once '../footer.php';