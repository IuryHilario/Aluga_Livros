<?php
use App\Models\Aluguel;
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aluga Livros')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('icone-book.ico') }}?v=2" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50">
    <!-- Include Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen transition-all duration-300">
        <!-- Navbar -->
        <nav class="sticky top-0 z-20 bg-white shadow-md border-b border-gray-200">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Left Side -->
                    <div class="flex items-center gap-3 sm:gap-4 flex-1">
                        <button id="sidebar-toggle"
                                class="lg:hidden inline-flex items-center justify-center rounded-lg p-2 text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 transition-colors duration-200">
                            <i class="fas fa-bars text-lg"></i>
                        </button>

                        <!-- Search Container -->
                        <div class="relative flex-1 max-w-xl hidden sm:block">
                            <div class="relative">
                                <input type="text"
                                       id="global-search"
                                       placeholder="Pesquisar livros/usuários..."
                                       autocomplete="off"
                                       class="w-full rounded-lg border border-gray-300 bg-gray-50 py-2 pl-10 pr-4 text-sm focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition-all duration-200">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            </div>

                            <!-- Search Results Dropdown -->
                            <div id="search-results-dropdown"
                                 class="absolute left-0 right-0 top-full mt-2 hidden rounded-lg bg-white shadow-xl border border-gray-200 max-h-96 overflow-y-auto z-50">
                                <div id="search-results-content"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center gap-2 sm:gap-4">
                        <!-- Mobile Search Button -->
                        <button id="mobile-search-toggle"
                                class="sm:hidden inline-flex items-center justify-center rounded-lg p-2 text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 transition-colors duration-200">
                            <i class="fas fa-search text-lg"></i>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="relative inline-flex items-center justify-center rounded-lg p-2 text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 transition-colors duration-200">
                                <i class="fas fa-bell text-lg"></i>
                                @php
                                    $overdueRentals = Aluguel::with(['usuario', 'livro'])
                                        ->where('ds_status', Aluguel::STATUS_ATRASADO)
                                        ->orWhere(function ($query) {
                                            $query->where('ds_status', Aluguel::STATUS_ATIVO)
                                                ->where('dt_devolucao', '<', Carbon::now()->format('Y-m-d'));
                                        })
                                        ->orderBy('dt_devolucao', 'DESC')
                                        ->limit(5)
                                        ->get();
                                    $overdueCount = count($overdueRentals);
                                @endphp
                                @if($overdueCount > 0)
                                    <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">
                                        {{ $overdueCount > 9 ? '9+' : $overdueCount }}
                                    </span>
                                @endif
                            </button>

                            <!-- Notification Menu -->
                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 top-full mt-2 w-80 sm:w-96 rounded-lg bg-white shadow-xl border border-gray-200 z-50"
                                 style="display: none;">

                                <!-- Header -->
                                <div class="border-b border-gray-200 px-4 py-3">
                                    <h3 class="font-semibold text-gray-900">Notificações de Atraso</h3>
                                </div>

                                <!-- Notification List -->
                                <div class="max-h-96 overflow-y-auto">
                                    @if($overdueCount > 0)
                                        @foreach($overdueRentals as $rental)
                                            <a href="{{ route('rentals.show', $rental->id_aluguel) }}"
                                               class="flex items-start gap-3 border-b border-gray-100 px-4 py-3 hover:bg-gray-50 transition-colors duration-200">
                                                <div class="flex-shrink-0">
                                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
                                                        <i class="fas fa-exclamation-circle text-red-600"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        Aluguel de {{ $rental->usuario->nome }} está atrasado
                                                    </p>
                                                    <p class="text-sm text-gray-600 truncate">
                                                        Livro: {{ $rental->livro->titulo }}
                                                    </p>
                                                    <p class="text-xs text-red-600 mt-1">
                                                        {{ $rental->diasAtraso() }} dias de atraso
                                                    </p>
                                                </div>
                                            </a>
                                        @endforeach
                                    @else
                                        <div class="flex flex-col items-center justify-center py-8 px-4 text-center">
                                            <i class="fas fa-check-circle text-4xl text-green-500 mb-3"></i>
                                            <p class="text-sm text-gray-600">Não há aluguéis em atraso</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Footer -->
                                @if($overdueCount > 0)
                                    <div class="border-t border-gray-200 px-4 py-3">
                                        <a href="{{ route('rentals.index') }}?status=Atrasado"
                                           class="block text-center text-sm font-medium text-amber-600 hover:text-amber-700 transition-colors duration-200">
                                            Ver todos os atrasos
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 rounded-lg px-2 sm:px-3 py-2 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 transition-colors duration-200">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=7b5d48&color=fff"
                                     alt="User Avatar"
                                     class="h-8 w-8 rounded-full ring-2 ring-amber-200">
                                <span class="hidden sm:block text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'User' }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 hidden sm:block"></i>
                            </button>

                            <!-- User Dropdown Menu -->
                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 top-full mt-2 w-48 rounded-lg bg-white shadow-xl border border-gray-200 py-1 z-50"
                                 style="display: none;">
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <i class="fas fa-user-circle w-4 text-center"></i>
                                    <span>Meu Perfil</span>
                                </a>
                                <a href="{{ route('settings.index') }}"
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <i class="fas fa-cog w-4 text-center"></i>
                                    <span>Configurações</span>
                                </a>
                                <hr class="my-1 border-gray-200">
                                <a href="{{ route('logout') }}"
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt w-4 text-center"></i>
                                    <span>Sair</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Search Bar -->
                <div id="mobile-search-bar" class="hidden pb-4 sm:hidden">
                    <div class="relative">
                        <input type="text"
                               id="mobile-global-search"
                               placeholder="Pesquisar livros/usuários..."
                               autocomplete="off"
                               class="w-full rounded-lg border border-gray-300 bg-gray-50 py-2 pl-10 pr-4 text-sm focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition-all duration-200">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    </div>

                    <!-- Mobile Search Results -->
                    <div id="mobile-search-results-dropdown"
                         class="mt-2 hidden rounded-lg bg-white shadow-xl border border-gray-200 max-h-80 overflow-y-auto">
                        <div id="mobile-search-results-content"></div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="px-4 py-6 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">
                    @yield('page-title', 'Dashboard')
                </h1>
                <nav class="flex items-center text-sm text-gray-600">
                    <a href="{{ route('dashboard') }}" class="hover:text-amber-600 transition-colors duration-200">
                        <i class="fas fa-home mr-1"></i>
                        Home
                    </a>
                    <i class="fas fa-chevron-right mx-2 text-xs"></i>
                    <span class="text-gray-900">@yield('breadcrumb')</span>
                </nav>
            </div>

            <!-- Main Content -->
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile Search Toggle
            const mobileSearchToggle = document.getElementById('mobile-search-toggle');
            const mobileSearchBar = document.getElementById('mobile-search-bar');

            if (mobileSearchToggle && mobileSearchBar) {
                mobileSearchToggle.addEventListener('click', function () {
                    mobileSearchBar.classList.toggle('hidden');
                    if (!mobileSearchBar.classList.contains('hidden')) {
                        document.getElementById('mobile-global-search')?.focus();
                    }
                });
            }

            // Sync mobile and desktop search
            const desktopSearch = document.getElementById('global-search');
            const mobileSearch = document.getElementById('mobile-global-search');

            if (desktopSearch && mobileSearch) {
                desktopSearch.addEventListener('input', function () {
                    mobileSearch.value = this.value;
                });

                mobileSearch.addEventListener('input', function () {
                    desktopSearch.value = this.value;
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/js/global/search.js'])
    @stack('scripts')
</body>

</html>