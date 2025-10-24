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

$pagina = isset($_GET['pagina']) && !empty($_GET['pagina']) ? (int)($_GET['pagina']) : 1;
$filtro_nome = isset($_GET['nome']) && !empty($_GET['nome']) ? $_GET['nome'] : '';

$turmas = Relatorio::getTurmas($pagina, $filtro_nome);

$proxima_pagina = $pagina + 1;

$tem_proxima_pagina = count(Relatorio::getTurmas($proxima_pagina, $filtro_nome)) > 0 ? true : false;

$parametros = $_GET;
unset($parametros['pagina']);

$query_string = http_build_query($parametros);

$objturma = new Turma();

?>

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
</style>

<head>
  <title>Página Inicial | Listar turmas</title>
</head>

<body>

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
                <i class="fas fa-search"></i> Buscar
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
                <th scope="col">Alunos matriculados</th>
                <th scope="col">Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turmas as $turma): ?>
                <tr>
                    <td><?= htmlspecialchars($turma['nome']); ?></td>
                    <td><?= htmlspecialchars($turma['descricao']); ?></td>
                    <td><?= count($objturma->getUsuariosAssociados($turma['id'])) ?></td>
                    <td><a href="/editar-turma?u=<?= $turma['id']?>"><i class="fa fa-edit"></i></a></td>
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

<?php require_once '../footer.php';