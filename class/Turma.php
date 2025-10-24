<?php

require_once 'MysqliClass.php';
require_once 'Validators.php';

class Turma
{

  private $tabela = 'tb_turmas';

  public function getNomeTabela()
  {
    return $this->tabela;
  }

  public function salvar($nome, $descricao)
  {
    $db = new MysqliClass();
    $query = <<<SQL
      INSERT INTO `$this->tabela` (`nome`, `descricao`) VALUES (?, ?)
    SQL;

    // Validações
    try {

        $nome = Validators::validaNomeTurma($nome);
        $descricao = Validators::validaDescricaoTurma($descricao);

    } catch (\Exception $e) {
        return [
            'sucesso' => false,
            'mensagem' => $e->getMessage()
        ];

    }

    $stmt = $db->getMysqliConnection()->prepare($query);
    $stmt->bind_param("ss", $nome, $descricao);

    $insert = $stmt->execute();

    if ($insert) {
        return ['sucesso' => true, 'mensagem' => 'Turma inserida com sucesso.'];
    }

    return ['sucesso' => false, 'mensagem' => 'Erro ao salvar, verifique se todas informações foram preenchidas.'];
  }
  
}