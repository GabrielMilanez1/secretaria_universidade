<?php

require_once 'MysqliClass.php';
require_once 'Validators.php';
require_once 'RelUsuarioTurma.php';


class Turma
{

    private $tabela = 'tb_turmas';

    private $colunas_editaveis = [
        'nome' => 's',
        'descricao' => 's',
    ];

    public function getNomeTabela()
    {
        return $this->tabela;
    }

    public function getUsuariosAssociados($id_turma)
    {
        $objturmasassociadas = new RelUsuarioTurma();
        
        $db = new MysqliClass();

        $tabela = $objturmasassociadas->getNomeTabela();

        $query = <<<SQL
            SELECT * FROM `$tabela` WHERE `id_turma` = $id_turma GROUP BY `id_usuario`
        SQL;

        $usuario_associados = $db->getResultsQuery($query);
        if (count($usuario_associados) <= 0) {
            return [];
        }

        return $usuario_associados;
    }

    public function getTurmas()
    {
        $db = new MysqliClass();
        $tabela = $this->tabela;

        $query = <<<SQL
            SELECT * FROM `$tabela` ORDER BY `nome`
        SQL;

        $turmas = $db->getResultsQuery($query);
        if (count($turmas) <= 0) {
            return [];
        }

        return $turmas;
    }

    public function editar($id_turma, array $parametros)
    {
        $parametros_aceitos = $this->colunas_editaveis;

        $dados_para_atualizar = array_intersect_key($parametros, $parametros_aceitos);

        try {
            // Validações
            if (isset($dados_para_atualizar['nome']) && !empty($dados_para_atualizar['nome'])) {
                $dados_para_atualizar['nome'] = Validators::validaNomeTurma($dados_para_atualizar['nome']);
            }
            if (isset($dados_para_atualizar['descricao']) && !empty($dados_para_atualizar['descricao'])) {
                $dados_para_atualizar['descricao'] = Validators::validaDescricaoTurma($dados_para_atualizar['descricao']);
            }
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => $e->getMessage()
            ];
        }

        if (empty($dados_para_atualizar)) {
            return false;
        }

        $tipos = '';
        $query = "UPDATE `$this->tabela` SET ";

        foreach ($dados_para_atualizar as $coluna => $valor) {
            $query .= "`$coluna` = ?,";
            $tipos .= $parametros_aceitos[$coluna];
        }

        $query = rtrim($query, ',') . " WHERE `id` = ?";
        $tipos .= 'i';
        $dados_para_atualizar['id'] = $id_turma;

        try {
            $db = new MysqliClass();
            $stmt = $db->getMysqliConnection()->prepare($query);

            $params = [];
            foreach ($dados_para_atualizar as $key => $value) {
                $params[] = &$dados_para_atualizar[$key];
            }

            array_unshift($params, $tipos);
            call_user_func_array([$stmt, 'bind_param'], $params);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return ['sucesso' => true, 'mensagem' => 'Turma atualizada com sucesso.'];
            } else {
                return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar turma.'];
            }

        } catch (\Exception $e) {
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar turma.'];
        }
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

    public function getById($id)
    {
        $db = new MysqliClass();
        $query = <<<SQL
            SELECT * FROM `$this->tabela` WHERE `id` = '$id' LIMIT 1    
        SQL;

        $usuario = $db->getResultsQuery($query);
        if (count($usuario) <= 0) {
            return false;
        }

        return $usuario[0];
    }
  
}