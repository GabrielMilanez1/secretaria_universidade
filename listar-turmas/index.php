<?php
require_once '../session/session_start.php';
require_once '../header.php';

require_once '../class/Cargo.php';
require_once '../class/Relatorio.php';
require_once '../class/Utilidades.php';
require_once '../class/Turma.php';

if (!$admin) {
  header('location: /');
  exit();
}

$objturma = new Turma();

if ($_POST) {

    $_GET = [];
    $falha = false;
    $mensagem_erro = '';

    $id_turma = $_POST['id'];
    $action = $_POST['action'];

    if ($action && $id_turma) {
        $delete = $objturma->deletarTurma($id_turma);

        if ($delete['sucesso'] == true) {
            $url_atual = "/listar-turmas/?s=1";
            header("location: {$url_atual}");
            exit();
        } else {
            $mensagem_erro = $delete['mensagem'];
            $falha = true;
        }
    }
}

$pagina = isset($_GET['pagina']) && !empty($_GET['pagina']) ? (int)($_GET['pagina']) : 1;
$filtro_nome = isset($_GET['nome']) && !empty($_GET['nome']) ? $_GET['nome'] : '';

$turmas = Relatorio::getTurmas($pagina, $filtro_nome);

$proxima_pagina = $pagina + 1;

$tem_proxima_pagina = count(Relatorio::getTurmas($proxima_pagina, $filtro_nome)) > 0 ? true : false;

$parametros = $_GET;
unset($parametros['pagina']);
unset($parametros['s']);

$query_string = http_build_query($parametros);

?>

<?php if(!$falha): ?>
    <style>
        .erro {
            display: none;
            visibility: hidden;
        }
    </style>
<?php endif; ?>

<style>
    .col-md-5 {
        text-align: center;
    }
    
    form {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: end;
        gap: 2em;
    }

    @media (max-width: 768px) {
        .table td, .table th {
            font-size: 0.85em;
            padding: 0.6em;
        }
    }
</style>

<head>
  <title>Página Inicial | Listar turmas</title>
</head>

<body>

<?php if (isset($_GET['s']) && $_GET['s'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Sucesso!</strong> Turma excluída com sucesso. 🎉
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<div class="erro">
    <h4 style="text-align: center; color:red"><?= $mensagem_erro ?></h4>
    <h5 style="text-align: center; color:red">Tente novamente</h5>
    <br>
</div>

<div style="display: flex; justify-content: center;">
    <a href="/adicionar-turma" class="btn btn-warning">
        <i class="fa fa-user-o"></i> Cadastrar turma
    </a>
</div>

<div class="container mt-5" style="display: flex; flex-direction: column; gap: 1em;">

    <form method="GET" action="">
            
        <div class="col-md-5">
            <label for="nome" class="form-label">Buscar por Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" 
                    value="<?= htmlspecialchars($filtro_nome) ?>" placeholder="Nome">
        </div>

        <div class="col-md-5">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-search"></i> Buscar
            </button>
        </div>
    </form>

    <?php if ($query_string): ?>
        <a href="/listar-turmas" class="btn btn-danger">
            <i class="fa fa-trash"></i> Limpar filtros
        </a>
    <?php endif; ?>

    <h2 class="mb-3">Listagem de Turmas</h2>

    <?php if (empty($turmas)): ?>
        <div class="alert alert-warning" role="alert">
            Nenhuma turma encontrado com os filtros aplicados.
        </div>
    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">Descrição</th>
                <th scope="col">Alunos matriculados (Clique para listar)</th>
                <th scope="col">Editar</th>
                <th scope="col">Deletar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turmas as $turma): ?>
                <tr>
                    <td><?= htmlspecialchars($turma['nome']); ?></td>
                    <td><?= htmlspecialchars($turma['descricao']); ?></td>
                    <td><a href="/listar-alunos-matriculados/?t=<?= $turma['id'] ?>"> <?= count($objturma->getUsuariosAssociados($turma['id'])) ?> </a></td>
                    <td><a href="/editar-turma?u=<?= $turma['id']?>"><i class="fa fa-edit"></i></a></td>
                     <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $turma['id'] ?>">
                            <input type="hidden" name="action" value="excluir">
                            <a class="deletar-btn" href="#" type="submit"><i class="fa fa-trash"></i></a>
                        </form>
                    </td> 
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>

        <nav aria-label="Paginação de Turmas" style="margin-bottom: 1.2em;">
            <ul class="pagination justify-content-center">
                
                <?php if ($pagina > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $pagina - 1 ?>&<?= $query_string ?>">Anterior</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Anterior</span>
                    </li>
                <?php endif; ?>

                <li class="page-item active" aria-current="page">
                    <span class="page-link"><?= $pagina ?></span>
                </li>
                
                <?php if ($tem_proxima_pagina): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $pagina + 1 ?>&<?= $query_string ?>">Próximo</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Próximo</span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    <?php endif; ?>

</div>

</body>

</html>

<?php require_once '../footer.php'; ?>

<script>
    $('.deletar-btn').on('click', function (e) {
        if (confirm('Ao confirmar, a turma será excluída, você tem certeza?')) {
            this.closest('form').submit();
        } else {
            e.preventDefault();
        }
    })
</script>