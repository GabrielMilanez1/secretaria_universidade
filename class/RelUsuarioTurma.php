<?php

require_once 'MysqliClass.php';
require_once 'Validators.php';
require_once 'Usuario.php';
require_once 'Turma.php';


class RelUsuarioTurma
{

    private $tabela = 'tb_rel_usuario_turma';

    public function getNomeTabela()
    {
        return $this->tabela;
    }

    public function salvarAssociacoes($id_usuario, array $turmas_pra_associar, $id_usuario_responsavel)
    {
        if (count($turmas_pra_associar) <= 0) {
            return ['sucesso' => false, 'mensagem' => 'Nenhuma turma selecionada.'];
        }

        $objusuario = new Usuario();
        $objturma = new Turma();

        $turmas_disponiveis = [];
        
        foreach ($objturma->getTurmas() as $turma_disponivel) {
            $turmas_disponiveis[] = $turma_disponivel['id'];
        }

        $backup_turmas = [];
        foreach ($objusuario->getTurmasAssociadas($id_usuario) as $turma_associada) {
            $backup_turmas[] = $turma_associada['id_turma'];
        }

        // Deleta associações atuais
        $this->deletaAssociacoesPeloIdUsuario($id_usuario);
        // -------------------------

        $erro = false;
        foreach ($turmas_pra_associar as $turma) {

            $turma = Validators::validaId($turma);

            if (!in_array($turma, $turmas_disponiveis)) {
                $this->deletaAssociacoesPeloIdUsuario($id_usuario);

                foreach ($backup_turmas as $turma_backup) {
                    $this->criaAssociacao($id_usuario, $turma_backup, $id_usuario_responsavel);
                }
                
                return ['sucesso' => false, 'mensagem' => 'Turma inválida.'];
            }

            $insert = $this->criaAssociacao($id_usuario, $turma, $id_usuario_responsavel);

            if (!$insert) {
                $erro = true;
                break;
            }
        }

        if ($erro) {
            foreach ($backup_turmas as $turma_backup) {
                $this->criaAssociacao($id_usuario, $turma_backup, $id_usuario_responsavel);
            }

            return ['sucesso' => false, 'mensagem' => 'Ocorreu um erro ao associar as turmas. Tente novamente.'];
        }

        return ['sucesso' => true, 'mensagem' => 'Turmas associadas com sucesso.'];

    }

    private function criaAssociacao($id_usuario, $id_turma, $id_usuario_responsavel)
    {
        $db = new MysqliClass();

        $query = <<<SQL
            INSERT INTO `$this->tabela` (`id_usuario`, `id_turma`, `associado_por`) VALUES (?, ?, ?)
        SQL;

        $stmt = $db->getMysqliConnection()->prepare($query);
        $stmt->bind_param("iii", $id_usuario, $id_turma, $id_usuario_responsavel);
        $insert = $stmt->execute();

        if (!$insert) {
            return false;
        }

        return true;
    }        

    public function deletaAssociacoesPeloIdUsuario($id_usuario)
    {
        $db = new MysqliClass();

        $query = <<<SQL
            DELETE FROM `$this->tabela` WHERE `id_usuario` = $id_usuario
        SQL;

        $stmt = $db->getMysqliConnection()->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
    }

    public function deletaAssociacoesPeloIdTurma($id_turma)
    {
        $db = new MysqliClass();

        $query = <<<SQL
            DELETE FROM `$this->tabela` WHERE `id_turma` = $id_turma
        SQL;

        $stmt = $db->getMysqliConnection()->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
    }
    
}