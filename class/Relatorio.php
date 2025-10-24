<?php

require_once 'MysqliClass.php';
require_once 'Validators.php';
require_once 'Turma.php';
require_once 'Usuario.php';
require_once 'Cargo.php';

class Relatorio
{

  public static function getUsuariosPorCargo(int $cargo_aluno, $pagina = 1, $nome_aluno = false)
  {
    $db = new MysqliClass();

    $objusuario = new Usuario();

    $tabela = $objusuario->getNomeTabela();

    $query = <<<SQL
        SELECT * FROM `$tabela`
        WHERE `id_cargo` = $cargo_aluno
    SQL;

    $itens_por_pagina = 10;
    $pagina = max(1, (int)$pagina); 
    $offset = ($pagina - 1) * $itens_por_pagina;
    
    $tipos = '';
    $params = [];

    if (isset($nome_aluno) && !empty($nome_aluno)) {
        $nome_aluno_limpo = strip_tags(trim($nome_aluno));

        $query .= " AND `nome` LIKE ?";
        
        $params[] = "%{$nome_aluno_limpo}%";

        $tipos .= "s";
    }

    $query .= <<<SQL
      ORDER BY `nome`
      LIMIT $itens_por_pagina OFFSET $offset
    SQL;

    $usuarios = $db->getResultsPreparedQuery($query, $tipos, $params);

    if (count($usuarios) <= 0) {
        return [];
    }

    return $usuarios;
  
  }
  
  
}