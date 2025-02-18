<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Processamento de pagamentos integrado ao Asaas

Este projeto é um teste realizado em processo seletivo, onde aplico a integração ao sistema de processamento de pagamentos Asaas.
Utilizando o framework Laravel 11, e seus recursos de rotas, controllers, models, migrations, Views e uma camada de Serviço para comunicação com a API da Asaas.
As views são geradas com o template engine Blade, padrão do Laravel.

## 💻 Tecnologias requeridas

#### Ambiente de desenvolvimento contendo as seguintes ferramentas:
- PHP >= 8.3
- MySQL 8
- Composer >= 2.5
- Node >= 18.x

## 📖 Instalação
```

# Passo 1: Clone o repositório.
git clone https://github.com/osvaldino/teste-integracao-assas.git

# Passo 2: Acesse a pasta
cd teste-integracao-assas

# Passo 3: Instale as dependências
composer install && npm install

# Passo 4: Crie o arquivo .env
cp .env.example .env

# Passo 5: Gere a chave de criptografia
php artisan key:generate

# Passo 6: Defina as configurações do banco de dados no arquivo .env
DB_CONNECTION=mysql
DB_HOST=localhost // ou o endereço do seu banco de dados
DB_PORT=3306
DB_DATABASE={nome do seu banco de dados}
DB_USERNAME={usuário do seu banco de dados}
DB_PASSWORD={senha do seu banco de dados}

# Passo 7: Defina as configurações da API da Asaas no arquivo .env (BASE_URL da API e o API_KEY da API)
# A BASE_URL da API da Asaas pode ser encontrada <a href="https://docs.asaas.com/docs/sandbox" target="_BLANK">Aqui</a>.
# A API_KEY da API da Asaas pode ser gerado no seu painel de controle da Asaas <a href="https://sandbox.asaas.com/customerApiAccessToken/index" target="_BLANK">Aqui</a>..
ASAAS_BASE_URL=https://api-sandbox.asaas.com/v3/
ASAAS_API_KEY=

# Passo 9: Criar as tabelas do banco de dados
php artisan migrate

# Passo 10: Iniciar o servidor para testar a aplicação
php artisan serve

# Passo 11: Em outro terminal
npm run build

Acessar o link http://localhost:8000/ te dará acesso a aplicação.
```

Feito com muito ❤ and 💪🏾 by Osvaldino Neto ☺️
