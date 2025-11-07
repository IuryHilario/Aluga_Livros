@extends('layouts.app')

@section('title', $livro->titulo . ' - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Detalhes do Livro')

@section('breadcrumb')
    <a href="{{ route('books.index') }}" class="hover:text-amber-600 transition-colors duration-200">Livros</a> / <span>Detalhes</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Book Cover and Status -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden sticky top-24">
            <!-- Cover -->
            <div class="aspect-[3/4] bg-gray-100 flex items-center justify-center">
                @if($livro->capa)
                    <img src="{{ route('books.capa', $livro->id_livro) }}" alt="Capa do livro {{ $livro->titulo }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="text-gray-300">
                        <i class="fas fa-book text-9xl"></i>
                    </div>
                @endif
            </div>

            <!-- Status Section -->
            <div class="p-4 sm:p-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">Total de exemplares:</span>
                        <span class="font-semibold text-gray-900">{{ $livro->quantidade }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">Disponíveis:</span>
                        <span class="font-semibold text-gray-900">{{ $livro->quantidade_disponivel }}</span>
                    </div>
                    <div class="p-3 rounded-lg {{ $livro->quantidade_disponivel > 0 ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        @if($livro->quantidade_disponivel > 0)
                            <div class="flex items-center gap-2 text-green-700">
                                <i class="fas fa-check-circle"></i>
                                <span class="text-sm font-medium">Disponível para empréstimo</span>
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-red-700">
                                <i class="fas fa-times-circle"></i>
                                <span class="text-sm font-medium">Indisponível no momento</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if($livro->quantidade_disponivel > 0)
                    <div class="mt-4">
                        <a href="{{ route('rentals.create', ['book_id' => $livro->id_livro]) }}"
                           class="w-full inline-flex items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 transition-colors duration-200">
                            <i class="fas fa-book-reader mr-2"></i> Realizar Empréstimo
                        </a>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="border-t border-gray-200 p-4 sm:p-6 flex flex-col gap-2">
                <a href="{{ route('books.edit', $livro->id_livro) }}"
                   class="inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
                <button type="button" class="btn-delete inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 transition-colors duration-200"
                        data-delete-url="{{ route('books.destroy', $livro->id_livro) }}">
                    <i class="fas fa-trash mr-2"></i> Excluir
                </button>
            </div>
        </div>
    </div>

    <!-- Right Column: Book Details and History -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Book Information -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 px-4 sm:px-6 py-4 sm:py-5">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900">{{ $livro->titulo }}</h3>
            </div>
            <div class="px-4 sm:px-6 py-4 sm:py-5 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">
                            <i class="fas fa-user-edit text-amber-600 mr-2"></i>Autor
                        </p>
                        <p class="text-base font-medium text-gray-900">{{ $livro->autor }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">
                            <i class="fas fa-calendar-alt text-amber-600 mr-2"></i>Ano de Publicação
                        </p>
                        <p class="text-base font-medium text-gray-900">{{ $livro->ano_publicacao }}</p>
                    </div>
                </div>
                @if($livro->editor)
                    <div>
                        <p class="text-sm text-gray-600 mb-1">
                            <i class="fas fa-building text-amber-600 mr-2"></i>Editora
                        </p>
                        <p class="text-base font-medium text-gray-900">{{ $livro->editor }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Rental History -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 px-4 sm:px-6 py-4 sm:py-5 flex items-center gap-2">
                <i class="fas fa-history text-amber-600"></i>
                <h3 class="text-lg font-semibold text-gray-900">Histórico de Empréstimos</h3>
            </div>
            <div class="px-4 sm:px-6 py-5">
                @if(!isset($livro->alugueis) || $livro->alugueis->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="text-5xl text-gray-300 mb-3">
                            <i class="fas fa-book"></i>
                        </div>
                        <p class="text-gray-600">Este livro ainda não foi emprestado.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($livro->alugueis as $aluguel)
                            <div class="flex gap-4 p-4 rounded-lg border border-gray-200 hover:border-amber-200 hover:bg-amber-50/30 transition-all duration-200">
                                <!-- Status Indicator -->
                                <div class="flex-shrink-0 pt-1">
                                    @if($aluguel->ds_status === 'Ativo')
                                        <div class="flex h-3 w-3 rounded-full bg-blue-500" title="Empréstimo Ativo"></div>
                                    @elseif($aluguel->ds_status === 'Atrasado')
                                        <div class="flex h-3 w-3 rounded-full bg-red-500" title="Empréstimo Atrasado"></div>
                                    @else
                                        <div class="flex h-3 w-3 rounded-full bg-green-500" title="Empréstimo Concluído"></div>
                                    @endif
                                </div>

                                <!-- Details -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                                        <h4 class="font-semibold text-gray-900 truncate">
                                            {{ $aluguel->usuario->nome ?? 'Usuário não encontrado' }}
                                        </h4>
                                        <span class="text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap
                                            @if($aluguel->ds_status === 'Ativo')
                                                bg-blue-100 text-blue-800
                                            @elseif($aluguel->ds_status === 'Atrasado')
                                                bg-red-100 text-red-800
                                            @else
                                                bg-green-100 text-green-800
                                            @endif">
                                            {{ $aluguel->ds_status }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm text-gray-600">
                                        <div>
                                            <span class="text-xs text-gray-500">Data do Empréstimo</span>
                                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($aluguel->dt_aluguel)->format('d/m/Y') }}</p>
                                        </div>
                                        <div>
                                            <span class="text-xs text-gray-500">Devolução Prevista</span>
                                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($aluguel->dt_devolucao)->format('d/m/Y') }}</p>
                                        </div>
                                        @if($aluguel->ds_status === 'Concluído' && $aluguel->data_devolucao_real)
                                            <div>
                                                <span class="text-xs text-gray-500">Data da Devolução</span>
                                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($aluguel->data_devolucao_real)->format('d/m/Y') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- View Link -->
                                <div class="flex-shrink-0 pt-1">
                                    <a href="{{ route('rentals.show', $aluguel->id_aluguel) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-colors duration-200"
                                       title="Ver detalhes">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtn = document.querySelector('.btn-delete');

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const deleteUrl = this.getAttribute('data-delete-url');

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
                            const form = document.getElementById('delete-form');
                            form.action = deleteUrl;
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>
@endpush
@endsection
