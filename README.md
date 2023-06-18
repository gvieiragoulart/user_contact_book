<h1>Projeto de Agenda de Contatos</h1>
Este projeto é uma aplicação de Agenda de Contatos, desenvolvida com o objetivo de permitir que os usuários gerenciem seus contatos de forma simples e eficiente.

<h2>Documentação</h2>
A documentação completa do projeto pode ser encontrada <a href="http://localhost:8000/docs/index.html">aqui</a>(O projeto precisa estar de pé). Ela contém informações detalhadas sobre os endpoints da API, os parâmetros esperados, as respostas retornadas e exemplos de uso.

Certifique-se de consultar a documentação para entender como utilizar corretamente a API e explorar todas as funcionalidades oferecidas pelo sistema.

<h2>Configuração</h2>
Para configurar e executar o projeto em seu ambiente local, siga as etapas abaixo:

Clone o repositório para sua máquina local:
<code class="language-bash">
git clone https://github.com/gvieiragoulart/user_contact_book.git
</code>

Acesse o diretório do projeto:

<code class="language-bash">
cd user_contact_book
</code>

Atualize o arquivo .env com as informações de configuração necessárias, como credenciais do banco de dados e outras configurações específicas do ambiente.

Certifique-se de que o script start.sh tenha permissões de execução. Caso não tenha, execute o seguinte comando:

<code class="language-bash">
chmod +x start.sh
</code>

Execute o script start.sh para iniciar o projeto:

<code class="language-bash">
./start.sh
</code>

O script start.sh cuidará de todas as etapas necessárias para iniciar a aplicação, incluindo a instalação das dependências, a configuração do banco de dados e a execução dos migrations.

Após a execução do script, o sistema estará disponível no endereço http://localhost:8000.
