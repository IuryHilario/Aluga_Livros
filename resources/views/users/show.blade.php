@extends('layouts.app')

@section('title', 'Detalhes do Usuário - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Detalhes do Usuário')

@section('breadcrumb')
<a href="{{ route('users.index') }}">Usuários</a> / <span>Detalhes</span>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-amber-50 to-amber-100 px-4 sm:px-6 lg:px-8 py-6 border-b border-amber-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900">Informações do Usuário</h3>
        <div>
            <x-form.actions
                edit="{{ route('users.edit', $usuario->id_usuario) }}"
                delete="{{ route('users.destroy', $usuario->id_usuario) }}"
            />
        </div>
    </div>

    <!-- Body -->
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- User Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-8 pb-8 border-b border-gray-200">
            <div class="h-20 w-20 flex-shrink-0 flex items-center justify-center rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-white font-bold text-3xl shadow-lg">
                {{ strtoupper(substr($usuario->nome, 0, 1)) }}
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $usuario->nome }}</h2>
                <p class="text-gray-600 flex items-center gap-2">
                    <i class="fas fa-envelope"></i> {{ $usuario->email }}
                </p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-lg bg-blue-500 text-white">
                        <i class="fas fa-book text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-700 font-medium">Livros Ativos</p>
                        <p class="text-2xl font-bold text-blue-600">{{ count($usuario->alugueis->where('ds_status', '!=', 'Devolvido')) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-lg bg-green-500 text-white">
                        <i class="fas fa-exchange-alt text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-700 font-medium">Total de Aluguéis</p>
                        <p class="text-2xl font-bold text-green-600">{{ count($usuario->alugueis) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-lg bg-red-500 text-white">
                        <i class="fas fa-clock text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-700 font-medium">Atrasos</p>
                        <p class="text-2xl font-bold text-red-600">{{ count($usuario->alugueis->where('ds_status', 'Atrasado')) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-user-tag text-amber-600"></i> Informações Pessoais
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-2">
                        <i class="fas fa-phone text-amber-600"></i> Telefone
                    </p>
                    <p class="font-medium text-gray-900">{{ $usuario->telefone ?? 'Não informado' }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-2">
                        <i class="fas fa-layer-group text-amber-600"></i> Máximo de Livros
                    </p>
                    <p class="font-medium text-gray-900">{{ $usuario->max_emprestimos ?? ($settings['max_loans_per_user'] ?? 3) }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-2">
                        <i class="fas fa-calendar-plus text-amber-600"></i> Data de Cadastro
                    </p>
                    <p class="font-medium text-gray-900">{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-2">
                        <i class="fas fa-calendar-check text-amber-600"></i> Última Atualização
                    </p>
                    <p class="font-medium text-gray-900">{{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Rentals History -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-book-reader text-amber-600"></i> Histórico de Aluguéis
            </h3>

            @if(count($usuario->alugueis) > 0)
                <div class="space-y-4">
                    @foreach($usuario->alugueis as $aluguel)
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 {{ strtolower($aluguel->ds_status) == 'devolvido' ? 'border-green-500' : (strtolower($aluguel->ds_status) == 'atrasado' ? 'border-red-500' : 'border-blue-500') }}">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="font-semibold text-gray-900">{{ $aluguel->livro->titulo ?? 'N/A' }}</h4>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ strtolower($aluguel->ds_status) == 'devolvido' ? 'bg-green-100 text-green-800' : (strtolower($aluguel->ds_status) == 'atrasado' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                            {{ $aluguel->ds_status }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-2 gap-3 text-sm text-gray-600">
                                        <div>
                                            <i class="fas fa-calendar-alt mr-2 text-amber-600"></i> Alugado: {{ \Carbon\Carbon::parse($aluguel->dt_aluguel)->format('d/m/Y') }}
                                        </div>
                                        <div>
                                            <i class="fas fa-calendar-check mr-2 text-amber-600"></i> Devolução: {{ \Carbon\Carbon::parse($aluguel->dt_devolucao)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-auto">
                                    <a href="{{ route('rentals.show', $aluguel->id_aluguel) }}" class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 text-sm font-medium">
                                        <i class="fas fa-info-circle mr-2"></i> Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <i class="fas fa-book text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 font-medium">Este usuário não possui aluguéis registrados.</p>
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200 font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </div>
</div>
@endsection
