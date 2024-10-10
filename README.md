# carefy-

Este projeto foi gerado com Laravel 11 e Mysql.

## Servidor

php artisan serve

### Tela inicial

Contém um botão responsável por efetuar o upload e leitura dos dados no formato CSV.
Abaixo contém um botão (GRAVAR CSV) responsável por efetuar a gravação dos dados no banco de dados.
Ao final do processo de importação e gravação dos dados, o sistema informa a quantidade de pacientes inseridos.

### Tela Pacientes

Contém a lista de todos os pacientes gravados no banco de dados.

### Validações do arquivo CSV que não serão cadastradas no sistema

Pacientes com o mesmo NOME e NASCIMENTO, porém com CODIGO divergente de um cadastrado previamente.
Internações com o mesmo código da GUIA de internação.
Internações com a data de ENTRADA inferior a data de NASCIMENTO do paciente.
Internações com a data de SAIDA inferior ou igual a data de ENTRADA.

### Banco de dados

Para gravação e consulta dos dados, está sendo utilizado servidor em nuvem.
