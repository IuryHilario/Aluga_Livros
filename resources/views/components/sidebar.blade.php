<!-- Sidebar Component -->
<aside id="sidebar" class="fixed left-0 top-0 z-40 h-screen w-64 bg-white shadow-lg transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    <!-- Header -->
    <div class="flex flex-col items-center border-b border-amber-100 bg-gradient-to-b from-amber-50 to-white p-6">
        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-amber-400 to-amber-600 shadow-lg">
            <i class="fas fa-book-open text-3xl text-white"></i>
        </div>
        <h1 class="text-center text-xl font-semibold text-amber-800">
            {{ $settings['system_name'] ?? 'Aluga Livros' }}
        </h1>
    </div>

    <!-- Menu -->
    <nav class="h-[calc(100vh-140px)] overflow-y-auto px-3 py-5">
        <!-- Menu Principal -->
        <div class="mb-2">
            <h3 class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                Menu Principal
            </h3>
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->is('dashboard*') ? 'bg-amber-100 text-amber-800 border-l-4 border-amber-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-tachometer-alt {{ request()->is('dashboard*') ? 'text-amber-600' : 'text-amber-500' }} mr-3 w-5 text-center text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Livros -->
                <li x-data="{ open: {{ request()->is('books*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->is('books*') ? 'bg-amber-100 text-amber-800 border-l-4 border-amber-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <div class="flex items-center">
                            <i class="fas fa-book {{ request()->is('books*') ? 'text-amber-600' : 'text-amber-500' }} mr-3 w-5 text-center text-lg"></i>
                            <span>Livros</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <ul x-show="open" x-collapse class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-4">
                        <li>
                            <a href="{{ route('books.index') }}"
                               class="flex items-center rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->is('books') || request()->is('books/index') ? 'text-amber-700 font-medium' : 'text-gray-600 hover:text-amber-700 hover:bg-gray-50' }}">
                                <i class="fas fa-list mr-2 w-4 text-center text-xs"></i>
                                <span>Listar Todos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('books.create') }}"
                               class="flex items-center rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->is('books/create') ? 'text-amber-700 font-medium' : 'text-gray-600 hover:text-amber-700 hover:bg-gray-50' }}">
                                <i class="fas fa-plus mr-2 w-4 text-center text-xs"></i>
                                <span>Adicionar Novo</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('books.categories') }}"
                               class="flex items-center rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->is('books/categories') ? 'text-amber-700 font-medium' : 'text-gray-600 hover:text-amber-700 hover:bg-gray-50' }}">
                                <i class="fas fa-tags mr-2 w-4 text-center text-xs"></i>
                                <span>Categorias</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Aluguéis -->
                <li x-data="{ open: {{ request()->is('rentals*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->is('rentals*') ? 'bg-amber-100 text-amber-800 border-l-4 border-amber-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <div class="flex items-center">
                            <i class="fas fa-handshake {{ request()->is('rentals*') ? 'text-amber-600' : 'text-amber-500' }} mr-3 w-5 text-center text-lg"></i>
                            <span>Aluguéis</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <ul x-show="open" x-collapse class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-4">
                        <li>
                            <a href="{{ route('rentals.index') }}"
                               class="flex items-center rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->is('rentals') || request()->is('rentals/index') ? 'text-amber-700 font-medium' : 'text-gray-600 hover:text-amber-700 hover:bg-gray-50' }}">
                                <i class="fas fa-list mr-2 w-4 text-center text-xs"></i>
                                <span>Listar Todos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('rentals.create') }}"
                               class="flex items-center rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->is('rentals/create') ? 'text-amber-700 font-medium' : 'text-gray-600 hover:text-amber-700 hover:bg-gray-50' }}">
                                <i class="fas fa-plus mr-2 w-4 text-center text-xs"></i>
                                <span>Novo Aluguel</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('rentals.history') }}"
                               class="flex items-center rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->is('rentals/history') ? 'text-amber-700 font-medium' : 'text-gray-600 hover:text-amber-700 hover:bg-gray-50' }}">
                                <i class="fas fa-history mr-2 w-4 text-center text-xs"></i>
                                <span>Histórico</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Usuários -->
                <li x-data="{ open: {{ request()->is('users*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->is('users*') ? 'bg-amber-100 text-amber-800 border-l-4 border-amber-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <div class="flex items-center">
                            <i class="fas fa-users {{ request()->is('users*') ? 'text-amber-600' : 'text-amber-500' }} mr-3 w-5 text-center text-lg"></i>
                            <span>Usuários</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <ul x-show="open" x-collapse class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-4">
                        <li>
                            <a href="{{ route('users.index') }}"
                               class="flex items-center rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->is('users') || request()->is('users/index') ? 'text-amber-700 font-medium' : 'text-gray-600 hover:text-amber-700 hover:bg-gray-50' }}">
                                <i class="fas fa-list mr-2 w-4 text-center text-xs"></i>
                                <span>Listar Todos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.create') }}"
                               class="flex items-center rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->is('users/create') ? 'text-amber-700 font-medium' : 'text-gray-600 hover:text-amber-700 hover:bg-gray-50' }}">
                                <i class="fas fa-user-plus mr-2 w-4 text-center text-xs"></i>
                                <span>Adicionar Novo</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Relatórios -->
                <li>
                    <a href="{{ route('reports.index') }}"
                       class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->is('reports*') ? 'bg-amber-100 text-amber-800 border-l-4 border-amber-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-chart-line {{ request()->is('reports*') ? 'text-amber-600' : 'text-amber-500' }} mr-3 w-5 text-center text-lg"></i>
                        <span>Relatórios</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Configurações -->
        <div class="mt-6">
            <h3 class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                Configurações
            </h3>
            <ul class="space-y-1">
                <!-- Meu Perfil -->
                <li>
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->is('profile*') ? 'bg-amber-100 text-amber-800 border-l-4 border-amber-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-user-circle {{ request()->is('profile*') ? 'text-amber-600' : 'text-amber-500' }} mr-3 w-5 text-center text-lg"></i>
                        <span>Meu Perfil</span>
                    </a>
                </li>

                <!-- Configurações do Sistema -->
                <li>
                    <a href="{{ route('settings.index') }}"
                       class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->is('settings*') ? 'bg-amber-100 text-amber-800 border-l-4 border-amber-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-cog {{ request()->is('settings*') ? 'text-amber-600' : 'text-amber-500' }} mr-3 w-5 text-center text-lg"></i>
                        <span>Configurações</span>
                    </a>
                </li>

                <!-- Sair -->
                <li>
                    <a href="{{ route('logout') }}"
                       class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-red-600 transition-all duration-200 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt mr-3 w-5 text-center text-lg"></i>
                        <span>Sair</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>

<!-- Overlay para mobile -->
<div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black bg-opacity-50 transition-opacity duration-300 lg:hidden hidden"></div>