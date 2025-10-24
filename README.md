# Secretaria de universidade
Sistema web para secretaria de uma universidade, desenvolvido para ajudar na gestão de alunos e suas turmas

O sistema funciona diferente para administradores e alunos, um informativo pra alunos e um gerenciador pra administradores

# Configuração de vhost
```
<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/html/secretaria_universidade/
	ServerName uniadm.test
	
</VirtualHost>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
```
# Dump do MySQL
O arquivo dump.sql possui todos os scripts pra criação do banco de dados e tabelas necessárias pra rodar o projeto, além de também inserir registros pra servirem como demonstração do sistema. 
Dentre os registros a ser inseridos, também está o login de administrador que pode ser acessado com:

Email - admin@admin.com
Senha - 123