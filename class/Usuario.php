<?php

require_once 'MysqliClass.php';
require_once 'Validators.php';
require_once 'RelUsuarioTurma.php';

class Usuario
{

    private $tabela = 'tb_usuarios';
    
    private $colunas_editaveis = [
        'nome' => 's',
        'data_nascimento' => 's',
        'id_cargo' => 'i'
    ];

    public function getNomeTabela()
    {
        return $this->tabela;
    }

    public function deletarUsuario($id_usuario)
    {
        $db = new MysqliClass();
        $objrelusuarioturma = new RelUsuarioTurma();

        $query = <<<SQL
            DELETE FROM $this->tabela WHERE id = ?;
        SQL;

        $id_usuario = Validators::validaId($id_usuario);

        $stmt = $db->getMysqliConnection()->prepare($query);
        $stmt->bind_param("i", $id_usuario);

        $stmt->execute();

        $linhas_afetadas = $stmt->affected_rows;

        if ($linhas_afetadas > 0) {
            
            // Deleta também associação em turmas
            $objrelusuarioturma->deletaAssociacoesPeloIdUsuario($id_usuario);

            return ['sucesso' => true, 'mensagem' => 'Usuário excluído com sucesso.'];
        }

        return ['sucesso' => false, 'mensagem' => 'Erro ao deletar.'];

    }

    public function getTurmasAssociadas($id_usuario)
    {
        $objturmasassociadas = new RelUsuarioTurma();

        $db = new MysqliClass();

        $tabela = $objturmasassociadas->getNomeTabela();

        $query = <<<SQL
            SELECT * FROM `$tabela` WHERE `id_usuario` = $id_usuario GROUP BY `id_turma`
        SQL;

        $turmas_associadas = $db->getResultsQuery($query);
        if (count($turmas_associadas) <= 0) {
            return [];
        }

        return $turmas_associadas;
    }

    public function editar($id_usuario, array $parametros)
    {
        $parametros_aceitos = $this->colunas_editaveis;

        $dados_para_atualizar = array_intersect_key($parametros, $parametros_aceitos);

        try {
            // Validações
            if (isset($dados_para_atualizar['nome']) && !empty($dados_para_atualizar['nome'])) {
                $dados_para_atualizar['nome'] = Validators::validaNome($dados_para_atualizar['nome']);
            }
            if (isset($dados_para_atualizar['data_nascimento']) && !empty($dados_para_atualizar['data_nascimento'])) {
                $dados_para_atualizar['data_nascimento'] = Validators::validaDataNascimento($dados_para_atualizar['data_nascimento']);
            }
            if (isset($dados_para_atualizar['id_cargo']) && !empty($dados_para_atualizar['id_cargo'])) {
                $dados_para_atualizar['id_cargo'] = Validators::validaIdCargo($dados_para_atualizar['id_cargo']);
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
        $dados_para_atualizar['id'] = $id_usuario;

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
                return ['sucesso' => true, 'mensagem' => 'Usuário atualizado com sucesso.'];
            } else {
                return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar usuário.'];
            }

        } catch (\Exception $e) {
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar usuário.'];
        }
    }

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

        return ['sucesso' => false, 'mensagem' => 'Erro ao salvar, verifique se todas informações foram preenchidas ou se o CPF/Email já estão sendo utilizados.'];
    }

    public function getByEmail($email)
    {
        $db = new MysqliClass();
        $query = <<<SQL
            SELECT * FROM `$this->tabela` WHERE `email` = '$email' LIMIT 1
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
            SELECT * FROM `$this->tabela` WHERE `id` = '$id' LIMIT 1
        SQL;

        $usuario = $db->getResultsQuery($query);
        if (count($usuario) <= 0) {
            return false;
        }

        return $usuario[0];
    }
  
}