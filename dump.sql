/* Pra criar o DB  */
CREATE DATABASE `db_secretaria_universidade` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
/* ---------------- */

/* Pra selecionar o novo banco */
USE `db_secretaria_universidade`;
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

/* Pra criar a tabela de turmas */
CREATE TABLE tb_turmas (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    descricao VARCHAR(255),
    PRIMARY KEY (id)
);
/* ---------------- */

/* Pra criar a tabela de relação entre usuario e turmas */
CREATE TABLE tb_rel_usuario_turma (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_turma INT NOT NULL,
    associado_por INT NOT NULL,
    UNIQUE KEY uk_usuario_turma (id_usuario, id_turma)
);
/* ---------------- */

/* Pra inserir o login de admin no banco de dados */
INSERT INTO db_secretaria_universidade.tb_usuarios
(id, nome, data_nascimento, cpf, email, senha, id_cargo)
VALUES(1, 'Administrador', '2003-06-13', '12345678909', 'admin@admin.com', '202cb962ac59075b964b07152d234b70', 1);
/* ---------------- */

/* Pra inserir alguns alunos de exemplo */
INSERT INTO tb_usuarios (nome, data_nascimento, cpf, email, senha, id_cargo) VALUES
('Gabriel Aluno da Silva', '2003-06-13', '111.111.111-11', 'aluno@aluno.com', '202cb962ac59075b964b07152d234b70', 2),
('Bruno Santos', '1990-10-22', '222.222.222-22', 'bruno.santos@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Carla Oliveira', '1978-01-30', '333.333.333-33', 'carla.oliveira@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Daniel Pereira', '2001-03-05', '444.444.444-44', 'daniel.pereira@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Eliana Costa', '1982-12-19', '555.555.555-55', 'eliana.costa@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Felipe Almeida', '1995-07-08', '666.666.666-66', 'felipe.almeida@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Gisele Rocha', '1975-04-12', '777.777.777-77', 'gisele.rocha@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Hugo Mendes', '1999-11-25', '888.888.888-88', 'hugo.mendes@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Ingrid Vaz', '1988-06-01', '999.999.999-99', 'ingrid.vaz@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Jorge Lima', '1970-02-14', '010.101.010-10', 'jorge.lima@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Katia Ferreira', '1993-09-03', '120.202.020-20', 'katia.ferreira@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Lucas Martins', '1980-08-17', '303.030.303-30', 'lucas.martins@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Mariana Souza', '2000-01-01', '404.040.404-40', 'mariana.souza@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Nelson Vieira', '1973-11-11', '505.050.505-50', 'nelson.vieira@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Olivia Gomes', '1997-04-28', '606.060.606-60', 'olivia.gomes@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Paulo Ribeiro', '1986-06-06', '707.070.707-70', 'paulo.ribeiro@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Quenia Barbosa', '1979-03-23', '808.080.808-80', 'quenia.barbosa@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Ricardo Nogueira', '1991-05-18', '909.090.909-90', 'ricardo.nogueira@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Sofia Ramos', '1984-12-07', '020.202.020-02', 'sofia.ramos@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Thiago Xavier', '1977-10-02', '131.313.131-31', 'thiago.xavier@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Ursula Dantas', '1998-01-13', '242.424.242-42', 'ursula.dantas@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Vicente Évora', '1989-07-29', '353.535.353-53', 'vicente.evora@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Viviane Salles', '1994-04-16', '464.646.464-64', 'viviane.salles@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Wagner Cunha', '1972-09-09', '575.757.575-75', 'wagner.cunha@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Yara Freitas', '1981-06-21', '686.868.686-86', 'yara.freitas@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Zeca Camargo', '2002-08-04', '797.979.797-97', 'zeca.camargo@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Alice Pires', '1976-02-09', '818.181.818-18', 'alice.pires@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Bernardo Dias', '1996-05-30', '929.292.929-29', 'bernardo.dias@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Clara Vasconcelos', '1983-11-03', '030.303.030-30', 'clara.vasconcelos@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Diego Torres', '1971-07-10', '141.414.141-41', 'diego.torres@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Erica Naves', '1992-04-05', '252.525.252-52', 'erica.naves@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Fernando Castro', '1987-09-20', '363.636.363-63', 'fernando.castro@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Gabriela Melo', '1974-06-27', '474.747.474-74', 'gabriela.melo@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Henrique Lemos', '2003-03-14', '585.858.585-85', 'henrique.lemos@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Iara Beltrão', '1980-12-08', '696.969.696-96', 'iara.beltrao@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('João Valente', '1995-10-26', '700.000.000-07', 'joao.valente@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Kelly Moraes', '1978-05-24', '800.000.000-08', 'kelly.moraes@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Luan Bezerra', '1991-01-07', '900.000.000-09', 'luan.bezerra@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Monica Torres', '1985-08-11', '001.001.001-01', 'monica.torres@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Nuno Sales', '2000-02-02', '002.002.002-02', 'nuno.sales@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Patrícia Rangel', '1973-04-19', '003.003.003-03', 'patricia.rangel@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Quirino Souza', '1998-09-15', '004.004.004-04', 'quirino.souza@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Renata Barros', '1986-11-28', '005.005.005-05', 'renata.barros@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Sérgio Motta', '1977-03-08', '006.006.006-06', 'sergio.motta@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Tais Medeiros', '1993-12-06', '007.007.007-07', 'tais.medeiros@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Ulisses Guedes', '1982-01-21', '008.008.008-08', 'ulisses.guedes@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Vitor Hugo', '1997-06-16', '009.009.009-09', 'vitor.hugo@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Wanda Lopes', '1975-08-25', '011.011.011-11', 'wanda.lopes@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Xico Abreu', '1990-04-09', '012.012.012-12', 'xico.abreu@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
('Yuri Zambotti', '1988-10-18', '013.013.013-13', 'yuri.zambotti@exemplo.com', 'e10adc3949ba59abbe56e057f20f883e', 2);
/* ---------------- */

/* Pra inserir turmas de exemplo */
INSERT INTO tb_turmas (nome, descricao) VALUES
('Programação Web com PHP', 'Fundamentos e práticas de desenvolvimento de aplicações web dinâmicas utilizando PHP e MySQL.'),
('Introdução à Python B', 'Conceitos básicos e intermediários de programação utilizando a linguagem Python.'),
('Redes de Computadores I', 'Fundamentos de redes, protocolos TCP/IP, e cabeamento estruturado.'),
('Banco de Dados Relacionais', 'Estudo de modelagem de dados, SQL e administração básica de SGBDs.'),
('Desenvolvimento Web Fullstack', 'Criação de aplicações web utilizando tecnologias front-end e back-end modernas.'),
('Sistemas Operacionais II', 'Análise aprofundada de gerência de processos, memória e sistemas de arquivos.'),
('Inteligência Artificial Aplicada', 'Introdução a aprendizado de máquina (Machine Learning) e redes neurais.'),
('Segurança da Informação', 'Turma que abrange criptografia, segurança de redes e prevenção contra ataques cibernéticos.'),
('Engenharia de Software Ágil', 'Metodologias ágeis, como Scrum e Kanban, e práticas de desenvolvimento de software.'),
('Arquitetura de Computadores', 'Estudo do hardware, processadores, memória e barramentos.'),
('Linguagens Formais e Autômatos', 'Teoria da computação, gramáticas e modelos de máquinas abstratas.'),
('Computação em Nuvem (Cloud)', 'Turma prática sobre serviços e arquiteturas em plataformas como AWS, Azure e GCP.'),
('Programação Orientada a Objetos', 'Conceitos de POO utilizando Java ou C# e padrões de projeto.'),
('Projeto Integrador de Software', 'Desenvolvimento de um projeto de software completo, do planejamento à entrega.'),
('Análise de Dados com R/Python', 'Foco em estatística, visualização e manipulação de grandes volumes de dados.');
/* ---------------- */

/* Pra associar turmas aos alunos */
INSERT INTO tb_rel_usuario_turma (id_usuario, id_turma, associado_por) VALUES
(2, 1, 1), (2, 3, 1), (2, 5, 1), (2, 9, 1), (2, 12, 1), (2, 15, 1),
(3, 2, 1), (3, 4, 1), (3, 6, 1), (3, 8, 1), (3, 10, 1), (3, 13, 1), (3, 14, 1),
(4, 1, 1), (4, 5, 1), (4, 7, 1), (4, 11, 1), (4, 13, 1),
(5, 2, 1), (5, 3, 1), (5, 6, 1), (5, 8, 1), (5, 10, 1), (5, 12, 1), (5, 14, 1), (5, 15, 1),
(6, 4, 1), (6, 5, 1), (6, 7, 1), (6, 9, 1), (6, 11, 1), (6, 13, 1),
(7, 1, 1), (7, 3, 1), (7, 5, 1), (7, 8, 1), (7, 10, 1), (7, 12, 1), (7, 15, 1),
(8, 2, 1), (8, 4, 1), (8, 6, 1), (8, 9, 1), (8, 14, 1),
(9, 1, 1), (9, 3, 1), (9, 5, 1), (9, 7, 1), (9, 11, 1), (9, 13, 1), (9, 14, 1), (9, 15, 1),
(10, 2, 1), (10, 4, 1), (10, 6, 1), (10, 8, 1), (10, 10, 1), (10, 12, 1),
(11, 1, 1), (11, 5, 1), (11, 9, 1), (11, 11, 1), (11, 13, 1), (11, 14, 1), (11, 15, 1),
(12, 3, 1), (12, 6, 1), (12, 7, 1), (12, 10, 1), (12, 12, 1),
(13, 1, 1), (13, 2, 1), (13, 4, 1), (13, 5, 1), (13, 8, 1), (13, 9, 1), (13, 13, 1), (13, 15, 1),
(14, 3, 1), (14, 6, 1), (14, 10, 1), (14, 11, 1), (14, 12, 1), (14, 14, 1),
(15, 1, 1), (15, 2, 1), (15, 5, 1), (15, 7, 1), (15, 8, 1), (15, 13, 1), (15, 15, 1),
(16, 4, 1), (16, 6, 1), (16, 9, 1), (16, 10, 1), (16, 14, 1),
(17, 1, 1), (17, 3, 1), (17, 5, 1), (17, 7, 1), (17, 11, 1), (17, 12, 1), (17, 13, 1), (17, 15, 1),
(18, 2, 1), (18, 4, 1), (18, 6, 1), (18, 8, 1), (18, 9, 1), (18, 14, 1),
(19, 1, 1), (19, 5, 1), (19, 7, 1), (19, 10, 1), (19, 11, 1), (19, 12, 1), (19, 13, 1),
(20, 3, 1), (20, 6, 1), (20, 9, 1), (20, 14, 1), (20, 15, 1),
(21, 1, 1), (21, 2, 1), (21, 4, 1), (21, 5, 1), (21, 8, 1), (21, 10, 1), (21, 11, 1), (21, 13, 1),
(22, 3, 1), (22, 6, 1), (22, 7, 1), (22, 9, 1), (22, 12, 1), (22, 14, 1),
(23, 1, 1), (23, 5, 1), (23, 8, 1), (23, 10, 1), (23, 13, 1), (23, 14, 1), (23, 15, 1),
(24, 2, 1), (24, 4, 1), (24, 7, 1), (24, 11, 1), (24, 12, 1),
(25, 1, 1), (25, 3, 1), (25, 6, 1), (25, 8, 1), (25, 9, 1), (25, 10, 1), (25, 13, 1), (25, 15, 1),
(26, 2, 1), (26, 4, 1), (26, 5, 1), (26, 7, 1), (26, 12, 1), (26, 14, 1),
(27, 1, 1), (27, 3, 1), (27, 6, 1), (27, 10, 1), (27, 11, 1), (27, 13, 1), (27, 15, 1),
(28, 2, 1), (28, 5, 1), (28, 8, 1), (28, 9, 1), (28, 14, 1),
(29, 1, 1), (29, 3, 1), (29, 4, 1), (29, 6, 1), (29, 7, 1), (29, 10, 1), (29, 12, 1), (29, 15, 1),
(30, 2, 1), (30, 5, 1), (30, 8, 1), (30, 11, 1), (30, 13, 1), (30, 14, 1),
(31, 1, 1), (31, 3, 1), (31, 4, 1), (31, 7, 1), (31, 9, 1), (31, 12, 1), (31, 15, 1),
(32, 2, 1), (32, 6, 1), (32, 10, 1), (32, 11, 1), (32, 14, 1),
(33, 1, 1), (33, 4, 1), (33, 5, 1), (33, 8, 1), (33, 9, 1), (33, 12, 1), (33, 13, 1), (33, 15, 1),
(34, 2, 1), (34, 3, 1), (34, 6, 1), (34, 7, 1), (34, 10, 1), (34, 14, 1),
(35, 1, 1), (35, 5, 1), (35, 8, 1), (35, 11, 1), (35, 13, 1), (35, 14, 1), (35, 15, 1),
(36, 2, 1), (36, 4, 1), (36, 7, 1), (36, 9, 1), (36, 12, 1),
(37, 1, 1), (37, 3, 1), (37, 5, 1), (37, 6, 1), (37, 10, 1), (37, 11, 1), (37, 13, 1), (37, 15, 1),
(38, 2, 1), (38, 4, 1), (38, 7, 1), (38, 8, 1), (38, 12, 1), (38, 14, 1),
(39, 1, 1), (39, 3, 1), (39, 5, 1), (39, 9, 1), (39, 10, 1), (39, 13, 1), (39, 15, 1),
(40, 2, 1), (40, 6, 1), (40, 8, 1), (40, 11, 1), (40, 14, 1),
(41, 1, 1), (41, 4, 1), (41, 5, 1), (41, 7, 1), (41, 9, 1), (41, 12, 1), (41, 13, 1), (41, 15, 1),
(42, 2, 1), (42, 3, 1), (42, 6, 1), (42, 10, 1), (42, 11, 1), (42, 14, 1),
(43, 1, 1), (43, 5, 1), (43, 8, 1), (43, 9, 1), (43, 12, 1), (43, 13, 1), (43, 15, 1),
(44, 2, 1), (44, 4, 1), (44, 7, 1), (44, 10, 1), (44, 14, 1),
(45, 1, 1), (45, 3, 1), (45, 4, 1), (45, 6, 1), (45, 8, 1), (45, 11, 1), (45, 12, 1), (45, 15, 1),
(46, 2, 1), (46, 5, 1), (46, 7, 1), (46, 9, 1), (46, 13, 1), (46, 14, 1),
(47, 1, 1), (47, 3, 1), (47, 6, 1), (47, 8, 1), (47, 10, 1), (47, 12, 1), (47, 15, 1),
(48, 2, 1), (48, 4, 1), (48, 7, 1), (48, 11, 1), (48, 14, 1),
(49, 1, 1), (49, 3, 1), (49, 5, 1), (49, 6, 1), (49, 9, 1), (49, 10, 1), (49, 13, 1), (49, 15, 1),
(50, 2, 1), (50, 4, 1), (50, 7, 1), (50, 8, 1), (50, 12, 1), (50, 14, 1),
(51, 1, 1), (51, 5, 1), (51, 6, 1), (51, 9, 1), (51, 11, 1), (51, 13, 1), (51, 15, 1);
/* ---------------- */