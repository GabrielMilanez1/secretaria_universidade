/* Pra criar o DB  */
CREATE DATABASE `db_secretaria_universidade` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
/* ---------------- */

/* Pra criar a tabela de usuários */
CREATE TABLE `tb_usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `data_nascimento` date NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `id_cargo` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/* ---------------- */

/* Pra criar a tabela de cargos */
CREATE TABLE tb_cargos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL UNIQUE
);
/* ---------------- */

/* Insere os cargos na tabela de cargos */
INSERT INTO db_secretaria_universidade.tb_cargos
(id, nome)
VALUES(1, 'Administrador');
INSERT INTO db_secretaria_universidade.tb_cargos
(id, nome)
VALUES(2, 'Aluno');
/* ---------------- */