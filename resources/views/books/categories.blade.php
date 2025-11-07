@extends('layouts.app')

@section('title', 'Editoras - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Editoras')

@section('breadcrumb')
    <a href="{{ route('books.index') }}" class="hover:text-amber-600 transition-colors duration-200">Livros</a> / <span>Editoras</span>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
    <!-- Header -->
    <div class="border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-4 sm:py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900">Gerenciar por Editoras</h3>
            <p class="text-sm text-gray-600 mt-1">{{ count($editores) }} editora(s) cadastrada(s)</p>
        </div>
        <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i> Adicionar Livro
        </a>
    </div>

    <!-- Body -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        @if($editores->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="text-6xl text-gray-300 mb-4">
                    <i class="fas fa-building"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Nenhuma editora encontrada</h4>
                <p class="text-gray-600 mb-6">Adicione editoras aos livros para começar a categorizá-los.</p>
                <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Adicionar Livro
                </a>
            </div>
        @else
            <!-- Categories Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($editores as $editor)
                    @php
                        $booksCount = \App\Models\Livro::where('editor', $editor)->count();
                    @endphp
                    <div class="rounded-lg border border-gray-200 bg-white hover:shadow-md hover:border-amber-200 transition-all duration-200 overflow-hidden group">
                        <!-- Header -->
                        <div class="p-4 sm:p-6 bg-gradient-to-br from-amber-50 to-white border-b border-gray-200">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 p-2.5 rounded-lg bg-amber-100">
                                    <i class="fas fa-building text-xl text-amber-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 truncate group-hover:text-amber-600 transition-colors duration-200">
                                        {{ $editor }}
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <span class="inline-flex items-center gap-1">
                                            <i class="fas fa-book text-amber-500"></i>
                                            {{ $booksCount }} {{ $booksCount == 1 ? 'livro' : 'livros' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="p-4 sm:p-6 bg-gray-50">
                            <a href="{{ route('books.index') }}?editor={{ urlencode($editor) }}"
                               class="w-full inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 transition-colors duration-200">
                                <i class="fas fa-eye mr-2"></i> Ver Livros
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(count($editores) > (isset($settings['items_per_page']) ? $settings['items_per_page'] : 10) && method_exists($editores, 'links'))
                <div class="mt-8">
                    {{ $editores->links('components.pagination') }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection