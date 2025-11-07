@extends('layouts.app')

@section('title', 'Novo Aluguel - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Novo Aluguel')

@vite(['resources/css/rentals/rentals.css', 'resources/js/rentals/create.js'])

@section('breadcrumb')
<a href="{{ route('rentals.index') }}">Aluguéis</a> / <span>Novo</span>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Card -->
    <div class="bg-white rounded-lg shadow-md border-l-4 border-amber-500 p-4 sm:p-6 mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Novo Aluguel</h2>
        <p class="text-gray-600 text-sm mt-2">Registre um novo empréstimo de livro para um usuário</p>
    </div>

    <!-- Error Alert -->
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-red-600 text-lg mt-0.5 flex-shrink-0"></i>
            <div>
                <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <form action="{{ route('rentals.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Selecionar Usuário -->
            <div>
                <label for="usuario_nome" class="block text-sm font-semibold text-gray-900 mb-2">
                    <i class="fas fa-user text-amber-600 mr-2"></i>Usuário <span class="text-red-600">*</span>
                </label>
                <div class="flex gap-2">
                    <input type="text" id="usuario_nome" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm"
                          placeholder="Clique para buscar um usuário" readonly>
                    <input type="hidden" name="id_usuario" id="id_usuario" required>
                    <button type="button" class="px-4 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-medium text-sm" id="buscarUsuarioBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                @error('id_usuario')
                    <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-info-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Selecionar Livro -->
            <div>
                <label for="livro_titulo" class="block text-sm font-semibold text-gray-900 mb-2">
                    <i class="fas fa-book text-amber-600 mr-2"></i>Livro <span class="text-red-600">*</span>
                </label>
                <div class="flex gap-2">
                    <input type="text" id="livro_titulo" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm"
                          placeholder="Clique para buscar um livro" readonly>
                    <input type="hidden" name="id_livro" id="id_livro" required>
                    <button type="button" class="px-4 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-medium text-sm" id="buscarLivroBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                @error('id_livro')
                    <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-info-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Datas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="dt_aluguel" class="block text-sm font-semibold text-gray-900 mb-2">
                        <i class="fas fa-calendar-check text-amber-600 mr-2"></i>Data Retirada <span class="text-red-600">*</span>
                    </label>
                    <input type="date" name="dt_aluguel" id="dt_aluguel" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm"
                           value="{{ date('Y-m-d') }}" required>
                    @error('dt_aluguel')
                        <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="dt_devolucao" class="block text-sm font-semibold text-gray-900 mb-2">
                        <i class="fas fa-calendar-times text-amber-600 mr-2"></i>Data Devolução <span class="text-red-600">*</span>
                    </label>
                    <input type="date" name="dt_devolucao" id="dt_devolucao" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm"
                           value="{{ date('Y-m-d', strtotime('+' . ($settings['default_loan_period'] ?? 14) . ' days')) }}" required>
                    @error('dt_devolucao')
                        <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Preview de informações -->
            <div class="hidden p-4 bg-amber-50 border border-amber-200 rounded-lg" id="preview-container">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-eye text-amber-600"></i>Resumo do Aluguel
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-600">Usuário:</p>
                        <p class="font-semibold text-gray-900" id="preview-usuario">-</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Livro:</p>
                        <p class="font-semibold text-gray-900" id="preview-livro">-</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Autor:</p>
                        <p class="font-semibold text-gray-900" id="preview-autor">-</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Período:</p>
                        <p class="font-semibold text-gray-900" id="preview-periodo">-</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="submit" class="flex-1 px-6 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-semibold shadow-md hover:shadow-lg">
                    <i class="fas fa-check mr-2"></i>Registrar Aluguel
                </button>
                <a href="{{ route('rentals.index') }}" class="flex-1 px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold text-center">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Modal Buscar Usuário -->
<div class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm" id="usuarioModal">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 max-h-[80vh] overflow-y-auto">
        <div class="border-b border-gray-200 sticky top-0 bg-white px-6 py-4 flex items-center justify-between">
            <h5 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-user text-amber-600"></i>Buscar Usuário
            </h5>
            <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl leading-none" id="fecharModalUsuario">&times;</button>
        </div>
        <div class="p-6">
            <div class="mb-4 flex gap-2">
                <input type="text" id="searchUsuario" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm" placeholder="Digite nome ou email do usuário">
                <button id="btnSearchUsuario" class="px-6 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-medium text-sm">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div id="usuariosSearchResults" class="space-y-2"></div>
        </div>
    </div>
</div>

<!-- Modal Buscar Livro -->
<div class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm" id="livroModal">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 max-h-[80vh] overflow-y-auto">
        <div class="border-b border-gray-200 sticky top-0 bg-white px-6 py-4 flex items-center justify-between">
            <h5 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-book text-amber-600"></i>Buscar Livro
            </h5>
            <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl leading-none" id="fecharModalLivro">&times;</button>
        </div>
        <div class="p-6">
            <div class="mb-4 flex gap-2">
                <input type="text" id="searchLivro" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm" placeholder="Digite título ou autor do livro">
                <button id="btnSearchLivro" class="px-6 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-medium text-sm">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div id="livrosSearchResults" class="space-y-2"></div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
@endsection