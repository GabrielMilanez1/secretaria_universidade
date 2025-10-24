<?php
require_once '../session/session_start.php';
require_once '../header.php';

require_once '../class/Cargo.php';
require_once '../class/Turma.php';

if (!$admin) {
  header('location: /');
  exit();
}

$falha = false;

if ($_POST) {

    $_GET = [];

    if (isset($_POST['nome']) 
        && isset($_POST['descricao']) 
    ) {

        $turma = new Turma();

        $insert = $turma->salvar(
            $_POST['nome'],
            $_POST['descricao']
        );

        if ($insert['sucesso'] == true) {
            $url_atual = $_SERVER['PHP_SELF'];
            header("location: {$url_atual}?s=1");
            exit();
        } else {
            $mensagem_erro = $insert['mensagem'];
            $falha = true;

            // cache pra facilitar o repreenchimento
            $nome_cache = $_POST['nome'];
            $descricao_cache = $_POST['descricao'];

        }

    }

}

if (!$falha) {
    $nome_cache = '';
    $descricao_cache = '';
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
<title>Página Inicial | Adicionar turma</title>
</head>

<body>

<?php if (isset($_GET['s']) && $_GET['s'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Sucesso!</strong> Turma cadastrada com sucesso. 🎉
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<div class="erro">
    <h4 style="text-align: center; color:red"><?= $mensagem_erro ?></h4>
    <h5 style="text-align: center; color:red">Tente novamente</h5>
    <br>
</div>

<div class="row justify-content-center" style="--bs-gutter-x: 0 !important;">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Adicionar nova turma</h4>
            </div>
            <div class="card-body">
                
                <form method="post">

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" maxlength="50" id="nome" name="nome" placeholder="Digite o nome" value="<?= $nome_cache ?>" required>
                    </div>

                    <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" maxlength="255" id="descricao" name="descricao" placeholder="Digite a descrição" value="<?= $descricao_cache ?>" required>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-warning btn-lg">Cadastrar turma</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>

<?php require_once '../footer.php';