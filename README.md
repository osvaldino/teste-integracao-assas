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

##### Passo 1: Clone o repositório.
```bash
git clone https://github.com/osvaldino/teste-integracao-assas.git
```

##### Passo 2: Acesse a pasta
```bash
cd teste-integracao-assas
```

##### Passo 3: Instale as dependências
```bash
composer install && npm install
```

##### Passo 4: Crie o arquivo .env
```bash
cp .env.example .env
```

##### Passo 5: Gere a chave de criptografia
```bash
php artisan key:generate
```

##### Passo 6: Defina as configurações do banco de dados no arquivo .env
```bash
DB_CONNECTION=mysql
DB_HOST=localhost // ou o endereço do seu banco de dados
DB_PORT=3306
DB_DATABASE={nome do seu banco de dados}
DB_USERNAME={usuário do seu banco de dados}
DB_PASSWORD={senha do seu banco de dados}
```

##### Passo 7: Defina as configurações da API da Asaas no arquivo .env (BASE_URL da API e o API_KEY da API)
A BASE_URL da API da Asaas pode ser encontrada [Aqui](https://docs.asaas.com/docs/sandbox).
A API_KEY da API da Asaas pode ser gerado no seu painel de controle da Asaas [Aqui](https://sandbox.asaas.com/customerApiAccessToken/index).
```bash
ASAAS_BASE_URL=https://api-sandbox.asaas.com/v3/
ASAAS_API_KEY=
```

##### Passo 9: Criar as tabelas do banco de dados
```bash
php artisan migrate
```

##### Passo 10: Iniciar o servidor para testar a aplicação
```bash
php artisan serve
```

##### Passo 11: Em outro terminal
```bash
npm run build
```

#### Acessar a http://localhost:8000/ e te dará acesso a aplicação.

<br>
<br>

Feito com muito ❤ and 💪🏾 by Osvaldino Neto ☺️
