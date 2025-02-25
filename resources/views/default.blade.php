<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Mini Framework PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            text-align: center;
        }
        header {
            background-color: #3498db;
            color: white;
            padding: 20px;
            font-size: 24px;
        }
        section {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2 {
            color: #2c3e50;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
        }
        .button:hover {
            background-color: #2980b9;
        }
        footer {
            margin-top: 30px;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
        }
    </style>
</head>
<body>

<header>
    🚀 Mini Framework PHP
</header>

<section>
    <h1>Bem-vindo ao Mini Framework PHP</h1>
    <p>Este framework foi desenvolvido para oferecer uma estrutura leve e eficiente para construção de aplicações PHP modernas.</p>
    
    <h2>Principais Recursos</h2>
    <ul style="text-align: left;">
        <li>🔹 Roteamento simples e flexível</li>
        <li>🔹 Suporte a middlewares</li>
        <li>🔹 Helpers globais para facilitar o desenvolvimento</li>
        <li>🔹 Gerenciamento de componentes</li>
        <li>🔹 Estrutura modular para melhor organização do código</li>
    </ul>

    <h2>Como Usar?</h2>
    <p>Basta instalar as dependências e começar a desenvolver:</p>
    <pre style="background: #eee; padding: 10px; text-align: left; border-radius: 5px;">
    composer install
    php -S localhost:8000 -t public
    </pre>

    <a href="docs.html" class="button">Ver Documentação</a>
</section>

<footer>
    &copy; 2025 Mini Framework PHP - Todos os direitos reservados.
</footer>

</body>
</html>
