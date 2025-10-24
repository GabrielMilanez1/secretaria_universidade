<?php
require_once '../session/session_start.php';
require_once '../header.php';

require_once '../class/Cargo.php';
require_once '../class/Relatorio.php';
require_once '../class/Utilidades.php';
require_once '../class/Usuario.php';

if (!$admin) {
  header('location: /');
  exit();
}

$objusuario = new Usuario();

if ($_POST) {
    
    $_GET = [];
    $falha = false;
    $mensagem_erro = '';

    $id_usuario = $_POST['id'];
    $action = $_POST['action'];

    if ($action && $id_usuario) {
        $delete = $objusuario->deletarUsuario($id_usuario);

        if ($delete['sucesso'] == true) {
            $url_atual = "/listar-usuarios/?s=1";
            header("location: {$url_atual}");
            exit();
        } else {
            $mensagem_erro = $delete['mensagem'];
            $falha = true;
        }
    }
}

$pagina = isset($_GET['pagina']) && !empty($_GET['pagina']) ? (int)($_GET['pagina']) : 1;
$cargo = isset($_GET['cargo']) && !empty($_GET['cargo']) ? (int)($_GET['cargo']) : Cargo::ALUNO;
$filtro_nome = isset($_GET['nome']) && !empty($_GET['nome']) ? $_GET['nome'] : '';

$usuarios = Relatorio::getUsuariosPorCargo($cargo, $pagina, $filtro_nome);

$proxima_pagina = $pagina + 1;

$tem_proxima_pagina = count(Relatorio::getUsuariosPorCargo($cargo, $proxima_pagina, $filtro_nome)) > 0 ? true : false;

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


    .col-md-4 {
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
        .table-responsive {
            box-shadow: none;
            border-radius: 0;
        }

        .table td, .table th {
            font-size: 0.85em;
            padding: 0.6em;
        }

        /* esconde algumas colunas no mobile pra ficar legível */
        td:nth-child(3), th:nth-child(3),
        td:nth-child(4), th:nth-child(4),
        td:nth-child(5), th:nth-child(5), td:nth-child(7), th:nth-child(7)  {
            display: none;
        }

        .table td:last-child {
            text-align: center;
        }
    }
</style>

<head>
  <title>Página Inicial | Listar usuários</title>
</head>

<body>

<?php if (isset($_GET['s']) && $_GET['s'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Sucesso!</strong> Usuário excluído com sucesso. 🎉
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<div class="erro">
    <h4 style="text-align: center; color:red"><?= $mensagem_erro ?></h4>
    <h5 style="text-align: center; color:red">Tente novamente</h5>
    <br>
</div>

<div style="display: flex; justify-content: center;">
    <a href="/adicionar-usuario" class="btn btn-warning">
        <i class="fa fa-user-o"></i> Cadastrar usuário
    </a>
</div>

<div class="container mt-5" style="display: flex; flex-direction: column; gap: 1em;">

    <form method="GET" action="">
            
        <div class="col-md-4">
            <label for="cargo" class="form-label">Filtrar por Cargo</label>
            <select class="form-select" id="cargo" name="cargo">           
                <?php 
                    $cargos_disponiveis = Cargo::getCargos(); 
                    
                    if (is_array($cargos_disponiveis)): ?>
                        <?php foreach ($cargos_disponiveis as $cargo_disponivel): ?>
                            <option <?= $cargo_disponivel['id'] == $cargo ? 'selected' : '' ?> value='<?= $cargo_disponivel['id'] ?>'><?= $cargo_disponivel['nome'] ?></option>"; 
                        <?php endforeach; ?> 
                    <?php endif; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="nome" class="form-label">Buscar por Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" 
                    value="<?= htmlspecialchars($filtro_nome) ?>" placeholder="Nome">
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-search"></i> Buscar
            </button>
        </div>
    </form>

    <?php if ($query_string): ?>
        <a href="/listar-usuarios" class="btn btn-danger">
            <i class="fa fa-trash"></i> Limpar filtros
        </a>
    <?php endif; ?>

    <h2 class="mb-3">Listagem de Usuários</h2>

    <?php if (empty($usuarios)): ?>
        <div class="alert alert-warning" role="alert">
            Nenhum usuário encontrado com os filtros aplicados.
        </div>
    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">Data de Nascimento</th>
                <th scope="col">CPF</th>
                <th scope="col">E-mail</th>
                <th scope="col">Cargo</th>
                <?php if ($cargo == Cargo::ALUNO): ?>
                    <th scope="col">Turmas matriculadas</th>
                    <th scope="col">Associar turmas</th>
                <?php endif; ?>
                <th scope="col">Editar</th>
                <th scope="col">Deletar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['nome']); ?></td>
                    <td><?= Utilidades::formataDataBr(htmlspecialchars($usuario['data_nascimento'])); ?></td>
                    <td><?= Utilidades::formataCpf(htmlspecialchars($usuario['cpf'])); ?></td>
                    <td><?= htmlspecialchars($usuario['email']); ?></td>
                    <td><?= htmlspecialchars(Cargo::getNomeCargoById($usuario['id_cargo'])); ?> </td>
                    <?php if (($cargo == Cargo::ALUNO)): ?>
                        <td><?= count($objusuario->getTurmasAssociadas($usuario['id'])) ?></td>
                        <td><a href="/associar-turmas?u=<?= $usuario['id']?>"><i class="fa fa-plus"></i></a></td>
                    <?php endif; ?>
                    <td><a href="/editar-usuario?u=<?= $usuario['id']?>"><i class="fa fa-edit"></i></a></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                            <input type="hidden" name="action" value="excluir">
                            <a class="deletar-btn" href="#" type="submit"><i class="fa fa-trash"></i></a>
                        </form>
                    </td>   
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>

        <nav aria-label="Paginação de Usuários" style="margin-bottom: 1.2em;">
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
        if (confirm('Ao confirmar, o usuário será excluído, você tem certeza?')) {
            this.closest('form').submit();
        } else {
            e.preventDefault();
        }
    })
</script>