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


About API: 

Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles. Vamos nos atentar somente ao fluxo de transferência entre dois usuários.

Requisitos:

Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.

Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.

Lojistas só recebem transferências, não enviam dinheiro para ninguém.

Validar se o usuário tem saldo antes da transferência.

Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).

A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.

No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (http://o4d9z.mocklab.io/notify).

Author
        Leticia Trevizan - lehtrevizan@icloud.com
