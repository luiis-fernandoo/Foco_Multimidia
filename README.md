O sistema tem como objetivo o gerenciamento de hoteis, quartos e reservas. Onde é possível o cadastro de hoteis, quartos e reservas (esse por meio de arquivos xml), bem como deletar. Os quartos são editaveis. 
O sistema possui um comando chamado "cronPriceRoom" que ficou encarregado de ser executado todos os dias para realizar a verificação da data corrente para alteração dos preços dos quartos, ou seja, essa função em determinada data muda em porcentagem o preço dos hoteis. 
O sistema possui telas web para que seja possivel não só a visualização dos dados bem como as opções de cadastro, edição e exclusão.
Os cadastro de reservas são feitos atraves de xml, o modelo usado foi o disponibilizado pela empresa, assim, inserindo o mesmo xml (com o banco de dados vazio por causa do ids que podem dar conflito) o cadastro já estará realizado.
A modelagem do banco de dados foi realizada totalmente pelo eloquent laravel e suas migrations.Para fazer a junção de todas as tabelas foi usada a opção foreign Key para todas as tabelas.

Para executar o programa o usuário irá precisar:

Linguagem PHP: https://www.php.net/downloads

Composer: que é um gerenciador de dependências para php https://getcomposer.org/download/

Um Sistema gerenciador de banco de dados e pronto.

Após isso, no terminal do vsCode, dentro da pasta do projeto, execute php artisan serve

A pagina inicial contém todos os hoteis gerenciados pelo sistema, nessa tabela ainda é possível adicionar Hoteis e Reservas.
Como dito anteriormente, a forma de cadastro de reserva é feito através de arquivos xmls contendo hotel e quarto que estarão sendo ocupados na reserva. 

Ainda na tabela principal, há o botão de detahes do Hotel, esse botão redireciona a pagina de detalhes, essa pagina contém todas as informações de determinado hotel, com os quartos que aquele hotel possui, o preço de sua diaria e as opões de edição e exclusão.

Abaixo da tabela de quartos há a tabela de todas as reservas relacionadas ao hotel e seus quartos, onde também é possível deletar a reserva caso queira.
 
O sistema foi totalmente construido no modelo Api Rest, onde foi utilizado somente uma rota, a ApiResource, que pelo method de requisição consegue identificar qual o método que ele está solicitando.

O cadastro do xml foi feito atraves da inserção de arquivo pelo lado cliente do sistema e é salvo nas pastas do sistema para ser recuperado e salvo no banco de dados.


Dos requisitos e diferenciais propostos pela empresa, foi realizado as seguintes exigencias:


- Documentação explicando os processos bem como comentarios ao lado do codigo

- Realizar a modelagem de banco de dados com base nos xml's 

- Desenvolvimento de script para a importação do xml e persistencia dos dados no banco

- CRON para execução de linhas de codigo para serem executadas diariamente.

- Crud por meio da api rest de quartos

- POST de reserva por meio da api Rest (A inserçao do xml para cadastrar a reserva é feita atravez do method post via api rest)

- Testes automatizados PHPUnit

- Padrões de Projeto

- HTTP verbs (GET, POST, UPDATE, DELETE)


