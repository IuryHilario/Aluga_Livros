// Script para pesquisa global
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('global-search');
    const mobileSearchInput = document.getElementById('mobile-global-search');
    const searchResultsDropdown = document.getElementById('search-results-dropdown');
    const mobileSearchResultsDropdown = document.getElementById('mobile-search-results-dropdown');
    const searchResultsContent = document.getElementById('search-results-content');
    const mobileSearchResultsContent = document.getElementById('mobile-search-results-content');
    let searchTimeout;

    // Verificação de elementos essenciais (desktop)
    if (!searchInput || !searchResultsDropdown || !searchResultsContent) {
        console.error('Elementos de pesquisa desktop não encontrados');
        return;
    }

    // Função unificada para lidar com input
    function handleSearchInput(isMobile = false) {
        return function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            // Sincronizar inputs
            if (isMobile && searchInput) {
                searchInput.value = this.value;
            } else if (!isMobile && mobileSearchInput) {
                mobileSearchInput.value = this.value;
            }

            if (query.length < 2) {
                searchResultsDropdown.classList.add('hidden');
                if (mobileSearchResultsDropdown) mobileSearchResultsDropdown.classList.add('hidden');
                return;
            }

            // Exibir loading em ambos
            const loadingHTML = `
                <div class="flex flex-col items-center justify-center py-8 px-4">
                    <i class="fas fa-spinner fa-spin text-amber-600 text-2xl mb-3"></i>
                    <p class="text-sm text-gray-600">Buscando resultados...</p>
                </div>
            `;

            searchResultsDropdown.classList.remove('hidden');
            searchResultsContent.innerHTML = loadingHTML;

            if (mobileSearchResultsDropdown && mobileSearchResultsContent) {
                mobileSearchResultsDropdown.classList.remove('hidden');
                mobileSearchResultsContent.innerHTML = loadingHTML;
            }

            // Delay para reduzir o número de requisições
            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        };
    }

    // Detectar quando o usuário digita na pesquisa desktop
    searchInput.addEventListener('input', handleSearchInput(false));

    // Detectar quando o usuário digita na pesquisa mobile
    if (mobileSearchInput) {
        mobileSearchInput.addEventListener('input', handleSearchInput(true));
    }

    // Focar no input desktop mostra os resultados anteriores se existirem
    searchInput.addEventListener('focus', function() {
        const query = this.value.trim();
        if (query.length >= 2 && searchResultsContent.children.length > 0) {
            searchResultsDropdown.classList.remove('hidden');
        }
    });

    // Focar no input mobile mostra os resultados anteriores se existirem
    if (mobileSearchInput && mobileSearchResultsDropdown && mobileSearchResultsContent) {
        mobileSearchInput.addEventListener('focus', function() {
            const query = this.value.trim();
            if (query.length >= 2 && mobileSearchResultsContent.children.length > 0) {
                mobileSearchResultsDropdown.classList.remove('hidden');
            }
        });
    }

    // Fechar dropdown quando clicar fora
    document.addEventListener('click', function(e) {
        const isDesktopSearch = searchInput.contains(e.target) || searchResultsDropdown.contains(e.target);
        const isMobileSearch = mobileSearchInput && (mobileSearchInput.contains(e.target) ||
            (mobileSearchResultsDropdown && mobileSearchResultsDropdown.contains(e.target)));

        if (!isDesktopSearch) {
            searchResultsDropdown.classList.add('hidden');
        }

        if (mobileSearchResultsDropdown && !isMobileSearch) {
            mobileSearchResultsDropdown.classList.add('hidden');
        }
    });

    // Impedir que cliques dentro do dropdown fechem o dropdown
    searchResultsDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Função para realizar a pesquisa via AJAX
    function performSearch(query) {
        fetch(`/api/search?q=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Falha na requisição');
                }
                return response.json();
            })
            .then(data => {
                displayResults(data, query);
            })
            .catch(error => {
                console.error('Erro na pesquisa:', error);
                searchResultsContent.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-8 px-4 text-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-3xl mb-3"></i>
                        <p class="text-sm text-gray-600">Erro ao realizar a pesquisa. Tente novamente.</p>
                    </div>
                `;
            });
    }

    // Função para exibir os resultados
    function displayResults(results, query) {
        if ((!results.livros || !results.livros.length) &&
            (!results.usuarios || !results.usuarios.length)) {
            searchResultsContent.innerHTML = `
                <div class="flex flex-col items-center justify-center py-8 px-4 text-center">
                    <i class="fas fa-search text-gray-400 text-3xl mb-3"></i>
                    <p class="text-sm text-gray-600">Nenhum resultado encontrado para "${query}"</p>
                </div>
            `;
            return;
        }

        let html = '';

        // Adiciona resultados de livros
        if (results.livros && results.livros.length > 0) {
            html += `
                <div class="mb-2">
                    <div class="px-4 py-2 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Livros</h3>
                    </div>
            `;

            results.livros.forEach(livro => {
                const disponibilidade = livro.disponivel ?
                    '<span class="inline-flex items-center gap-1 text-xs text-green-600 font-medium"><i class="fas fa-check-circle"></i> Disponível</span>' :
                    '<span class="inline-flex items-center gap-1 text-xs text-red-600 font-medium"><i class="fas fa-times-circle"></i> Indisponível</span>';
                const tituloHighlighted = highlightMatch(livro.titulo, query);
                // Separar título e subtítulo se houver
                let titulo = tituloHighlighted;
                let subtitulo = '';
                if (tituloHighlighted.includes(':')) {
                    [titulo, subtitulo] = tituloHighlighted.split(/:(.+)/).map(s => s.trim());
                } else if (tituloHighlighted.match(/(.+)(Vol|vol|Volume|volume)\s*\d+/)) {
                    const match = tituloHighlighted.match(/(.+?)(\s*(Vol|vol|Volume|volume)\s*\d+.*)/);
                    if (match) {
                        titulo = match[1].trim();
                        subtitulo = match[2].trim();
                    }
                }
                html += `
                    <div class="flex items-start gap-3 px-4 py-3 hover:bg-amber-50 cursor-pointer transition-colors duration-200 border-b border-gray-100 last:border-b-0" data-href="/books/${livro.id}">
                        <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-lg bg-amber-100">
                            <i class="fas fa-book text-amber-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-gray-900 text-sm mb-1">
                                <div>${titulo}</div>
                                ${subtitulo ? `<div class="text-xs text-gray-500 mt-0.5">${subtitulo}</div>` : ''}
                            </div>
                            <div class="mb-1">${disponibilidade}</div>
                            <div class="text-xs text-gray-600">Autor: ${livro.autor}</div>
                        </div>
                    </div>
                `;
            });

            html += `</div>`;
        }

        // Adiciona resultados de usuários
        if (results.usuarios && results.usuarios.length > 0) {
            html += `
                <div class="mb-2">
                    <div class="px-4 py-2 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Usuários</h3>
                    </div>
            `;

            results.usuarios.forEach(usuario => {
                const nomeHighlighted = highlightMatch(usuario.nome, query);

                html += `
                    <div class="flex items-start gap-3 px-4 py-3 hover:bg-amber-50 cursor-pointer transition-colors duration-200 border-b border-gray-100 last:border-b-0" data-href="/users/${usuario.id}">
                        <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-lg bg-amber-100">
                            <i class="fas fa-user text-amber-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-gray-900 text-sm mb-1">${nomeHighlighted}</div>
                            <div class="text-xs text-gray-600 truncate">${usuario.email}</div>
                        </div>
                    </div>
                `;
            });

            html += `</div>`;
        }

        searchResultsContent.innerHTML = html;

        // Atualizar também o mobile se existir
        if (mobileSearchResultsContent) {
            mobileSearchResultsContent.innerHTML = html;
        }

        // Adicionar manipuladores de eventos para os itens de resultado
        document.querySelectorAll('[data-href]').forEach(item => {
            item.addEventListener('click', function() {
                const href = this.getAttribute('data-href');
                if (href) {
                    window.location.href = href;
                }
            });
        });
    }

    // Função para destacar o texto pesquisado
    function highlightMatch(text, query) {
        if (!query || !text) return text || '';
        try {
            const regex = new RegExp(`(${escapeRegExp(query)})`, 'gi');
            return text.replace(regex, '<span class="bg-amber-200 text-amber-900 px-0.5 rounded">$1</span>');
        } catch (e) {
            console.error('Erro ao destacar texto:', e);
            return text;
        }
    }

    // Função para escapar caracteres especiais em regex
    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }
});