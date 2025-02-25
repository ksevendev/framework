
    <style>
        .toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #333;
            color: white;
            padding: 10px;
            z-index: 9999;
            font-family: Arial, sans-serif;
            display: none;
        }
        .toolbar.open {
            display: block;
        }
        .toolbar-toggle {
            position: fixed;
            top: 50%;
            left: 0;
            background-color: #333;
            color: white;
            padding: 10px;
            cursor: pointer;
            z-index: 9999;
        }
        .toolbar-content {
            margin-top: 20px;
        }
        .queries {
            margin-top: 10px;
            font-size: 12px;
            background-color: #444;
            padding: 5px;
            border-radius: 5px;
        }
    </style>

    <!-- Botão para alternar a toolbar -->
    <div id="toolbar-toggle" class="toolbar-toggle">
        &#9776; Developer Toolbar
    </div>

    <!-- Barra de ferramentas -->
    <div id="toolbar" class="toolbar">
        <div><strong>{{ $title }}</strong></div>
        <div>Execution Time: {{ $executionTime }}s</div>
        <div>Queries Executed: {{ $queriesCount }}</div>

        @if ($queriesCount > 0)
        <div class="queries">
            <strong>Queries Executed:</strong>
            @foreach ($queries as $queryDetail)
                <pre>
                    Query: {{ $queryDetail['query'] }}
                    Bindings: {{ implode(', ', $queryDetail['bindings']) }}
                    Time: {{ $queryDetail['time'] }}ms
                </pre>
            @endforeach
        </div>
        @endif
    </div>

    <script>
        // Função para alternar a visibilidade da barra de ferramentas
        document.getElementById('toolbar-toggle').addEventListener('click', function() {
            const toolbar = document.getElementById('toolbar');
            toolbar.classList.toggle('open');
        });
    </script>
