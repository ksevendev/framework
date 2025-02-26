<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>PHP</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
				border-radius: 8px;
			}
			h1,
			h2 {
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
			/* Animação suave na troca de abas */
			.tab-pane {
				transition: opacity 0.3s ease-in-out;
			}

			/* Tema escuro */
			body.dark-mode {
				background-color: #1a1a1a;
				color: white;
			}
			.dark-mode .navbar,
			.dark-mode .footer {
				background-color: #333;
			}
			.dark-mode section {
				background-color: #222;
				color: white;
			}
		</style>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
			<div class="container">
				<a class="navbar-brand" href="#">Mini Framework PHP</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ms-auto">
						<li class="nav-item">
							<button class="btn btn-outline-light" id="themeToggle">
								<i class="bi bi-moon-stars-fill"></i>
								Tema
							</button>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<section class="py-5 my-5">
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
		</section>

		<section class="py-5">
            <ul class="nav nav-tabs" id="docTabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#intro">Introdução</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#install">Instalação</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#usage">Como Usar</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#api">Referência da API</button>
                </li>
            </ul>

            <div class="tab-content mt-4">
                <!-- Introdução -->
                <div class="tab-pane fade show active" id="intro">
                    <h2>🚀 Introdução</h2>
                    <p>O Mini Framework PHP é uma ferramenta leve e flexível para desenvolvimento de aplicações modernas.</p>
                    <ul>
                        <li>✅ Simples e modular</li>
                        <li>✅ Performance otimizada</li>
                        <li>✅ Fácil integração com banco de dados</li>
                    </ul>
                </div>

                <!-- Instalação -->
                <div class="tab-pane fade" id="install">
                    <h2>📥 Instalação</h2>
                    <p>Siga os passos abaixo para instalar o framework:</p>

                    <h3>1️⃣ Requisitos:</h3>
                    <ul>
                        <li>PHP 8+</li>
                        <li>Composer</li>
                        <li>MySQL ou PostgreSQL</li>
                    </ul>

                    <h3>2️⃣ Clonar o repositório:</h3>
                    <pre>
                        <code>
                            git clone https://github.com/seu-repo/framework.git 
                            cd framework
                        </code>
                    </pre>

                    <h3>3️⃣ Instalar dependências:</h3>
                    <pre><code>composer install</code></pre>

                    <h3>4️⃣ Configurar o `.env`:</h3>
                    <pre>
                        <code>
                            APP_ENV=local
                            DB_CONNECTION=mysql
                            DB_HOST=127.0.0.1
                            DB_DATABASE=framework
                            DB_USERNAME=root
                            DB_PASSWORD=
                        </code>
                    </pre>

                    <h3>5️⃣ Executar a aplicação:</h3>
                    <pre><code>php -S localhost:8000 -t public</code></pre>
                </div>

                <!-- Como Usar -->
                <div class="tab-pane fade" id="usage">
                    <h2>📌 Como Usar</h2>
                    <p>Exemplo de criação de rota:</p>
                    <pre>
                        <code>
                            use Core\Router;
                            Router::get('/home', function() {
                                return 'Bem-vindo ao Mini Framework!';
                            });
                        </code>
                    </pre>
                </div>

                <!-- Referência da API -->
                <div class="tab-pane fade" id="api">
                    <h2>📚 Referência da API</h2>
                    <p>Funções úteis do framework:</p>

                    <h3>🔹 `base_url($path = '')`</h3>
                    <pre><code>echo base_url('assets/css/style.css');</code></pre>

                    <h3>🔹 `public_path($path = '')`</h3>
                    <pre><code>echo public_path('uploads/image.jpg');</code></pre>
                </div>
            </div>
		</section>

		<footer>
			&copy; 2025 Mini Framework PHP - Todos os direitos reservados.
		</footer>


		<!-- Bootstrap JS -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

		<script>
			// Alternar tema escuro/claro
            document.getElementById("themeToggle").addEventListener("click", function () {
                document.body.classList.toggle("dark-mode");
            });

            // Navegação entre abas
            const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
            let currentIndex = 0;

            function switchTab(index) {
                tabs[index].click();
            }

            tabs.forEach((tab, index) => {
                tab.addEventListener("shown.bs.tab", () => {
                    currentIndex = index;
                });
            });
		</script>

	</body>
</html>
