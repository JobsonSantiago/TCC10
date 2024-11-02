<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site Exemplo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <!-- Importação do Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Inclusão do JavaScript -->
    <script src="{{ asset('js/scriptsprodutos.js') }}"></script>
    <script src="{{ asset('js/scripttema.js') }}"></script>


    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilo para garantir que o rodapé fique na parte inferior */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        #content {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Ocupa pelo menos 100% da altura da janela */
        }

        .flex-grow {
            flex-grow: 1;
            /* Faz com que o conteúdo ocupe o espaço restante */
        }

        .product-card {
            background-color: #e0e0e0;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
            /* Espaçamento entre as linhas */
            max-width: 335px;
            /* Largura máxima dos cards */
        }

        .product-card img {
            width: 75%;
            height: 250px;
            /* Ajuste a altura da imagem */
            object-fit: cover;
            /* Ajusta a imagem para cobrir o card */
        }

        .product-price {
            color: red;
            font-size: 24px;
            margin: 10px 0;
        }

        .product-name,
        .market-name {
            font-size: 16px;
            color: #333;
        }

        .product-card p {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        .product-review-label {
            margin-left: 5px;
        }
    </style>
</head>

<body>

    <!-- Contêiner principal para manter o conteúdo e o rodapé -->
    <div id="content">


        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <!-- Logo -->
                <div class="navbar-logo">
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                        <img src="images/logo_cb.png" alt="Logo" class="logo-image">
                    </a>
                </div>

                <!-- Botão do Menu Colapsável -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Links do Menu (Colapsáveis) -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('mercados') }}">Mercados</a>
                        </li>

                        <!-- Produtos como link direto em telas menores -->
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="{{ route('produtos') }}">Produtos</a>
                        </li>

                        <!-- Cadastrar Produto para telas menores -->
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="{{ route('cadastro_produto') }}">Cadastrar Produto</a>
                        </li>

                        <!-- Produtos: Com dropdown para telas grandes -->
                        <li class="nav-item dropdown d-none d-lg-block" id="produtosDropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                role="button" aria-expanded="false" onmouseover="showDropdown()" onmouseleave="hideDropdown()">
                                Produtos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown" onmouseenter="keepDropdown()" onmouseleave="hideDropdown()">
                                <li><a class="dropdown-item" href="{{ route('cadastro_produto') }}">Cadastrar Produto</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <script>
                    // Função para mostrar o dropdown
                    function showDropdown() {
                        const dropdownMenu = document.querySelector('.dropdown-menu');
                        dropdownMenu.classList.add('show');
                    }

                    // Função para esconder o dropdown
                    function hideDropdown() {
                        const dropdownMenu = document.querySelector('.dropdown-menu');
                        dropdownMenu.classList.remove('show');
                    }

                    // Função para manter o dropdown visível enquanto o mouse está sobre ele
                    function keepDropdown() {
                        const dropdownMenu = document.querySelector('.dropdown-menu');
                        dropdownMenu.classList.add('show');
                    }

                    // Lógica para redirecionar ao clicar em "Produtos" em telas grandes
                    document.addEventListener("DOMContentLoaded", function() {
                        const produtosLink = document.getElementById("navbarDropdown");

                        produtosLink.addEventListener("click", function(event) {
                            if (window.innerWidth > 992) {
                                // Redireciona para a página de produtos ao clicar
                                window.location.href = "{{ route('produtos') }}";
                            }
                        });
                    });
                </script>

                <!-- Ícone da Conta -->
                <div class="navbar-icon">
                    <a href="{{ route('register') }}" class="navbar-brand d-flex align-items-center">
                        <img src="{{ asset('images/conta_tcc.png') }}" alt="Conta" class="conta-image">
                    </a>
                </div>
            </div>
        </nav>

        <!-- Seção de Produtos em Destaque -->
        <div class="container mt-5">
            <h2 class="text-start mb-4">Produtos em destaque</h2>

            <!-- Barra de Pesquisa -->
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <label for="name_product" class="form-label">Nome do Produto:</label>
                        <input type="text" id="produtoDigitado" class="form-control mb-2" placeholder="Pesquisar produto..." onkeyup="pesquisar()">
                        <label for="name_market" class="form-label">Nome do Mercado:</label>
                        <input type="text" id="mercadoDigitado" class="form-control" placeholder="Pesquisar mercado..." onkeyup="pesquisar()">
                    </div>
                </div>
            </div>

            <!-- Opções de Ordenação -->
            <div class="container mt-3">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="opcaoBarato" checked onchange="ordenarProdutos()">
                                <label class="form-check-label" for="opcaoBarato">
                                    Mais barato ao mais caro
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="opcaoCaro" onchange="ordenarProdutos()">
                                <label class="form-check-label" for="opcaoCaro">
                                    Mais caro ao mais barato
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="opcaoRecente" onchange="ordenarProdutos()">
                                <label class="form-check-label" for="opcaoRecente">
                                    Mais recente ao mais antigo
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="opcaoAntigo" onchange="ordenarProdutos()">
                                <label class="form-check-label" for="opcaoAntigo">
                                    Mais antigo ao mais recente
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="opcaoAvaliacao" onchange="ordenarProdutos()">
                                <label class="form-check-label" for="opcaoAvaliacao">
                                    Organizar pelo número de avaliações
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <!-- Produtos -->
            <div class="row" id="produtos-container">
                <div class="col-lg-4 col-md-4">
                    <div class="product-card">
                        <img src="images/pr_papel.png" alt="Imagem do Produto 1">
                        <div class="product-info">
                            <form action="{{ route('favoritar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_produto" value="33">
                                <input type="hidden" name="id_mercado" value="1">
                                <button class="btn btn-danger favorite-button">
                                    <i class="far fa-heart heart-empty"></i>
                                    <i class="fas fa-heart heart-filled" style="display:none;"></i>
                                </button>
                            </form>
                            <br>
                            <p class="product-name">Sublime Softy's Papel Higiênico Azul 4 Rolos</p>
                            @php
                            // apresentando a media de preços
                            $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 1) // ID do mercado
                            ->where('id_produto', 33) // ID do produto
                            ->avg('preco');

                            $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 1) // ID do mercado
                            ->where('id_produto', 33) // ID do produto
                            ->latest('updated_at')
                            ->value('updated_at');

                            // Ajustar o timezone
                            if ($data) {


                            $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                            }
                            @endphp
                            <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                            <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                            <p class="market-name">Mercado Noemia</p>
                            <br>
                            <br>
                            <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                            <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                                <input type="hidden" name="id_produto" value="33"> <!-- ID do produto -->
                                <input type="hidden" name="id_mercado" value="1"> <!-- ID do mercado -->
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                        <option value="Correto">Correto</option>
                                        <option value="Incorreto">Incorreto</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search">Registrar</i> <br>
                                    </button>
                                    @php
                                    // Contando as avaliações
                                    $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                    ->where('id_mercado', 1) // ID do mercado
                                    ->where('id_produto', 33) // ID do produto
                                    ->count();

                                    $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                    ->where('id_mercado', 1) // ID do mercado
                                    ->where('id_produto', 33) // ID do produto
                                    ->count();
                                    @endphp
                                    <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                    <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                    <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <img src="images/pr_papel.png" alt="Imagem do Produto 2">
                        <div class="product-info">
                            <form action="{{ route('favoritar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_produto" value="33">
                                <input type="hidden" name="id_mercado" value="2">
                                <button class="btn btn-danger favorite-button">
                                    <i class="far fa-heart heart-empty"></i>
                                    <i class="fas fa-heart heart-filled" style="display:none;"></i>
                                </button>
                            </form>
                            <br>
                            <p class="product-name">Sublime Softy's Papel Higiênico Azul 4 Rolos</p>
                            @php
                            // apresentando a media de preços
                            $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 2) // ID do mercado
                            ->where('id_produto', 33) // ID do produto
                            ->avg('preco');

                            $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 2) // ID do mercado
                            ->where('id_produto', 33) // ID do produto
                            ->latest('updated_at')
                            ->value('updated_at');

                            // Ajustar o timezone
                            if ($data) {


                            $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                            }
                            @endphp
                            <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                            <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                            <p class="market-name">Mercado Tietê</p>
                            <br>
                            <br>
                            <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                            <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                                <input type="hidden" name="id_produto" value="33"> <!-- ID do produto -->
                                <input type="hidden" name="id_mercado" value="2"> <!-- ID do mercado -->
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                        <option value="Correto">Correto</option>
                                        <option value="Incorreto">Incorreto</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search">Registrar</i> <br>
                                    </button>
                                    @php
                                    // Contando as avaliações
                                    $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                    ->where('id_mercado', 2) // ID do mercado
                                    ->where('id_produto', 33) // ID do produto
                                    ->count();

                                    $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                    ->where('id_mercado', 2) // ID do mercado
                                    ->where('id_produto', 33) // ID do produto
                                    ->count();
                                    @endphp
                                    <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                    <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                    <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <img src="images/pr_papel.png" alt="Imagem do Produto 3">
                        <div class="product-info">
                            <form action="{{ route('favoritar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_produto" value="33">
                                <input type="hidden" name="id_mercado" value="3">
                                <button class="btn btn-danger favorite-button">
                                    <i class="far fa-heart heart-empty"></i>
                                    <i class="fas fa-heart heart-filled" style="display:none;"></i>
                                </button>
                            </form>
                            <br>
                            <p class="product-name">Sublime Softy's Papel Higiênico Azul 4 Rolos</p>
                            @php
                            // apresentando a media de preços
                            $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 3) // ID do mercado
                            ->where('id_produto', 33) // ID do produto
                            ->avg('preco');

                            $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 3) // ID do mercado
                            ->where('id_produto', 33) // ID do produto
                            ->latest('updated_at')
                            ->value('updated_at');

                            // Ajustar o timezone
                            if ($data) {


                            $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                            }
                            @endphp
                            <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                            <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                            <p class="market-name">Mercado Economix</p>
                            <br>
                            <br>
                            <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                            <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                                <input type="hidden" name="id_produto" value="33"> <!-- ID do produto -->
                                <input type="hidden" name="id_mercado" value="3"> <!-- ID do mercado -->
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                        <option value="Correto">Correto</option>
                                        <option value="Incorreto">Incorreto</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search">Registrar</i> <br>
                                    </button>
                                    @php
                                    // Contando as avaliações
                                    $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                    ->where('id_mercado', 3) // ID do mercado
                                    ->where('id_produto', 33) // ID do produto
                                    ->count();

                                    $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                    ->where('id_mercado', 3) // ID do mercado
                                    ->where('id_produto', 33) // ID do produto
                                    ->count();
                                    @endphp
                                    <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                    <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                    <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <img src="images/pr_papel.png" alt="Imagem do Produto 4">
                        <div class="product-info">
                            <form action="{{ route('favoritar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_produto" value="33">
                                <input type="hidden" name="id_mercado" value="4">
                                <button class="btn btn-danger favorite-button">
                                    <i class="far fa-heart heart-empty"></i>
                                    <i class="fas fa-heart heart-filled" style="display:none;"></i>
                                </button>
                            </form>
                            <br>
                            <p class="product-name">Sublime Softy's Papel Higiênico Azul 4 Rolos</p>
                            @php
                            // apresentando a media de preços
                            $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 4) // ID do mercado
                            ->where('id_produto', 33) // ID do produto
                            ->avg('preco');

                            $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 4) // ID do mercado
                            ->where('id_produto', 33) // ID do produto
                            ->latest('updated_at')
                            ->value('updated_at');

                            // Ajustar o timezone
                            if ($data) {


                            $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                            }
                            @endphp
                            <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                            <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                            <p class="market-name">Mercado Atacadinho</p>
                            <br>
                            <br>
                            <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                            <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                                <input type="hidden" name="id_produto" value="33"> <!-- ID do produto -->
                                <input type="hidden" name="id_mercado" value="4"> <!-- ID do mercado -->
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                        <option value="Correto">Correto</option>
                                        <option value="Incorreto">Incorreto</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search">Registrar</i> <br>
                                    </button>
                                    @php
                                    // Contando as avaliações
                                    $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                    ->where('id_mercado', 4) // ID do mercado
                                    ->where('id_produto', 33) // ID do produto
                                    ->count();

                                    $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                    ->where('id_mercado', 4) // ID do mercado
                                    ->where('id_produto', 33) // ID do produto
                                    ->count();
                                    @endphp
                                    <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                    <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                    <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <img src="images/pr_papel2.png" alt="Imagem do Produto 5">
                        <div class="product-info">
                            <form action="{{ route('favoritar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_produto" value="34">
                                <input type="hidden" name="id_mercado" value="1">
                                <button class="btn btn-danger favorite-button">
                                    <i class="far fa-heart heart-empty"></i>
                                    <i class="fas fa-heart heart-filled" style="display:none;"></i>
                                </button>
                            </form>
                            <br>
                            <p class="product-name">Papel Higiênico Personal Neutro Com 4 Rolos</p>
                            @php
                            // apresentando a media de preços
                            $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 1) // ID do mercado
                            ->where('id_produto', 34) // ID do produto
                            ->avg('preco');

                            $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 1) // ID do mercado
                            ->where('id_produto', 34) // ID do produto
                            ->latest('updated_at')
                            ->value('updated_at');

                            // Ajustar o timezone
                            if ($data) {


                            $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                            }
                            @endphp
                            <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                            <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                            <p class="market-name">Mercado Noemia</p>
                            <br>
                            <br>
                            <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                            <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                                <input type="hidden" name="id_produto" value="34"> <!-- ID do produto -->
                                <input type="hidden" name="id_mercado" value="1"> <!-- ID do mercado -->
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                        <option value="Correto">Correto</option>
                                        <option value="Incorreto">Incorreto</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search">Registrar</i> <br>
                                    </button>
                                    @php
                                    // Contando as avaliações
                                    $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                    ->where('id_mercado', 1) // ID do mercado
                                    ->where('id_produto', 34) // ID do produto
                                    ->count();

                                    $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                    ->where('id_mercado', 1) // ID do mercado
                                    ->where('id_produto', 34) // ID do produto
                                    ->count();
                                    @endphp
                                    <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                    <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                    <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <img src="images/pr_papel2.png" alt="Imagem do Produto 6">
                        <div class="product-info">
                            <form action="{{ route('favoritar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_produto" value="34">
                                <input type="hidden" name="id_mercado" value="2">
                                <button class="btn btn-danger favorite-button">
                                    <i class="far fa-heart heart-empty"></i>
                                    <i class="fas fa-heart heart-filled" style="display:none;"></i>
                                </button>
                            </form>
                            <br>
                            <p class="product-name">Papel Higiênico Personal Neutro Com 4 Rolos</p>
                            @php
                            // apresentando a media de preços
                            $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 2) // ID do mercado
                            ->where('id_produto', 34) // ID do produto
                            ->avg('preco');

                            $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 2) // ID do mercado
                            ->where('id_produto', 34) // ID do produto
                            ->latest('updated_at')
                            ->value('updated_at');

                            // Ajustar o timezone
                            if ($data) {


                            $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                            }
                            @endphp
                            <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                            <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                            <p class="market-name">Mercado Tietê</p>
                            <br>
                            <br>
                            <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                            <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                                <input type="hidden" name="id_produto" value="34"> <!-- ID do produto -->
                                <input type="hidden" name="id_mercado" value="2"> <!-- ID do mercado -->
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                        <option value="Correto">Correto</option>
                                        <option value="Incorreto">Incorreto</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search">Registrar</i> <br>
                                    </button>
                                    @php
                                    // Contando as avaliações
                                    $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                    ->where('id_mercado', 2) // ID do mercado
                                    ->where('id_produto', 34) // ID do produto
                                    ->count();

                                    $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                    ->where('id_mercado', 2) // ID do mercado
                                    ->where('id_produto', 34) // ID do produto
                                    ->count();
                                    @endphp
                                    <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                    <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                    <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <img src="images/pr_papel2.png" alt="Imagem do Produto 7">
                        <div class="product-info">
                            <form action="{{ route('favoritar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_produto" value="34">
                                <input type="hidden" name="id_mercado" value="3">
                                <button class="btn btn-danger favorite-button">
                                    <i class="far fa-heart heart-empty"></i>
                                    <i class="fas fa-heart heart-filled" style="display:none;"></i>
                                </button>
                            </form>
                            <br>
                            <p class="product-name">Papel Higiênico Personal Neutro Com 4 Rolos</p>
                            @php
                            // apresentando a media de preços
                            $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 3) // ID do mercado
                            ->where('id_produto', 34) // ID do produto
                            ->avg('preco');

                            $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 3) // ID do mercado
                            ->where('id_produto', 34) // ID do produto
                            ->latest('updated_at')
                            ->value('updated_at');

                            // Ajustar o timezone
                            if ($data) {


                            $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                            }
                            @endphp
                            <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                            <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                            <p class="market-name">Mercado Economix</p>
                            <br>
                            <br>
                            <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                            <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                                <input type="hidden" name="id_produto" value="34"> <!-- ID do produto -->
                                <input type="hidden" name="id_mercado" value="3"> <!-- ID do mercado -->
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                        <option value="Correto">Correto</option>
                                        <option value="Incorreto">Incorreto</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search">Registrar</i> <br>
                                    </button>
                                    @php
                                    // Contando as avaliações
                                    $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                    ->where('id_mercado', 3) // ID do mercado
                                    ->where('id_produto', 34) // ID do produto
                                    ->count();

                                    $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                    ->where('id_mercado', 3) // ID do mercado
                                    ->where('id_produto', 34) // ID do produto
                                    ->count();
                                    @endphp
                                    <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                    <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                    <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <img src="images/pr_papel2.png" alt="Imagem do Produto 8">
                        <div class="product-info">
                            <form action="{{ route('favoritar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_produto" value="34">
                                <input type="hidden" name="id_mercado" value="4">
                                <button class="btn btn-danger favorite-button">
                                    <i class="far fa-heart heart-empty"></i>
                                    <i class="fas fa-heart heart-filled" style="display:none;"></i>
                                </button>
                            </form>
                            <br>
                            <p class="product-name">Papel Higiênico Personal Neutro Com 4 Rolos</p>
                            @php
                            // apresentando a media de preços
                            $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 4) // ID do mercado
                            ->where('id_produto', 34) // ID do produto
                            ->avg('preco');

                            $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 4) // ID do mercado
                            ->where('id_produto', 34) // ID do produto
                            ->latest('updated_at')
                            ->value('updated_at');

                            // Ajustar o timezone
                            if ($data) {


                            $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                            }
                            @endphp
                            <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                            <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                            <p class="market-name">Mercado Atacadinho</p>
                            <br>
                            <br>
                            <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                            <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                                <input type="hidden" name="id_produto" value="34"> <!-- ID do produto -->
                                <input type="hidden" name="id_mercado" value="4"> <!-- ID do mercado -->
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                        <option value="Correto">Correto</option>
                                        <option value="Incorreto">Incorreto</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search">Registrar</i> <br>
                                    </button>
                                    @php
                                    // Contando as avaliações
                                    $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                    ->where('id_mercado', 4) // ID do mercado
                                    ->where('id_produto', 34) // ID do produto
                                    ->count();

                                    $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                    ->where('id_mercado', 4) // ID do mercado
                                    ->where('id_produto', 34) // ID do produto
                                    ->count();
                                    @endphp
                                    <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                    <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                    <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <br>
    <br>
    <br>
    <footer class="bg-dark text-light pt-5 pb-4 mt-auto" style="font-family: 'Montserrat', sans-serif;">
        <div class="container">
            <div class="row text-center text-md-start justify-content-center">
                <!-- Logo -->
                <div class="col-12 col-sm-6 col-md-2 mb-4 d-flex justify-content-center align-items-center">
                    <img src="images/logo_cb.png" alt="Logo" class="img-fluid footer-logo">
                </div>

                <!-- Sobre Nós -->
                <div class="col-12 col-sm-6 col-md-3 mb-4 d-flex flex-column align-items-center align-items-md-start">
                    <h5 class="footer-title text-uppercase text-primary">Sobre Nós</h5>
                    <p class="text-center text-md-start">Nosso compromisso é comparar e oferecer as melhores opções de produtos, unindo qualidade e preços acessíveis para ajudar você a fazer a melhor escolha.</p>
                </div>

                <!-- Links do Site -->
                <div class="col-12 col-sm-6 col-md-2 mb-4 d-flex flex-column align-items-center align-items-md-start">
                    <h5 class="footer-title text-uppercase text-primary">Links do Site</h5>
                    <ul class="list-unstyled text-center text-md-start">
                        <li><a href="{{ route('home') }}" class="text-light">Início</a></li>
                        <li><a href="{{ route('mercados') }}" class="text-light">Mercados</a></li>
                        <li><a href="{{ route('produtos') }}" class="text-light">Produtos</a></li>
                        <li><a href="{{ route('cadastro_produto') }}" class="text-light">Cadastrar Produto</a></li>
                    </ul>
                </div>

                <!-- Contato -->
                <div class="col-12 col-sm-6 col-md-3 mb-4 d-flex flex-column align-items-center align-items-md-start">
                    <h5 class="footer-title text-uppercase text-primary">Contato</h5>
                    <div class="contact-info d-flex align-items-center">
                        <i class="fas fa-envelope me-2"></i>
                        <span>cbcompare.bem@gmail.com</span>
                    </div>
                </div>

                <!-- Redes Sociais -->
                <div class="col-12 col-sm-6 col-md-2 mb-4 d-flex flex-column align-items-center align-items-md-start">
                    <h5 class="footer-title text-uppercase text-primary">Siga-nos</h5>
                    <div class="social-icons d-flex align-items-center">
                        <a href="https://www.instagram.com/cbcompare.bem/" class="text-light">
                            <i class="fab fa-instagram fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr class="bg-light">

            <div class="row text-center text-md-start">
                <div class="col-12 col-md-8 mb-2 mb-md-0">
                    <p>© 2024 <span class="text-primary fw-bold">Compare Bem</span></p>
                </div>
                <div class="col-12 col-md-4 text-center text-md-end">
                    <p>Desenvolvido por <span class="text-primary fw-bold">Jobson, Samuel, João Vitor e Raphaela</span></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Font Awesome (para ícones de redes sociais) -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>