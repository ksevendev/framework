Uso do Framework
================

Rotas
-----
As rotas são definidas em `routes/web.php` e `routes/api.php`.

.. code-block:: php

   $router->get('/home', function() {
       return "Bem-vindo!";
   });

Controllers
-----------
Os controllers ficam na pasta `app/Http/Controllers`.

.. code-block:: php

   class HomeController {
       public function index() {
           return view('home');
       }
   }
