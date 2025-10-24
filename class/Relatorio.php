<?php

require_once 'MysqliClass.php';
require_once 'Validators.php';
require_once 'Turma.php';
require_once 'Usuario.php';
require_once 'Cargo.php';
require_once 'RelUsuarioTurma.php';

class Relatorio
{

    const POR_PAGINA = 10;

    public static function getTotalUsuariosPorCargo($id_cargo)
    {
        $db = new MysqliClass();

        $objusuario = new Usuario();

        $tabela = $objusuario->getNomeTabela();

        $query = <<<SQL
            SELECT count(distinct `id`) as `total` FROM `$tabela`
            WHERE `id_cargo` = $id_cargo
        SQL;

        $quantidade = $db->getResultsQuery($query);

        if (count($quantidade) <= 0) {
            return 0;
        }

        return $quantidade[0]['total'];
    }

    public static function getTotalTurmas()
    {
        $db = new MysqliClass();

        $objturma = new Turma();

        $tabela = $objturma->getNomeTabela();

        $query = <<<SQL
            SELECT count(distinct `id`) as `total` FROM `$tabela`
        SQL;

        $quantidade = $db->getResultsQuery($query);

        if (count($quantidade) <= 0) {
            return 0;
        }

        return $quantidade[0]['total'];
    }

    public static function getUsuariosPorCargo(int $id_cargo, $pagina = 1, $nome_aluno = false)
    {
        $db = new MysqliClass();

        $objusuario = new Usuario();

        $tabela = $objusuario->getNomeTabela();

        $query = <<<SQL
            SELECT * FROM `$tabela`
            WHERE `id_cargo` = $id_cargo
        SQL;

        $itens_por_pagina = self::POR_PAGINA;
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

    public static function getTurmas($pagina = 1, $nome_turma = false)
    {
        $db = new MysqliClass();

        $objturma = new Turma();

        $tabela = $objturma->getNomeTabela();

        $query = <<<SQL
            SELECT * FROM `$tabela`
        SQL;

        $itens_por_pagina = self::POR_PAGINA;
        $pagina = max(1, (int)$pagina); 
        $offset = ($pagina - 1) * $itens_por_pagina;

        $tipos = '';
        $params = [];

        if (isset($nome_turma) && !empty($nome_turma)) {
            $nome_turma_limpa = strip_tags(trim($nome_turma));

            $query .= " WHERE `nome` LIKE ?";
            
            $params[] = "%{$nome_turma_limpa}%";

            $tipos .= "s";
        }

        $query .= <<<SQL
            ORDER BY `nome`
            LIMIT $itens_por_pagina OFFSET $offset
        SQL;

        $turmas = $db->getResultsPreparedQuery($query, $tipos, $params);

        if (count($turmas) <= 0) {
            return [];
        }

        return $turmas;
    }

    public static function getAlunosMatriculados($id_turma, $pagina)
    {

        $db = new MysqliClass();

        $objrelusuarioturma = new RelUsuarioTurma();
        $objusuario = new Usuario();

        $tabela_rel_usuario_turma = $objrelusuarioturma->getNomeTabela();
        $tabela_usuario = $objusuario->getNomeTabela();

        $itens_por_pagina = self::POR_PAGINA;
        $pagina = max(1, (int)$pagina); 
        $offset = ($pagina - 1) * $itens_por_pagina;
        
        $query = <<<SQL
            SELECT {$tabela_usuario}.* FROM $tabela_rel_usuario_turma 
            INNER JOIN {$tabela_usuario} ON {$tabela_usuario}.id = {$tabela_rel_usuario_turma}.id_usuario
            WHERE {$tabela_rel_usuario_turma}.id_turma = $id_turma
            GROUP BY {$tabela_usuario}.id
            ORDER BY {$tabela_usuario}.nome
            LIMIT $itens_por_pagina OFFSET $offset
        SQL;

        $usuarios = $db->getResultsQuery($query);

        if (count($usuarios) <= 0) {
            return [];
        }

        return $usuarios;
    }

    public static function getTurmasDoUsuario($id_usuario, $pagina)
    {
        $db = new MysqliClass();

        $objturma = new Turma();
        $objrelusuarioturma = new RelUsuarioTurma();

        $tabela_rel_usuario_turma = $objrelusuarioturma->getNomeTabela();
        $tabela_turma = $objturma->getNomeTabela();

        $itens_por_pagina = self::POR_PAGINA;
        $pagina = max(1, (int)$pagina);
        $offset = ($pagina - 1) * $itens_por_pagina;

        $query = <<<SQL
            SELECT {$tabela_turma}.* FROM {$tabela_rel_usuario_turma}
            INNER JOIN {$tabela_turma} ON {$tabela_turma}.id = {$tabela_rel_usuario_turma}.id_turma
            WHERE {$tabela_rel_usuario_turma}.id_usuario = $id_usuario
            GROUP BY {$tabela_turma}.id
            ORDER BY {$tabela_turma}.nome
            LIMIT $itens_por_pagina OFFSET $offset
        SQL;

        $turmas = $db->getResultsQuery($query);

        if (count($turmas) <= 0) {
            return [];
        }

        return $turmas;
    }

  
}