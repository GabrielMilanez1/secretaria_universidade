<?php
require_once '../session/session_start.php';
require_once '../header.php';

require_once '../class/Cargo.php';
require_once '../class/Usuario.php';

if (!$admin) {
  header('location: /');
  exit();
}

if ($_POST) {

    $_GET = [];
    $falha = false;

    if (isset($_POST['nome']) 
        && isset($_POST['data_nascimento']) 
        && isset($_POST['cpf']) 
        && isset($_POST['email']) 
        && isset($_POST['senha']) 
        && isset($_POST['id_cargo'])
    ) {

        $usuario = new Usuario();

        $insert = $usuario->salvar(
            $_POST['nome'],
            $_POST['data_nascimento'],
            $_POST['cpf'],
            $_POST['email'],
            $_POST['senha'],
            $_POST['id_cargo']
        );

        if ($insert['sucesso'] == true) {
            $url_atual = $_SERVER['PHP_SELF'];
            header("location: {$url_atual}?s=1");
            exit();
        } else {
            $mensagem_erro = $insert['mensagem'];
            $falha = true;
        }

    }

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
<title>Página Inicial | Adicionar usuário</title>
</head>

<body>

<?php if (isset($_GET['s']) && $_GET['s'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Sucesso!</strong> Usuário cadastrado com sucesso. 🎉
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
                <h4 class="mb-0">Adicionar novo usuário</h4>
            </div>
            <div class="card-body">
                
                <form method="post">

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" maxlength=30 id="nome" name="nome" 
                            placeholder="Digite o nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" 
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF (Apenas números)</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" 
                            placeholder="Ex: 12345678909" required 
                            maxlength="11">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" 
                            placeholder="nome@exemplo.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" 
                            placeholder="Mínimo 6 caracteres" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_cargo" class="form-label">Cargo</label>
                        <select class="form-select" id="id_cargo" name="id_cargo" required>
                            <option value="" selected>Selecione um cargo</option>
                            
                            <?php
                                $cargos = Cargo::getCargos();

                                foreach ($cargos as $cargo) {
                                    echo "<option value='{$cargo['id']}'>{$cargo['nome']}</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-warning btn-lg">Cadastrar usuário</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>

<?php require_once '../footer.php';