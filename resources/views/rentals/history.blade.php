@extends('layouts.app')

@section('title', 'Histórico de Aluguéis - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Histórico de Aluguéis')

@vite(['resources/css/rentals/rentals.css'])

@section('breadcrumb')
<a href="{{ route('rentals.index') }}">Aluguéis</a> / <span>Histórico</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-lg shadow-md border-l-4 border-blue-500 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Histórico de Aluguéis</h2>
                <p class="text-gray-600 text-sm mt-1">Aluguéis já realizados e devolvidos</p>
            </div>
            <button class="flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm font-medium" id="toggleFilter">
                <i class="fas fa-filter mr-2"></i> Filtrar
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filter-container bg-white rounded-lg shadow-md p-4 sm:p-6 hidden">
        <form action="{{ route('rentals.history') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700 mb-2">Usuário</label>
                    <input type="text" id="user" name="user" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Nome do usuário" value="{{ request('user') }}" autocomplete="off">
                </div>
                <div>
                    <label for="book" class="block text-sm font-medium text-gray-700 mb-2">Livro</label>
                    <input type="text" id="book" name="book" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Título do livro" value="{{ request('book') }}" autocomplete="off">
                </div>
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Data Inicial</label>
                    <input type="date" id="start_date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" value="{{ request('start_date') }}">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Data Final</label>
                    <input type="date" id="end_date" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" value="{{ request('end_date') }}">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 pt-2">
                <button type="submit" class="flex items-center justify-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                    <i class="fas fa-search mr-2"></i> Filtrar
                </button>
                <a href="{{ route('rentals.history') }}" class="flex items-center justify-center px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200 text-sm font-medium">
                    <i class="fas fa-redo mr-2"></i> Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Content Section -->
    @if(count($alugueis) > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Mobile Cards View -->
            <div class="block lg:hidden space-y-4 p-4 sm:p-6">
                @foreach($alugueis as $aluguel)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm">
                                    <a href="{{ route('books.show', $aluguel->id_livro) }}" class="text-blue-600 hover:text-blue-700">
                                        {{ $aluguel->livro->titulo }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-xs mt-1">
                                    <a href="{{ route('users.show', $aluguel->id_usuario) }}" class="hover:text-blue-600">
                                        {{ $aluguel->usuario->nome }}
                                    </a>
                                </p>
                            </div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                ✓ Devolvido
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <p class="text-gray-600">Saída</p>
                                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($aluguel->dt_aluguel)->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Devolução</p>
                                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($aluguel->dt_devolucao)->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-600">Duração</p>
                                <p class="font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($aluguel->dt_aluguel)->diffInDays(\Carbon\Carbon::parse($aluguel->dt_devolucao)) }} dias
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Usuário</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Livro</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Data Saída</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Data Devolução</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Duração</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($alugueis as $aluguel)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('users.show', $aluguel->id_usuario) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        {{ $aluguel->usuario->nome }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('books.show', $aluguel->id_livro) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        {{ $aluguel->livro->titulo }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($aluguel->dt_aluguel)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($aluguel->dt_devolucao)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                        {{ \Carbon\Carbon::parse($aluguel->dt_aluguel)->diffInDays(\Carbon\Carbon::parse($aluguel->dt_devolucao)) }} dias
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="border-t border-gray-200 px-4 sm:px-6 py-4">
                {{ $alugueis->links('components.pagination') }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-history text-3xl text-gray-400"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Nenhum histórico encontrado</h3>
            <p class="text-gray-600">Não existem registros de devoluções até o momento.</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleFilter = document.getElementById('toggleFilter');
        const filterContainer = document.querySelector('.filter-container');

        // Verificar se há filtros aplicados
        const urlParams = new URLSearchParams(window.location.search);
        const hasFilters = urlParams.has('user') || urlParams.has('book') ||
                          urlParams.has('start_date') || urlParams.has('end_date');

        // Mostrar filtros automaticamente se houver algum aplicado
        if (hasFilters) {
            filterContainer.classList.remove('hidden');
        }

        toggleFilter.addEventListener('click', function() {
            filterContainer.classList.toggle('hidden');
        });
    });
</script>
@endpush
@endsection
