@extends('layouts.app')

@section('title', 'Relatórios - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Relatórios')

@section('breadcrumb')
<span>Relatórios</span>
@endsection

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <!-- Total Livros -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Livros</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $reportData['totalBooks'] }}</h3>
            </div>
            <div class="text-4xl text-blue-500 opacity-20">
                <i class="fas fa-book"></i>
            </div>
        </div>
    </div>

    <!-- Total Exemplares -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Exemplares</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $reportData['totalCopies'] }}</h3>
            </div>
            <div class="text-4xl text-purple-500 opacity-20">
                <i class="fas fa-copy"></i>
            </div>
        </div>
    </div>

    <!-- Total Usuários -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Usuários</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $reportData['totalUsers'] }}</h3>
            </div>
            <div class="text-4xl text-green-500 opacity-20">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Aluguéis Ativos -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Aluguéis Ativos</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $reportData['activeRentals'] }}</h3>
            </div>
            <div class="text-4xl text-orange-500 opacity-20">
                <i class="fas fa-handshake"></i>
            </div>
        </div>
    </div>

    <!-- Atrasos -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Atrasos</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $reportData['overdueRentals'] }}</h3>
            </div>
            <div class="text-4xl text-red-500 opacity-20">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas Mensais -->
<div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 sm:mb-0">Estatísticas Mensais (Últimos 6 Meses)</h3>
        <a href="{{ route('reports.pdf') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-200" title="Exportar para PDF">
            <i class="fas fa-file-pdf"></i>
            <span class="hidden sm:inline">Exportar PDF</span>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Mês</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Novos Aluguéis</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Devoluções</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Atrasos</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($monthlyStats as $stats)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $stats['month'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $stats['newRentals'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                {{ $stats['returnedRentals'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                {{ $stats['overdueCount'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Livros Mais Populares -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Livros Mais Populares</h3>
        </div>
        <div class="overflow-x-auto">
            @if(count($topBooks) > 0)
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Título</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Autor</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aluguéis</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($topBooks as $book)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $book->titulo }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $book->autor }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                        {{ $book->aluguel_count }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-book text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 mt-2">Sem dados de livros para exibir.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Usuários Mais Ativos -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Usuários Mais Ativos</h3>
        </div>
        <div class="overflow-x-auto">
            @if(count($activeUsers) > 0)
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nome</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aluguéis</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($activeUsers as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $user->nome }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                                        {{ $user->aluguel_count }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-users text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 mt-2">Sem dados de usuários para exibir.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Aluguéis em Atraso -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 sm:mb-0">Aluguéis em Atraso</h3>
        <button class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors duration-200" id="toggleOverdueFilter" title="Filtrar">
            <i class="fas fa-filter"></i>
            <span class="hidden sm:inline">Filtrar</span>
        </button>
    </div>

    <!-- Filter Form -->
    <div id="overdue-filter-container" class="hidden bg-gray-50 p-6 border-b border-gray-200">
        <form id="overdueFilterForm" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
                    <input type="date" id="start_date" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200" value="{{ request('start_date') }}">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
                    <input type="date" id="end_date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200" value="{{ request('end_date') }}">
                </div>
                <div>
                    <label for="min_days" class="block text-sm font-medium text-gray-700 mb-2">Mínimo de Dias</label>
                    <input type="number" id="min_days" name="min_days" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200" value="{{ request('min_days') }}" min="1">
                </div>
                <div class="flex gap-2 items-end">
                    <button type="submit" class="flex-1 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-medium transition-colors duration-200">
                        Filtrar
                    </button>
                    <button type="button" id="clearFilters" class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium transition-colors duration-200">
                        Limpar
                    </button>
                </div>
            </div>
            <div id="filter-loading" class="hidden text-center text-amber-600">
                <i class="fas fa-spinner fa-spin mr-2"></i> Carregando...
            </div>
        </form>
    </div>

    <!-- Rentals Table -->
    <div class="overflow-x-auto" id="overdueRentalsContent">
        @if(count($overdueRentals) > 0)
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Usuário</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Livro</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Data Devolução</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Dias em Atraso</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($overdueRentals as $rental)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $rental->id_aluguel }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $rental->usuario->nome }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $rental->livro->titulo }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($rental->dt_devolucao)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    {{ $rental->diasAtraso() }} dias
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('rentals.show', $rental->id_aluguel) }}" class="inline-flex items-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200" title="Ver Detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="inline-flex items-center px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors duration-200 notify" data-id="{{ $rental->id_usuario }}" title="Notificar Usuário">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-12 text-center">
                <i class="fas fa-check-circle text-5xl text-green-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Não há aluguéis em atraso no momento.</p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup notification buttons
        function setupNotificationButtons() {
            const notifyButtons = document.querySelectorAll('.notify');
            notifyButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Notificar Usuário',
                        text: `Enviar notificação para o usuário ID: ${userId}?`,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#f59e0b',
                        cancelButtonColor: '#d1d5db',
                        confirmButtonText: 'Sim, notificar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: 'Usuário notificado com sucesso.',
                                icon: 'success'
                            });
                        }
                    });
                });
            });
        }

        // Toggle filter container
        const toggleOverdueFilter = document.getElementById('toggleOverdueFilter');
        const overdueFilterContainer = document.getElementById('overdue-filter-container');

        if (toggleOverdueFilter && overdueFilterContainer) {
            toggleOverdueFilter.addEventListener('click', function() {
                overdueFilterContainer.classList.toggle('hidden');
            });
        }

        // AJAX form submission
        const overdueFilterForm = document.getElementById('overdueFilterForm');
        const overdueRentalsContent = document.getElementById('overdueRentalsContent');
        const filterLoading = document.getElementById('filter-loading');

        if (overdueFilterForm && overdueRentalsContent) {
            overdueFilterForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validação de datas
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;

                if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'A data inicial não pode ser maior que a data final',
                        icon: 'error'
                    });
                    return false;
                }

                // Mostrar indicador de carregamento
                if (filterLoading) {
                    filterLoading.classList.remove('hidden');
                }

                // Montar os parâmetros do filtro
                const formData = new FormData(overdueFilterForm);
                const params = new URLSearchParams();

                for (const [key, value] of formData.entries()) {
                    if (value) {
                        params.append(key, value);
                    }
                }

                // Fazer a requisição AJAX
                fetch(`{{ route('reports.overdue-filter') }}?${params.toString()}`)
                    .then(response => response.text())
                    .then(html => {
                        // Atualizar o conteúdo com os resultados filtrados
                        overdueRentalsContent.innerHTML = html;

                        // Registrar novamente os listeners para os botões de notificação
                        setupNotificationButtons();

                        // Ocultar indicador de carregamento
                        if (filterLoading) {
                            filterLoading.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao filtrar aluguéis em atraso:', error);
                        if (filterLoading) {
                            filterLoading.classList.add('hidden');
                        }
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao filtrar os aluguéis. Por favor, tente novamente.',
                            icon: 'error'
                        });
                    });
            });

            // Limpar filtros
            const clearFilters = document.getElementById('clearFilters');
            if (clearFilters) {
                clearFilters.addEventListener('click', function() {
                    // Limpar campos de filtro
                    document.getElementById('start_date').value = '';
                    document.getElementById('end_date').value = '';
                    document.getElementById('min_days').value = '';

                    // Submeter o form para mostrar todos os aluguéis em atraso
                    overdueFilterForm.dispatchEvent(new Event('submit'));
                });
            }
        }

        // Initial setup
        setupNotificationButtons();
    });
</script>
@endpush
