Instalação
==========

Requisitos:
 - PHP 8+
 - Composer
 - MySQL ou PostgreSQL

Passos:

1. Clone o repositório:

   .. code-block:: bash

      git clone https://github.com/seu-repo/framework.git
      cd framework

2. Instale as dependências:

   .. code-block:: bash

      composer install

3. Configure o arquivo `.env`:

   .. code-block:: ini

      APP_ENV=local
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_DATABASE=framework
      DB_USERNAME=root
      DB_PASSWORD=

4. Execute a aplicação:

   .. code-block:: bash

      php -S localhost:8000 -t public
