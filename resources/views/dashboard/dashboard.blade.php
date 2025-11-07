@extends('layouts.app')

@section('title', 'Dashboard - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Dashboard')

@section('breadcrumb')
<span>Dashboard</span>
@endsection

@section('styles')
    @vite(['resources/css/dashboard/dashboard.css'])
@endsection

@section('content')

<!-- Status Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Total Livros Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 overflow-hidden border-l-4 border-amber-500">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Livros</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalLivros ?? 0 }}</h3>
                </div>
                <div class="h-12 w-12 rounded-full bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-book text-xl text-amber-600"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                @if(isset($livrosPercentChange) && $livrosPercentChange >= 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-arrow-up mr-1"></i> {{ $livrosPercentChange }}%
                    </span>
                @elseif(isset($livrosPercentChange))
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <i class="fas fa-arrow-down mr-1"></i> {{ abs($livrosPercentChange) }}%
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-arrow-up mr-1"></i> 0%
                    </span>
                @endif
                <span class="text-gray-500 ml-2">desde o último mês</span>
            </div>
        </div>
    </div>

    <!-- Aluguéis Ativos Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 overflow-hidden border-l-4 border-blue-500">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Aluguéis Ativos</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalAlugueis ?? 0 }}</h3>
                </div>
                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-handshake text-xl text-blue-600"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                @if(isset($alugueisPeriodChange) && $alugueisPeriodChange >= 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-arrow-up mr-1"></i> {{ $alugueisPeriodChange }}%
                    </span>
                @elseif(isset($alugueisPeriodChange))
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <i class="fas fa-arrow-down mr-1"></i> {{ abs($alugueisPeriodChange) }}%
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-arrow-up mr-1"></i> 0%
                    </span>
                @endif
                <span class="text-gray-500 ml-2">desde o último mês</span>
            </div>
        </div>
    </div>

    <!-- Atrasos Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 overflow-hidden border-l-4 border-red-500">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Atrasos</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalAtrasos ?? 0 }}</h3>
                </div>
                <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-xl text-red-600"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                @if(isset($atrasosPeriodChange) && $atrasosPeriodChange >= 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-arrow-up mr-1"></i> {{ $atrasosPeriodChange }}%
                    </span>
                @elseif(isset($atrasosPeriodChange))
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <i class="fas fa-arrow-down mr-1"></i> {{ abs($atrasosPeriodChange) }}%
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <i class="fas fa-arrow-down mr-1"></i> 0%
                    </span>
                @endif
                <span class="text-gray-500 ml-2">desde o último mês</span>
            </div>
        </div>
    </div>

    <!-- Total Usuários Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 overflow-hidden border-l-4 border-green-500">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Usuários</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalUsuarios ?? 0 }}</h3>
                </div>
                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-users text-xl text-green-600"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                @if(isset($usuariosPercentChange) && $usuariosPercentChange >= 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-arrow-up mr-1"></i> {{ $usuariosPercentChange }}%
                    </span>
                @elseif(isset($usuariosPercentChange))
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <i class="fas fa-arrow-down mr-1"></i> {{ abs($usuariosPercentChange) }}%
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-arrow-up mr-1"></i> 0%
                    </span>
                @endif
                <span class="text-gray-500 ml-2">desde o último mês</span>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex flex-col sm:flex-row gap-3 mb-8">
    <a href="{{ route('books.create') }}" class="flex items-center justify-center px-6 py-3 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 transition-colors duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-plus mr-2"></i> Novo Livro
    </a>
    <a href="{{ route('users.create') }}" class="flex items-center justify-center px-6 py-3 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 transition-colors duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-user-plus mr-2"></i> Novo Usuário
    </a>
    <a href="{{ route('rentals.create') }}" class="flex items-center justify-center px-6 py-3 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 transition-colors duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-handshake mr-2"></i> Novo Aluguel
    </a>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-7 gap-6">
    <!-- Recent Rentals Table -->
    <div class="lg:col-span-4 bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-900">Aluguéis Recentes</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Livro</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Usuário</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aluguel</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Retorno</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($alugueis->sortByDesc('id_aluguel') ?? [] as $aluguel)
                        <tr class="hover:bg-gray-50 transition-colors duration-200 {{ $aluguel->isAtrasado() ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $aluguel->livro->titulo ?? 'Livro não encontrado' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $aluguel->usuario->nome ?? 'Usuário não encontrado' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($aluguel->dt_aluguel)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($aluguel->dt_devolucao)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($aluguel->ds_status == 'Ativo')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-check-circle mr-1"></i> Ativo
                                    </span>
                                @elseif($aluguel->ds_status == 'Atrasado')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-circle mr-1"></i> Atrasado
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-double mr-1"></i> Devolvido
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500">Nenhum aluguel encontrado</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-200 px-6 py-4">
            <a href="{{ route('rentals.index') }}" class="inline-flex items-center text-amber-600 hover:text-amber-700 font-medium text-sm transition-colors duration-200">
                Ver todos os aluguéis <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Popular Books -->
    <div class="lg:col-span-3 bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-900">Livros Populares</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($livrosPopulares ?? [] as $livro)
                <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex gap-4">
                        <!-- Book Cover -->
                        <div class="flex-shrink-0">
                            <div class="h-24 w-16 rounded-lg bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center overflow-hidden">
                                <i class="fas fa-book text-2xl text-white"></i>
                            </div>
                        </div>
                        <!-- Book Info -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-900 truncate">
                                {{ $livro['titulo'] ?? $livro->getAttribute('titulo') ?? 'Título não disponível' }}
                            </h4>
                            <p class="text-xs text-gray-600 mt-1">
                                {{ $livro['autor'] ?? $livro->getAttribute('autor') ?? 'Autor desconhecido' }}
                            </p>
                            <div class="flex flex-col gap-2 mt-3">
                                <span class="text-xs text-gray-600">
                                    <i class="fas fa-users text-amber-500 mr-1"></i>
                                    {{ $livro['total_alugueis'] ?? $livro->getAttribute('total_alugueis') ?? 0 }} aluguéis
                                </span>
                                <span class="text-xs text-gray-600">
                                    <i class="fas fa-copy text-amber-500 mr-1"></i>
                                    {{ $livro['quantidade'] ?? $livro->getAttribute('quantidade') ?? 0 }} exemplares
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 flex flex-col items-center justify-center">
                    <i class="fas fa-book text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-center">Ainda não há dados sobre livros populares.</p>
                </div>
            @endforelse
        </div>
        <div class="border-t border-gray-200 px-6 py-4">
            <a href="{{ route('books.index') }}" class="inline-flex items-center text-amber-600 hover:text-amber-700 font-medium text-sm transition-colors duration-200">
                Ver catálogo completo <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>

@endsection
