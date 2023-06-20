<h1>Projeto de Agenda de Contatos</h1>
Este projeto é uma aplicação de Agenda de Contatos, desenvolvida com o objetivo de permitir que os usuários gerenciem seus contatos de forma simples e eficiente.

O mesmo consiste em dois micro-serviços, um que cadastra o usuário com autenticação JWT e faz o CRUD de seus contatos, o outro faz o envio de emails. O projeto utiliza a fila SQS para realizar o envio de emails de forma assíncrona.

<h2>Documentação</h2>
A documentação completa do projeto pode ser encontrada <a href="http://localhost:8000/docs/index.html">aqui</a>(O projeto precisa estar de pé). Ela contém informações detalhadas sobre os endpoints da API, os parâmetros esperados, as respostas retornadas e exemplos de usos.

Na raiz do projeto temos um exemplo para se usar no insomnia caso prefira.

<h2>Configuração</h2>
Para configurar e executar o projeto em seu ambiente local, siga as etapas abaixo:

Clone o repositório para sua máquina local:
```bash
git clone https://github.com/gvieiragoulart/user_contact_book.git
```

Acesse o diretório do projeto:

```bash
cd user_contact_book
```

Atualize o arquivo .env dos dois projetos com as informações de configuração necessárias, como credenciais do banco de dados e outras configurações específicas do ambiente. Deixei alguns exemplos no .env.example caso prefira.

Certifique-se de que o script start.sh tenha permissões de execução. Caso não tenha, execute o seguinte comando:

```bash
chmod +x start.sh
```

Execute o script start.sh para iniciar o projeto:

```bash
./start.sh
```

O script start.sh cuidará de todas as etapas necessárias para iniciar a aplicação, incluindo a instalação das dependências, a configuração do banco de dados e a execução dos migrations.

Após a execução do script, o sistema estará disponível no endereço http://localhost:8000.

<h3>Configurações adicionais</h3>
Caso queira visualizar os logs, acesse o diretório elk e rode o comando <code class="language-bash">docker-compose up -d</code>, ele subira o elastic search,kibana e o logstash, não deixei ele no start.sh pois o mesmo é muito pesado e demorado para subir.

<h2>Sobre o projeto</h2>
A aplicação user_contact_book, utiliza autenticação JWT, após registrar um usuário é enviado uma mensagem para a fila SQS, o qual nosso sistema user-contacts-listener(que é um sistema de PHP "puro") analisa e envia o email. Para email, eu utilizei o Mailtrap(https://mailtrap.io/) para testes(todas as configurações estão no .env).

Após um usuário se registrar, ele pode cadastrar novos contatos, com número, email, nome e imagem. A imagem é salva na S3.

SQS e S3 são simulados com o serviço localstack, que simula serviços da AWS. É utilizado o SDK PHP da AWS.

O projeto user-contacts é escrito seguindo Clean Code, aplicando patterns como Repository, UseCase,Interface, Domain, Entity, etc..
O projeto também contém testes unitários, features e e2e.
