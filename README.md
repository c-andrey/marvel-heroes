## Aplicação backend para listar heróis da marvel e adicionar votos no seu herói favorito.

Optei por separar os projetos backend e frontend para uma maior liberdade com os projetos.

****NECESSÁRIO TER O MYSQL INSTALADO****

PASSOS PARA INSTALAÇÃO

1. criar arquivo .env a partir do .env.example
2. composer install
3. php artisan migrate
4. php artisan serve

PASSOS PARA RODAR O TESTE

1. php artisan migrate --env=testing
2. php artisan test
3. php artisan test --coverage
4. com php unit instalado é possivel gerar coverage com UI pelo comando:  **vendor/bin/phpunit --coverage-html public/reports/**

TECNOLOGIAS UTILIZADAS

* Laravel
* PHPUnit

Desenvolvimento dirigido por TDD, aplicando SOLID e utilizando os padrões de design Factory, Singleton.
