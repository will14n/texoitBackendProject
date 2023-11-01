
# Setup Docker Laravel 10 com PHP 8.1

### Importante: 
## 1. Aproveitando o retorno de vocês, aproveitei e deliberadamente fiz algumas melhorias na estrutura do docker e build do projeto, na estrutura de código, foi alterado somente a parte referente ao ajuste do problema apontado;
## 2. Tomei a decisão de colocar uma arquitetura hiperdimensionada para esta ocasião, apesar da simplicidade do projeto pois o objetivo é através do desafio, mostrar um pouco do meu conhecimento;
## 3. Apesar de o eloquent ter todas as características de um repository, implementei ele em uma camada de service para levar o conceito para o projeto, onde poderia ao invés de ser posssível trocar o ORM, trocar: um serviço de e-mail marketing, gatway de pagamento, sistema de log e etc, sem grandes impáctos na estrutura com a ajuda da inversão de dependência implementada;
## 4. Algumas outras features com complexidade "desnecessária" (para a simplicidade deste projeto) foram implementadas para trazer um pouco da minha visão de conhecimento, dentre elas destaco a solução apresentada para rota /api/movies/raspberry-awards, onde trouxe tudo sendo feito exclusivamente pelo banco de dados, com inclusive com sequencias de joins, left join, subquerys, talvez isso tirem um pouco de desempenho com maiores quantidades dedos, mas decidi deixar deste jeito para deixar transparente também o conhecimento com querys mais complexas e apesar da implementação não haver nenhum indice está carregando em uma boa velocidade os dados com a planilha fornecida;
## 5. Todo processo de build do composer install e cadastro de filme está sendo feito ao subir docker, portanto dependendo da quantidade de filmes a serem inseridos nos csv de testes de vocês, pode demorar algum tempo, este desempenho, tenho ciência que pode ser melhorada, porém deixei desta maneira como um case, pelas questões apontadas no item acima. 

### Passo a passo
Clone Repositório e gere o Arquivo .env
```sh
git clone https://github.com/will14n/texoitBackendProject app-laravel && cd app-laravel && cp .env.example .env
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Gere a project key do projeto Laravel
```sh
docker-compose exec app php artisan key:generate
```

Para executar os testes, é necessário entrar no Docker
```sh
docker-compose exec app ./vendor/bin/phpunit
```

### Obs.: O arquivo csv que popula o banco, está localizado na pasta /storage/imports

Acesse o projeto
[http://localhost:8989/api/movies/raspberry-awards](http://localhost:8989/api/movies/raspberry-awards)
