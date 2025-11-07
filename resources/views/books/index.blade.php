@extends('layouts.app')

@section('title', 'Livros - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Gerenciar Livros')

@section('breadcrumb')
    <a href="{{ route('books.index') }}" class="hover:text-amber-600 transition-colors duration-200">Livros</a>
@endsection

@section('content')
<!-- Main Card -->
<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
    <!-- Header -->
    <div class="border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-4 sm:py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900">Livros Disponíveis</h3>
            <p class="text-sm text-gray-600 mt-1">{{ count($livros) }} livro(s) no total</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
            <button id="toggleFilter" class="inline-flex items-center justify-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-filter mr-2"></i> Filtrar
            </button>
            <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i> Adicionar Livro
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div id="filter-container" class="border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-4 sm:py-6 hidden">
        <form action="{{ route('books.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Título do livro" value="{{ request('titulo') }}" autocomplete="off"
                           class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition-all duration-200">
                </div>
                <div>
                    <label for="autor" class="block text-sm font-medium text-gray-700 mb-2">Autor</label>
                    <input type="text" id="autor" name="autor" placeholder="Nome do autor" value="{{ request('autor') }}" autocomplete="off"
                           class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition-all duration-200">
                </div>
                <div>
                    <label for="editor" class="block text-sm font-medium text-gray-700 mb-2">Editora</label>
                    <input type="text" id="editor" name="editor" placeholder="Nome da editora" value="{{ request('editor') }}" autocomplete="off"
                           class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition-all duration-200">
                </div>
                <div>
                    <label for="ano_publicacao" class="block text-sm font-medium text-gray-700 mb-2">Ano de Publicação</label>
                    <input type="number" id="ano_publicacao" name="ano_publicacao" placeholder="Ano" value="{{ request('ano_publicacao') }}" autocomplete="off"
                           class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition-all duration-200">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i> Filtrar
                </button>
                <a href="{{ route('books.index') }}" class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-undo mr-2"></i> Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Body -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-4 py-3">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(count($livros) > 0)
            <!-- Books Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                @foreach($livros as $livro)
                    <div class="group rounded-lg border border-gray-200 bg-white shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col">
                        <!-- Cover -->
                        <div class="relative h-48 sm:h-56 bg-gray-100 overflow-hidden">
                            @if($livro->capa && $settings['show_book_covers'] ?? false)
                                <img src="{{ route('books.capa', $livro->id_livro) }}" alt="Capa do livro {{ $livro->titulo }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <i class="fas fa-book text-6xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="flex-1 flex flex-col p-4">
                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base line-clamp-2 group-hover:text-amber-600 transition-colors duration-200">
                                {{ $livro->titulo }}
                            </h4>
                            <p class="text-xs sm:text-sm text-gray-600 mt-1">{{ $livro->autor }}</p>
                            @if($livro->editor)
                                <p class="text-xs text-gray-500 mt-0.5">{{ $livro->editor }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-0.5">{{ $livro->ano_publicacao }}</p>

                            <!-- Availability -->
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                @if($livro->quantidade_disponivel > 0)
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                                        <i class="fas fa-check-circle"></i> {{ $livro->quantidade_disponivel }} disponível(eis)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-red-700 bg-red-50 px-2.5 py-1 rounded-full">
                                        <i class="fas fa-times-circle"></i> Indisponível
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 flex gap-2">
                            <a href="{{ route('books.show', $livro->id_livro) }}"
                               class="flex-1 inline-flex items-center justify-center rounded-lg px-3 py-2 text-sm font-medium text-amber-600 hover:bg-amber-50 transition-colors duration-200"
                               title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('books.edit', $livro->id_livro) }}"
                               class="flex-1 inline-flex items-center justify-center rounded-lg px-3 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 transition-colors duration-200"
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('books.destroy', $livro->id_livro) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete w-full inline-flex items-center justify-center rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors duration-200"
                                        title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($livros, 'links'))
                <div class="mt-8">
                    {{ $livros->appends(request()->query())->links('components.pagination') }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="text-6xl text-gray-300 mb-4">
                    <i class="fas fa-book"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Nenhum livro encontrado</h4>
                <p class="text-gray-600 mb-6">Não foram encontrados livros com os critérios especificados.</p>
                <a href="{{ route('books.index') }}" class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 transition-colors duration-200">
                    <i class="fas fa-undo mr-2"></i> Limpar Filtros
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter Toggle
            const toggleFilter = document.getElementById('toggleFilter');
            const filterContainer = document.getElementById('filter-container');

            if (toggleFilter && filterContainer) {
                toggleFilter.addEventListener('click', function() {
                    filterContainer.classList.toggle('hidden');
                });

                // Show filter if has active filters
                @if(request()->hasAny(['titulo', 'autor', 'editor', 'ano_publicacao']))
                    filterContainer.classList.remove('hidden');
                @endif
            }

            // Delete confirmation
            document.querySelectorAll('.btn-delete').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = btn.closest('form');
                    Swal.fire({
                        title: 'Excluir Livro',
                        text: 'Tem certeza que deseja excluir este livro? Esta ação não pode ser desfeita.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sim, excluir',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
@endsection
