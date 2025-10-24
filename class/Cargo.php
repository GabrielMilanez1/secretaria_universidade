<?php

require_once 'MysqliClass.php';

class Cargo
{

  const ADMINISTRADOR = 1;
  const ALUNO = 2;

  private static $tabela = 'tb_cargos';

  public static function getCargos()
  {
    $db = new MysqliClass();
    $tabela = self::$tabela;
    $query = <<<SQL
        SELECT * FROM `$tabela`
    SQL;

    $cargos = $db->getResultsQuery($query);
    if (count($cargos) <= 0) {
        return [];
    }

    return $cargos;
  }

  public static function getNomeCargoById(int $id)
  {
    $db = new MysqliClass();
    $tabela = self::$tabela;
    $query = <<<SQL
        SELECT `nome` FROM `$tabela` WHERE `id` = $id
    SQL;

    $cargo = $db->getResultsQuery($query);
    if (count($cargo) <= 0) {
        return false;
    }

    return $cargo[0]['nome'];
  }

  public static function idsCargosDisponiveis()
  {
    $retorno = [];
    foreach (self::getCargos() as $cargo) {
      $retorno[] = $cargo['id'];
    }

    return $retorno;
  }
  
}