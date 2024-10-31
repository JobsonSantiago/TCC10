console.log("Arquivo JS carregado!");

let produtosArray = []; // Array global para armazenar os produtos
let produtosVisiveis = []; // Array para armazenar os produtos atualmente visíveis

document.addEventListener('DOMContentLoaded', () => {
    console.log("DOM totalmente carregado");

    // Inicializa os produtos
    produtosArray = Array.from(document.getElementsByClassName('product-card'));
    produtosVisiveis = [...produtosArray]; // Preenche produtos visíveis com todos os produtos no início

    console.log("Produtos encontrados: ", produtosArray);

    // Adiciona eventos para os inputs de pesquisa
    const produtoInput = document.getElementById('produtoDigitado');
    const mercadoInput = document.getElementById('mercadoDigitado');

    if (produtoInput && mercadoInput) {
        produtoInput.addEventListener('input', pesquisar);
        mercadoInput.addEventListener('input', pesquisar);
    } else {
        console.log("Campos de input de pesquisa não foram encontrados.");
    }

    organizarProdutos(); // Chama a função de organizar produtos

    // Aplica as estrelas de avaliação inicialmente
    aplicarEventosEstrelas();  

    var savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
        doDemo(); // Passa para o tema escuro
    }

    
}
);


// FUNÇÃO UTILIZADA PARA AVALIAR MERCADOS
function configurarEstrelas(seletor, hiddenInputId) {
    const estrelas = document.querySelectorAll(seletor);
    const hiddenInput = document.getElementById(hiddenInputId);

    if (estrelas.length > 0 && hiddenInput) {
        console.log("Estrelas encontradas: ", estrelas);
        estrelas.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                hiddenInput.value = value; // Define o valor do input oculto
                console.log("Avaliação clicada: ", value);

                estrelas.forEach(s => {
                    s.classList.remove('fas', 'far');
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('fas'); // Adiciona a classe 'fas' para estrelas preenchidas
                    } else {
                        s.classList.add('far'); // Adiciona a classe 'far' para estrelas vazias
                    }
                });
            });
        });
    } else {
        console.log(`Estrelas ou input não encontrados para o seletor: ${seletor} e o hiddenInputId: ${hiddenInputId}`);
    }
}

// Função para reaplicar eventos de avaliação nas estrelas
function aplicarEventosEstrelas() {
    configurarEstrelas('.avaliacaoMercado1 i', 'avaliacao_mercado1');
    configurarEstrelas('.avaliacaoMercado2 i', 'avaliacao_mercado2');
    configurarEstrelas('.avaliacaoMercado3 i', 'avaliacao_mercado3');
    configurarEstrelas('.avaliacaoMercado4 i', 'avaliacao_mercado4');
}


//FUNÇÕES QUE ATUALIZAM A POSIÇÃO DOS PRODUTOS NA PÁGINA

// Função para pesquisar produtos
function pesquisar() {
    const inputProduto = document.getElementById('produtoDigitado').value.toLowerCase();
    const inputMercado = document.getElementById('mercadoDigitado').value.toLowerCase();

    // Filtra os produtos de acordo com a pesquisa
    produtosVisiveis = produtosArray.filter(produto => {
        const produtoNome = produto.getElementsByClassName('product-name')[0].textContent.toLowerCase();
        const mercadoNome = produto.getElementsByClassName('market-name')[0].textContent.toLowerCase();
        return produtoNome.includes(inputProduto) && mercadoNome.includes(inputMercado);
    });

    console.log("Produtos visíveis após pesquisa: ", produtosVisiveis);
    atualizarProdutosContainer(produtosVisiveis); // Atualiza o container com produtos visíveis
}

// Função para organizar produtos
function organizarProdutos() {
    const radios = document.querySelectorAll('input[name="flexRadioDefault"]');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.checked) {
                console.log("Opção de ordenação selecionada: ", this.id);
                let produtosOrdenados = [...produtosVisiveis]; // Cópia dos produtos visíveis

                produtosOrdenados.sort((a, b) => {
                    const priceElementA = a.getElementsByClassName('product-price')[0];
                    const priceElementB = b.getElementsByClassName('product-price')[0];
                    const dateElementA = a.getElementsByClassName('product-date')[0];
                    const dateElementB = b.getElementsByClassName('product-date')[0];

                    // Verifica qual tipo de ordenação foi selecionado
                    if (this.id === 'opcaoBarato' || this.id === 'opcaoCaro') {
                        // Ordenação por preço
                        if (!priceElementA || !priceElementB) {
                            console.error("Elemento de preço não encontrado:", priceElementA, priceElementB);
                            return 0;
                        }

                        console.log("Texto do preço A:", priceElementA.innerText);
                        console.log("Texto do preço B:", priceElementB.innerText);

                        const precoA = parseFloat(priceElementA.innerText.replace('R$', '').replace('.', '').replace(',', '.').trim());
                        const precoB = parseFloat(priceElementB.innerText.replace('R$', '').replace('.', '').replace(',', '.').trim());

                        if (isNaN(precoA) || isNaN(precoB)) {
                            console.error("Erro ao converter preços:", precoA, precoB);
                            return 0;
                        }

                        return this.id === 'opcaoBarato' ? precoA - precoB : precoB - precoA;

                    } else if (this.id === 'opcaoRecente' || this.id === 'opcaoAntigo') {
                        // Ordenação por data
                        if (!dateElementA || !dateElementB) {
                            console.error("Elemento de data não encontrado:", dateElementA, dateElementB);
                            return 0;
                        }

                        console.log("Texto da data A:", dateElementA.innerText);
                        console.log("Texto da data B:", dateElementB.innerText);

                        const dataRegex = /(\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2})/;
                        const matchA = dateElementA.innerText.match(dataRegex);
                        const matchB = dateElementB.innerText.match(dataRegex);

                        const dataA = matchA ? new Date(matchA[0].split('/').reverse().join('-')) : null;
                        const dataB = matchB ? new Date(matchB[0].split('/').reverse().join('-')) : null;

                        // Tratamento para datas inválidas
                        if (!dataA || isNaN(dataA)) {
                            console.warn("Data inválida em A:", dateElementA.innerText);
                        }
                        if (!dataB || isNaN(dataB)) {
                            console.warn("Data inválida em B:", dateElementB.innerText);
                        }

                        // Definindo datas inválidas como maiores ou menores, dependendo da ordenação
                        if (!dataA && !dataB) return 0;
                        if (!dataA) return this.id === 'opcaoRecente' ? 1 : -1;
                        if (!dataB) return this.id === 'opcaoRecente' ? -1 : 1;

                        return this.id === 'opcaoRecente' ? dataB - dataA : dataA - dataB;
                    }
                });

                // Atualiza o container com os produtos organizados
                atualizarProdutosContainer(produtosOrdenados);
            }
        });
    });
}


// Função para atualizar o container de produtos
function atualizarProdutosContainer(produtos) {
    const produtosContainer = document.getElementById('produtos-container');
    produtosContainer.innerHTML = ''; // Limpa o container

    produtos.forEach(produto => {
        const colDiv = document.createElement('div'); // Cria um novo elemento div para a coluna
        colDiv.classList.add('col-lg-4', 'col-md-6', 'mb-4'); // Adiciona classes para estilo
        colDiv.appendChild(produto); // Adiciona o card dentro da nova coluna
        produtosContainer.appendChild(colDiv); // Adiciona a coluna ao container
    });

    // Reaplica os eventos das estrelas após a atualização dos produtos
    aplicarEventosEstrelas();
}


//FUNÇÕES UTILIZADAS PARA CADASTRO DE PREÇO DOS PRODUTOS
function showImageMarket() {
    const select = document.getElementById("market-select");
    const selectedOption = select.options[select.selectedIndex];
    const imageSrc = selectedOption.getAttribute("data-image");
    const imageElement = document.getElementById("selected-image-market");

    if (imageSrc) {
        imageElement.src = imageSrc;
        imageElement.style.display = "block";
    } else {
        imageElement.style.display = "none";
    }
}

function selectMarket() {
    const select = document.getElementById("market-select");
    const selectedOption = select.options[select.selectedIndex];

    const selectedMarketName = selectedOption.value; // Nome do mercado
    const selectedMarketId = selectedOption.getAttribute("data-id"); // ID do mercado

    const hiddenNameInput = document.getElementById("selected-market-name");
    const hiddenIdInput = document.getElementById("selected-market-id");

    // Define o nome e o ID do mercado nos campos
    hiddenNameInput.value = selectedMarketName;
    hiddenIdInput.value = selectedMarketId;

    // Fecha o modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('myModal1'));
    modal.hide();
}

const products = [
    { name: 'Arroz - Camil', id: 1, image: 'images/pr_arroz.png' },
    { name: 'Arroz - Tio João', id: 2, image: 'images/pr_arroz2.png' },
    { name: 'Feijão - Camil', id: 3, image: 'images/pr_feijao.png' },
    { name: 'Feijão - Kicaldo', id: 4, image: 'images/pr_feijao2.png' },
    { name: 'Açúcar - União', id: 5, image: 'images/pr_acucar.png' },
    { name: 'Açúcar - Caravelas', id: 6, image: 'images/pr_acucar2.png' },
    { name: 'Sal - Cisne', id: 7, image: 'images/pr_sal.png' },
    { name: 'Sal - Lebre', id: 8, image: 'images/pr_sal2.png' },
    { name: 'Café - Pilão', id: 9, image: 'images/pr_cafe.png' },
    { name: 'Café - União', id: 10, image: 'images/pr_cafe2.png' },
    { name: 'Macarrão - Galo', id: 11, image: 'images/pr_macarrao.png' },
    { name: 'Macarrão - Adria', id: 12, image: 'images/pr_macarrao2.png' },
    { name: 'Farinha de Trigo - Dona Benta', id: 13, image: 'images/pr_farinhadetrigo.png' },
    { name: 'Farinha de Trigo - Qualitá', id: 14, image: 'images/pr_farinhadetrigo2.png' },
    { name: 'Farinha Temperada - Yoki', id: 15, image: 'images/pr_farinhatemperada.png' },
    { name: 'Farinha Temperada - Kodilar', id: 16, image: 'images/pr_farinhatemperada2.png' },
    { name: 'Achocolatado em Pó - Italac', id: 17, image: 'images/pr_achocolatado.png' },
    { name: 'Achocolatado em Pó - Toddy', id: 18, image: 'images/pr_achocolatado2.png' },
    { name: 'Óleo - Soya', id: 19, image: 'images/pr_oleo.png' },
    { name: 'Óleo - Liza', id: 20, image: 'images/pr_oleo2.png' },
    { name: 'Creme de Leite - Italac', id: 21, image: 'images/pr_cremedeleite.png' },
    { name: 'Creme de Leite - Nestlé', id: 22, image: 'images/pr_cremedeleite2.png' },
    { name: 'Molho de Tomate - Quero', id: 23, image: 'images/pr_molhodetomate.png' },
    { name: 'Molho de Tomate - Fugini', id: 24, image: 'images/pr_molhodetomate2.png' },
    { name: 'Bolacha (Cream Cracker) - Adria', id: 25, image: 'images/pr_bolacha.png' },
    { name: 'Bolacha (Cream Cracker) - Bauduco', id: 26, image: 'images/pr_bolacha2.png' },
    { name: 'Leite Condensado - Piracanjuba', id: 27, image: 'images/pr_leitecondensado.png' },
    { name: 'Leite Condensado - Italac', id: 28, image: 'images/pr_leitecondensado2.png' },
    { name: 'Sabonete - Dove', id: 29, image: 'images/pr_sabonete.png' },
    { name: 'Sabonete - Lux', id: 30, image: 'images/pr_sabonete2.png' },
    { name: 'Pasta de Dente - Colgate', id: 31, image: 'images/pr_pastadente.png' },
    { name: 'Pasta de Dente - Sorriso', id: 32, image: 'images/pr_pastadente2.png' },
    { name: 'Papel Higiênico - Sublime', id: 33, image: 'images/pr_papelhigienico.png' },
    { name: 'Papel Higiênico - Personal', id: 34, image: 'images/pr_papelhigienico2.png' },
    { name: 'Leite - Italac', id: 35, image: 'images/pr_leite.png' },
    { name: 'Leite - Piracanjuba', id: 36, image: 'images/pr_leite2.png' },
    { name: 'Refresco em Pó - Tang', id: 37, image: 'images/pr_suco1.png' },
    { name: 'Refresco em Pó - Mid', id: 38, image: 'images/pr_sucoMID1.png' },
    { name: 'Detergente - Limpol', id: 39, image: 'images/pr_detergente.png' },
    { name: 'Detergente - Ypê', id: 40, image: 'images/pr_detergente2.png' },
    { name: 'Sabão em Pó - Ypê', id: 41, image: 'images/pr_sabaoempo.png' },
    { name: 'Sabão em Pó - Omo', id: 42, image: 'images/pr_sabaoempo2.png' },
    { name: 'Esponja de Aço - Bombril', id: 43, image: 'images/pr_esponjadeaco.png' },
    { name: 'Esponja de Aço - Assolan', id: 44, image: 'images/pr_esponjadeaco2.png' }
];


function filterProducts() {
    const input = document.getElementById('product-input').value.toLowerCase();
    const suggestions = document.getElementById('suggestions');
    suggestions.innerHTML = ''; // Limpa sugestões anteriores

    if (input) {
        const filteredProducts = products.filter(product => product.name.toLowerCase().includes(input));

        filteredProducts.forEach(product => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.textContent = product.name;
            listItem.onclick = () => selectProduct(product); // Chama selectProduct ao clicar na sugestão
            suggestions.appendChild(listItem);
        });

        if (filteredProducts.length > 0) {
            suggestions.style.display = 'block'; // Mostra sugestões
        } else {
            suggestions.style.display = 'none'; // Esconde sugestões
        }
    } else {
        suggestions.style.display = 'none'; // Esconde sugestões se o input estiver vazio
    }
}

function selectProduct(product) {
    // Atualiza o campo de entrada com o nome do produto
    document.getElementById('product-input').value = product.name;
    // Esconde a lista de sugestões
    document.getElementById('suggestions').style.display = 'none';
    // Atualiza a imagem do produto
    const selectedImage = document.getElementById('selected-image');
    selectedImage.src = product.image;
    selectedImage.style.display = 'block'; // Mostra a imagem

    // Definindo valores ocultos
    document.getElementById("selected-product-name").value = product.name;
    document.getElementById("selected-product-id").value = product.id;

    // Verifica se o modal está sendo fechado corretamente
    const modal = bootstrap.Modal.getInstance(document.getElementById('myModal'));
    modal.hide();
}

function doDemo(button) {
    var body = document.body;
    var produtosCard = document.getElementsByClassName("product-card");
    var marketNames = document.getElementsByClassName("market-name");
    var productNames = document.getElementsByClassName("product-name");
    var mercadosDetails = document.getElementsByClassName("market-details");
    var produtosHome = document.getElementById("produtos-home");
    var produtosPesquisa = document.getElementById("produtos-pesquisa");
    var dashboardContainer = document.getElementsByClassName("data-card");
    var sidebar = document.getElementsByClassName("sidebar");
    var cadastroContainer = document.getElementById("cadastro-container");
    var inputElements = document.getElementsByTagName("input");
    var selectElements = document.getElementsByTagName("select");
    var welcomeAlert = document.querySelector(".alert-success"); // Alerta de boas-vindas
    var loginAlert = document.querySelector(".alert-danger"); // Alerta de não logado
    var modalContent = document.getElementsByClassName("modal-content"); // Captura os conteúdos do modal
    var cardElements = document.querySelectorAll(".card.text-left.h-100"); // Seleciona todos os cards

    // Verifica se o tema atual é escuro e alterna
    if (body.style.backgroundColor === "rgb(30, 30, 30)" || body.style.backgroundColor === "black") {
        // Tema claro
        body.style.backgroundColor = "white";
        body.style.color = "#343a40";

        for (var i = 0; i < produtosCard.length; i++) {
            produtosCard[i].style.backgroundColor = "#e0e0e0";
            produtosCard[i].style.color = "black";
        }

        for (var i = 0; i < cardElements.length; i++) {
            cardElements[i].style.backgroundColor = "#e0e0e0"; // Fundo claro para os cards
            cardElements[i].style.color = "black"; // Texto escuro
        }

        for (var i = 0; i < marketNames.length; i++) {
            marketNames[i].style.color = "#343a40";
        }

        for (var i = 0; i < productNames.length; i++) {
            productNames[i].style.color = "#343a40";
        }

        for (var i = 0; i < mercadosDetails.length; i++) {
            mercadosDetails[i].style.backgroundColor = "#f8f9fa";
        }

        if (produtosHome) produtosHome.style.backgroundColor = "#f8f9fa";
        if (produtosPesquisa) produtosPesquisa.style.backgroundColor = "#f8f9fa";

        for (var i = 0; i < dashboardContainer.length; i++) {
            dashboardContainer[i].style.backgroundColor = "#f8f9fa";
            dashboardContainer[i].style.color = "#343a40";
            var dashboardTextElements = dashboardContainer[i].getElementsByTagName("*");
            for (var j = 0; j < dashboardTextElements.length; j++) {
                dashboardTextElements[j].style.color = "#343a40";
            }
        }

        for (var i = 0; i < sidebar.length; i++) {
            sidebar[i].style.backgroundColor = "#f8f9fa";
            sidebar[i].style.color = "#343a40";
            var sidebarTextElements = sidebar[i].getElementsByTagName("*");
            for (var j = 0; j < sidebarTextElements.length; j++) {
                sidebarTextElements[j].style.color = "#343a40";
            }
        }

        for (var i = 0; i < inputElements.length; i++) {
            inputElements[i].style.backgroundColor = "white";
            inputElements[i].style.color = "#343a40";
            inputElements[i].style.borderColor = "#343a40";
        }

        for (var i = 0; i < selectElements.length; i++) {
            selectElements[i].style.backgroundColor = "white";
            selectElements[i].style.color = "#343a40";
            selectElements[i].style.borderColor = "#343a40";
        }

        if (cadastroContainer) {
            cadastroContainer.style.backgroundColor = "#f8f9fa";
            cadastroContainer.style.color = "#343a40";

            var cadastroTextElements = cadastroContainer.getElementsByTagName("label");
            for (var i = 0; i < cadastroTextElements.length; i++) {
                cadastroTextElements[i].style.color = "#343a40";
            }
        }

        // Estilo para o alerta de boas-vindas
        if (welcomeAlert) {
            welcomeAlert.style.backgroundColor = "#d4edda"; // Fundo claro
            welcomeAlert.style.color = "#155724"; // Texto escuro
        }

        // Estilo para o alerta de não logado
        if (loginAlert) {
            loginAlert.style.backgroundColor = "#f8d7da"; // Fundo claro
            loginAlert.style.color = "#721c24"; // Texto escuro
        }

        // Estilo para o conteúdo do modal
        for (var i = 0; i < modalContent.length; i++) {
            modalContent[i].style.backgroundColor = "#ffffff"; // Fundo claro
            modalContent[i].style.color = "#343a40"; // Texto escuro
        }

        localStorage.setItem("theme", "light");
    } else {
        // Tema escuro
        body.style.backgroundColor = "#1e1e1e";
        body.style.color = "#ffffff"; // Texto branco para o body

        for (var i = 0; i < produtosCard.length; i++) {
            produtosCard[i].style.backgroundColor = "#343a40";
            produtosCard[i].style.color = "#ffffff"; // Texto branco nos cartões
        }

        for (var i = 0; i < cardElements.length; i++) {
            cardElements[i].style.backgroundColor = "#343a40"; // Fundo escuro para os cards
            cardElements[i].style.color = "#ffffff"; // Texto branco
        }

        for (var i = 0; i < marketNames.length; i++) {
            marketNames[i].style.color = "#ffffff"; // Texto branco nos nomes de mercado
        }

        for (var i = 0; i < productNames.length; i++) {
            productNames[i].style.color = "#ffffff"; // Texto branco nos nomes de produtos
        }

        for (var i = 0; i < mercadosDetails.length; i++) {
            mercadosDetails[i].style.backgroundColor = "#343a40"; // Fundo escuro nos detalhes dos mercados
        }

        if (produtosHome) produtosHome.style.backgroundColor = "#343a40"; // Fundo escuro
        if (produtosPesquisa) produtosPesquisa.style.backgroundColor = "#343a40"; // Fundo escuro

        for (var i = 0; i < dashboardContainer.length; i++) {
            dashboardContainer[i].style.backgroundColor = "#343a40"; // Fundo escuro no dashboard
            dashboardContainer[i].style.color = "#ffffff"; // Texto branco no dashboard
            var dashboardTextElements = dashboardContainer[i].getElementsByTagName("*");
            for (var j = 0; j < dashboardTextElements.length; j++) {
                dashboardTextElements[j].style.color = "#ffffff"; // Texto branco
            }
        }

        for (var i = 0; i < sidebar.length; i++) {
            sidebar[i].style.backgroundColor = "#343a40"; // Fundo escuro na sidebar
            sidebar[i].style.color = "#ffffff"; // Texto branco na sidebar
            var sidebarTextElements = sidebar[i].getElementsByTagName("*");
            for (var j = 0; j < sidebarTextElements.length; j++) {
                sidebarTextElements[j].style.color = "#ffffff"; // Texto branco
            }
        }

        for (var i = 0; i < inputElements.length; i++) {
            inputElements[i].style.backgroundColor = "#2c2c2c"; // Fundo escuro
            inputElements[i].style.color = "#ffffff"; // Texto branco
            inputElements[i].style.borderColor = "#ffffff"; // Borda clara
            inputElements[i].style.setProperty('--placeholder-color', '#ffffff'); // Define a cor do placeholder

            
        }

        for (var i = 0; i < selectElements.length; i++) {
            selectElements[i].style.backgroundColor = "#2c2c2c"; // Fundo escuro
            selectElements[i].style.color = "#ffffff"; // Texto branco
            selectElements[i].style.borderColor = "#ffffff"; // Borda clara
            selectElements[i].style.setProperty('--placeholder-color', '#ffffff'); // Define a cor do placeholder

        }

        if (cadastroContainer) {
            cadastroContainer.style.backgroundColor = "#343a40"; // Fundo escuro no cadastro
            cadastroContainer.style.color = "#ffffff"; // Texto branco

            var cadastroTextElements = cadastroContainer.getElementsByTagName("label");
            for (var i = 0; i < cadastroTextElements.length; i++) {
                cadastroTextElements[i].style.color = "#ffffff"; // Texto branco nos rótulos
            }
        }

        // Estilo para o alerta de boas-vindas no tema escuro
        if (welcomeAlert) {
            welcomeAlert.style.backgroundColor = "#155724"; // Fundo mais escuro
            welcomeAlert.style.color = "#ffffff"; // Texto branco
        }

        // Estilo para o alerta de não logado no tema escuro
        if (loginAlert) {
            loginAlert.style.backgroundColor = "#721c24"; // Fundo mais escuro
            loginAlert.style.color = "#ffffff"; // Texto branco
        }

        // Estilo para o conteúdo do modal no tema escuro
        for (var i = 0; i < modalContent.length; i++) {
            modalContent[i].style.backgroundColor = "#343a40"; // Fundo escuro
            modalContent[i].style.color = "#ffffff"; // Texto branco
        }
        var allElements = body.getElementsByTagName("*");
        for (var i = 0; i < allElements.length; i++) {
            allElements[i].style.color = "#ffffff"; // Texto branco
        }

        localStorage.setItem("theme", "dark");
    }
}
