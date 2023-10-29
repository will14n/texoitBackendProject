
# Setup Docker Laravel 10 com PHP 8.1

### Passo a passo
Clone Repositório
```sh
git clone -b https://github.com/will14n/template-docker-laravel10 app-laravel
```
```sh
cd app-laravel
```


Crie o Arquivo .env
```sh
cp .env.example .env
```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acesse o container app
```sh
docker-compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```


Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Realize os migrations e o setup do banco, (o arquivo ficará dentro de /database/), basta selecionar yes
```sh
php artisan migrate
```

Agora que temos a estrutura do banco montada, iremos descer e subir a estrutura docker novamente.
Execute o comando exit para sair do docker
```sh
exit
```

Para desmontar e montar o Docker precisamos rodar dois comandos, que irão automaticamente popular nosso banco a cada vez que desmontamos e montamos o Docker (as tabelas são zeradas cada vez que o docker é montado)
```sh
docker-compose down
docker-compose up -d
```

Para executar os testes, é necessário entrar no Docker
```sh
docker-compose exec app bash
./vendor/bin/phpunit
```

### Obs.: O arquivo csv que popula o banco, está localizado na pasta /storage/imports

Acesse o projeto
[http://localhost:8989](http://localhost:8989)
