<p align="center"><img src="http://www.tre-rr.jus.br/imagens/fotos/tre-rr-pesquisa-eleitoral-falsa/@@images/659d9cd6-c23a-4a3b-860a-9ae16467c873.jpeg" width="400"></p>

<p align="center">
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
</p>

## Laravel 7 - Diagnóstico PERGUNTA/RESPOSTA

Painel administrativo para pesquisa de diagnóstico:<br />
* Diagnóstico<br />
* Perguntas do Diagnóstico<br />
* Categoria da Pergunta  <br />
* Opções da Pergunta<br />
* Respostas da Pergunta (podendo ser uma opção da pergunta ou descrição)<br />
* Cadastro de Usuário<br />
* ACL (controle de acesso completo: cargos e permissões dos usuários)<br />

* Cruzamento de Perguntas Selecionadas<br />
<p align="center"><img src="public/img/screens/cruzamento.png" >
</p>

* Funil das Respostas Selecionadas<br />
<p align="center"><img src="public/img/screens/funil.png" >
</p>

* Gŕaficos Pizza e Barra das Perguntas e Respostas<br />
<p align="center"><img src="public/img/screens/chart.png" >
</p>

Com API completa para fazer todas as funções tambem.

## Instalação (comandos)

git clone https://github.com/lucianopalhares/pesquisaGapol.git

composer install

verifique se existe o arquivo .env se nao existir faça uma copia de .env.example com o nome .env

php artisan key:generate

crie um banco de dados com o nome que desejar

preencha o arquivo .env com os dados do banco de dados na linha:

DB_CONNECTION=mysql<br />
DB_HOST=127.0.0.1<br />
DB_PORT=3306<br />
DB_DATABASE=nomedobancodedados<br />
DB_USERNAME=usuariodobancodedados<br />
DB_PASSWORD=senhadobancodedados

arquivo sql para preencher banco de dados: database/data.sql

Se os diretorios abaixo nao existirem devem ser criados com permissão para gravar.

## Projeto Original

https://pesquisa.gapol.com.br

## DEMO

http://pesquisa.desenvolve.tk
usuário: admin@admin.como
senha: 12345678

## License

[MIT license](https://opensource.org/licenses/MIT).
