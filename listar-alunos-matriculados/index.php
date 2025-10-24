<?php
require_once '../session/session_start.php';
require_once '../header.php';

require_once '../class/Relatorio.php';
require_once '../class/Turma.php';

if (!$admin) {
  header('location: /');
  exit();
}

$turma = isset($_GET['t']) && !empty($_GET['t']) ? $_GET['t'] : false;

if (!$turma) {
    header('location: /listar-turmas');
    exit();
}

$pagina = isset($_GET['pagina']) && !empty($_GET['pagina']) ? (int)($_GET['pagina']) : 1;

$alunos = Relatorio::getAlunosMatriculados($turma, $pagina);

$proxima_pagina = $pagina + 1;

$tem_proxima_pagina = count(Relatorio::getAlunosMatriculados($turma, $proxima_pagina)) > 0 ? true : false;

$parametros = $_GET;
unset($parametros['pagina']);

$query_string = http_build_query($parametros);

$objturma = new Turma();
$turma = $objturma->getById($turma);

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

    @media (max-width: 768px) {
        .table td, .table th {
            font-size: 0.85em;
            padding: 0.6em;
        }
    }
</style>

<head>
  <title>Página Inicial | Listar alunos matriculados</title>
</head>

<body>


<div class="container mt-5" style="display: flex; flex-direction: column; gap: 1em;">

    <h2 class="mb-3">Alunos matriculados em: <?= $turma['nome'] ?></h2>

    <?php if (empty($alunos)): ?>
        <div class="alert alert-warning" role="alert">
            Nenhum aluno matriculado.
        </div>
    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Data de nascimento</th>
                    <th scope="col">CPF</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?= htmlspecialchars($aluno['nome']); ?></td>
                    <td><?= Utilidades::formataDataBr(htmlspecialchars($aluno['data_nascimento'])); ?></td>
                    <td><?= Utilidades::formataCpf($aluno['cpf']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>

        <nav aria-label="Paginação de Alunos" style="margin-bottom: 1.2em;">
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