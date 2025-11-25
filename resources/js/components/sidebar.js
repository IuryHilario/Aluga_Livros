/**
 * Sidebar Responsivo - Controle de Toggle e Interações
 */

document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    if (!sidebarToggle || !sidebar || !sidebarOverlay) {
        console.warn('Elementos da sidebar não encontrados');
        return;
    }

    /**
     * Toggle da sidebar (mobile/tablet)
     */
    function toggleSidebar() {
        const isHidden = sidebar.classList.contains('-translate-x-full');

        if (isHidden) {
            // Abrir sidebar
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevenir scroll do body
        } else {
            // Fechar sidebar
            closeSidebar();
        }
    }

    /**
     * Fechar sidebar
     */
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
        document.body.style.overflow = ''; // Restaurar scroll do body
    }

    /**
     * Event Listeners
     */

    // Toggle button
    sidebarToggle.addEventListener('click', toggleSidebar);

    // Click no overlay
    sidebarOverlay.addEventListener('click', closeSidebar);

    // Fechar ao pressionar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
            closeSidebar();
        }
    });

    // Fechar sidebar ao clicar em links (apenas mobile)
    function handleSidebarLinks() {
        if (window.innerWidth < 1024) {
            const sidebarLinks = sidebar.querySelectorAll('a:not([href="#"])');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Pequeno delay para permitir a navegação antes de fechar
                    setTimeout(closeSidebar, 100);
                });
            });
        }
    }

    handleSidebarLinks();

    // Reconfigurar ao redimensionar a janela
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 1024) {
                // Desktop: garantir que sidebar esteja visível
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                // Mobile: garantir que sidebar esteja escondida
                if (!sidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            }

            // Reconfigurar event listeners
            handleSidebarLinks();
        }, 250);
    });

    /**
     * Highlight do menu ativo (adicional)
     * Marcar o item do menu baseado na URL atual
     */
    function highlightActiveMenu() {
        const currentPath = window.location.pathname;
        const menuLinks = sidebar.querySelectorAll('a[href]');

        menuLinks.forEach(link => {
            const linkPath = new URL(link.href).pathname;

            // Remover classes ativas existentes
            link.classList.remove('bg-amber-100', 'text-amber-800', 'border-l-4', 'border-amber-600', 'font-medium', 'text-amber-700');

            // Adicionar classe ativa se corresponder
            if (linkPath === currentPath || currentPath.startsWith(linkPath + '/')) {
                const isMainLink = !link.closest('ul[x-show]');

                if (isMainLink) {
                    link.classList.add('bg-amber-100', 'text-amber-800', 'border-l-4', 'border-amber-600');
                } else {
                    link.classList.add('text-amber-700', 'font-medium');
                }
            }
        });
    }

    // Executar ao carregar
    highlightActiveMenu();

    /**
     * Smooth scroll para links âncora (se houver)
     */
    sidebar.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    closeSidebar();
                }
            }
        });
    });

    /**
     * Indicador de conexão/status (opcional)
     */
    function addConnectionIndicator() {
        const header = sidebar.querySelector('.border-b');
        if (header && !document.getElementById('connection-status')) {
            const indicator = document.createElement('div');
            indicator.id = 'connection-status';
            indicator.className = 'flex items-center justify-center gap-2 text-xs text-gray-500 mt-2';
            indicator.innerHTML = `
                <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                <span>Online</span>
            `;
            header.appendChild(indicator);
        }
    }

    addConnectionIndicator();
});
