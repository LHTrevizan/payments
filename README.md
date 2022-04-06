# payments

payments
Clone the project:
 -  git clone https://github.com/LHTrevizan/payments.git

Access the project folder:
  - cd payments (Acesse o diretorio do projeto)

Copy .env file:
 -  cp .env.example .env (criar o arquivo .env com os dados do .env.example)

Upload containers with docker-compose:
 -  docker-compose build
 -  docker-compose up -d

Install database:
 -  docker exec -ti api_app php bin/console doctrine:migrations:migrate (Digite 'y' para continuar)

Access environment: http://172.10.1.10

Access API PlatForm Docs: http://172.10.1.10/api/doc

About:
    This app works with PHP (^7.4)

    Requirements
        Docker version 20.10.5
        docker-compose (version ^1.24.0)
         - docker-compose.yml - version:3.7
        Docker images
        mysql:5.7
        nginx:1.19
        php:7.4-fpm-alpine

Author
        Leticia Trevizan - lehtrevizan@icloud.com
