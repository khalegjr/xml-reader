<h1 align="center">Leitor de XML - Teste SIIMP Sistemas</h1>


## Sobre

Este é um teste para a empresa [SIIMP Sistemas](https://siimp.com.br/). É um simples leitor de arquivo XML que mostra as tags que possuem algum valor atribuído e o seu caminho. Também tem um campo de pesquisa.

## Ambiente

O projeto foi feito com Laravel 9, com PHP 8.2 num ambiente Docker. Não foram utilizados plugins nem banco de dados.

O front foi feito com Blade e Tailwindcss, com os componentes do https://flowbite.com/.

## Instalação

Para rodar o projeto em __ambiente de desenvolvimento__ basta seguir os seguintes comandos:

### Com Docker
```bash
git clone https://github.com/khalegjr/xml-reader.git
cd xml-reader
docker-compose up -d
docker-compose exec laravel.test composer install
./vendor/bin/sail npm run dev
```

### Com PHP local
```bash
git clone https://github.com/khalegjr/xml-reader.git
cd xml-reader
composer install
npm run dev
```

