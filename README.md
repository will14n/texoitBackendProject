
# Setup Docker Laravel 10 com PHP 8.1

### Importante: 
## 1. Aproveitando o retorno que me vocês me passaram, aproveitei e deliberadamente fiz algumas melhorias na estrutura do docker e build do projeto
## 2. Tomei a decisão de colocar uma arquitetura hiperdimensionada para esta ocasião, apesar da simplicidade do projeto pois meu objetivo era demonstrar um pouco do meu conhecimento
## 3. Apesar de o eloquent ter todas as características de um repository, implementei ele em uma camada de service para levar o conceito para o projeto, onde poderia ao invés de ser posssível trocar o eloquent, substuir um serviço de disparo de e-mail, gatway de pagamento, log e etc por outro sem grandes impáctos na estrutura com a ajuda da inversão de dependência aplicada
## 4. Algumas outras features com complexidade "desnecessária" (para a simplicidade deste projeto) foram implementadas para trazer uma visão global de conhecimento da minha parte, dentre elas destaco a solução apresentada no cadastro de filmes, produtores e studio, onde trouxe tudo sendo feito exclusivamente pelo banco de dados, com inclusive com sequencias de joins, left join, subquerys, isso sacrificou o desempenho, mas decidi deixar deste jeito para deixar transparente para vocês também o conhecimento com querys
## 5. Todo processo de build do composer install e cadastro de filme está sendo feito ao subir docker, portanto dependendo da quintidade de filmes a serem inseridos nos csv de testes de vocês, pode demorar algum tempo, este desempenho, tenho ciência que pode ser melhorada, porém deixei desta maneira como um case, pelas questões apontadas no item acima, 

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
[http://localhost:8989](http://localhost:8989)
