# Sobre

O projeto foi desenvolvido especificamente para treinar Vue.js durante uma imersão Beer and Code. Sua finalidade é fornecer informações detalhadas sobre cervejas e seus principais atributos, além de sugestões ideais de acompanhamento.

## Pré-requisitos

Certifique-se de ter os seguintes softwares instalados:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## Como configurar o ambiente

1. Clone este repositório:

   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio
   ```

2. Copie o arquivo de exemplo `.env`:

   ```bash
   cp .env.example .env
   ```

   Edite o arquivo `.env` se necessário, principalmente as variáveis relacionadas ao banco de dados.

3. Construa os containers Docker:

   ```bash
   docker-compose build
   ```

4. Inicie os containers em segundo plano:

   ```bash
   docker-compose up -d
   ```

5. Acesse o container da aplicação para instalar as dependências do Laravel:

   ```bash
   docker-compose exec app bash
   composer install
   ```

6. Gere a chave de aplicação do Laravel:

   ```bash
   php artisan key:generate
   ```

7. Execute as migrações do banco de dados:

   ```bash
   php artisan migrate
   ```

8. Instale as dependências do Vue.js:

   ```bash
   npm install
   npm run dev
   ```

### Subir e gerenciar containers

- Construir os containers:

  ```bash
  docker-compose build
  ```

- Subir os containers em segundo plano:

  ```bash
  docker-compose up -d
  ```


- Instalar dependências do Laravel (dentro do container laravel):

  ```bash
  composer install
  ```

### Vue.js

- Instalar dependências:

  ```bash
  npm install
  ```

- Compilar os assets para desenvolvimento:

  ```bash
  npm run dev
  ```

- Compilar os assets para produção:

  ```bash
  npm run build
  ```