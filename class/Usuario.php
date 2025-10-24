<?php

require_once 'MysqliClass.php';
require_once 'Utilidades.php';
require_once 'Validators.php';

class Usuario
{

  private $tabela = 'tb_usuarios';

  public function salvar($nome, $data_nascimento, $cpf, $email, $senha, $id_cargo)
  {
    $db = new MysqliClass();
    $query = <<<SQL
      INSERT INTO `$this->tabela` (`nome`, `data_nascimento`, `cpf`, `email`, `senha`, `id_cargo`) VALUES (?, ?, ?, ?, ?, ?)
    SQL;

    // Validações
    try {

        $nome = Validators::validaNome($nome);
        $data_nascimento = Validators::validaDataNascimento($data_nascimento);
        $cpf = Validators::validaCpf($cpf);
        $email = Validators::validaEmail($email);
        $senha = Validators::validaSenha($senha);
        $id_cargo = Validators::validaIdCargo($id_cargo);

    } catch (\Exception $e) {
        return [
            'sucesso' => false,
            'mensagem' => $e->getMessage()
        ];

    }

    $stmt = $db->getMysqliConnection()->prepare($query);
    $stmt->bind_param("sssssi", $nome, $data_nascimento, $cpf, $email, $senha, $id_cargo);

    $insert = $stmt->execute();

    if ($insert) {
        return ['sucesso' => true, 'mensagem' => 'Usuário inserido com sucesso.'];
    }

    return ['sucesso' => false, 'mensagem' => 'Erro ao salvar, contate um administrador.'];
  }

  public function getByEmail($email)
  {
    $db = new MysqliClass();
    $query = <<<SQL
        SELECT * FROM `$this->tabela` WHERE `email` = '$email'
    SQL;

    $usuario = $db->getResultsQuery($query);
    if (count($usuario) <= 0) {
        return false;
    }

    return $usuario[0];
  }

  public function getById($id)
  {
    $db = new MysqliClass();
    $query = <<<SQL
        SELECT * FROM `$this->tabela` WHERE `id` = $id
    SQL;

    $usuario = $db->getResultsQuery($query);

    if (count($usuario) <= 0) {
        return false;
    }

    return $usuario[0];
  }
  
}