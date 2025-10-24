<?php
require_once 'session/session_start.php';
require_once 'header.php';

require_once 'services/UsuarioService.php';
require_once 'class/Relatorio.php';

?>

<head>
  <title>Página Inicial | Secretaria da Universidade</title>
</head>

<body>
    
<div class="container mt-5" style="display: flex; flex-direction: column; gap: 1em; margin-bottom: 2em;">
    <?php if ($aluno): // Home para alunos ?>

        <h2 class="mb-3"><?= $sessao->getNome() ?>, essas são as suas turmas:</h2>
        
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

        <?php 
            $pagina = isset($_GET['pagina']) && !empty($_GET['pagina']) ? (int)($_GET['pagina']) : 1;

            $id_usuario = $sessao->getId(); 

            $turmas_do_aluno = Relatorio::getTurmasDoUsuario($id_usuario, $pagina);

            $parametros = $_GET;
            unset($parametros['pagina']);

            $query_string = http_build_query($parametros);
        ?>

        <?php if (empty($turmas_do_aluno)): ?>
            <div class="alert alert-warning" role="alert">
                Você ainda não faz parte de nenhuma turma!
            </div>
        <?php else: ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($turmas_do_aluno as $turma): ?>
                    <tr>
                        <td><?= htmlspecialchars($turma['nome']); ?></td>
                        <td><?= htmlspecialchars($turma['descricao']); ?></td>
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
        
    <?php elseif ($admin): ?>

        <style>
            .lista-home > li {
                font-size: 20px;
            }
        </style>

        <h4 style="text-align: center;"><?= $sessao->getNome() ?>, você é um administrador! Aqui estão algumas informações que podem ser úteis:</h4>

        <ul class="lista-home">
            <li>👨‍🎓 Total de alunos: <strong><?= Relatorio::getTotalUsuariosPorCargo(Cargo::ALUNO) ?></strong> </li>
            <li>🏫 Total de turmas: <strong><?= Relatorio::getTotalTurmas() ?></strong></li>
            <li>👩‍🏫 Administradores cadastrados: <strong><?= Relatorio::getTotalUsuariosPorCargo(Cargo::ADMINISTRADOR) ?></strong> </li>
        </ul>

        <div class="mt-4 d-flex flex-wrap gap-3">
            <a href="/listar-turmas" class="btn btn-primary btn-lg flex-fill" style="min-width: 200px;">
                📋 Gerenciar turmas
            </a>
            <a href="/listar-usuarios" class="btn btn-success btn-lg flex-fill" style="min-width: 200px;">
                👥 Gerenciar usuários
            </a>
            <a href="/adicionar-turma" class="btn btn-info btn-lg flex-fill" style="min-width: 200px;">
                ➕ Criar nova turma
            </a>
            <a href="/adicionar-usuario" class="btn btn-secondary btn-lg flex-fill" style="min-width: 200px;">
                ➕ Adicionar um usuário
            </a>
        </div>

    <?php endif; ?>

</div>

</body>
</html>

<?php require_once 'footer.php';