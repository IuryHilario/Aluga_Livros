@extends('layouts.app')

@section('title', 'Usuários - ' . $settings['system_name'] ?? 'Aluga Livros')

@section('page-title', 'Gerenciar Usuários')

@section('breadcrumb')
<a href="{{ route('users.index') }}">Usuários</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <x-ui.header
        title="Lista de Usuários"
        icon="fas fa-users"
        name="Novo Usuário"
        :route="route('users.create')"
    />

    <!-- Body -->
    <div class="p-4 sm:p-6 lg:p-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="filter-container mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200" style="{{ (request('search') || request('order_by') || request('order_dir')) ? 'display: block;' : 'display: none;' }}">
            <form action="{{ route('users.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Pesquisar</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none" placeholder="Nome, email ou telefone" autocomplete="off">
                    </div>
                    <div>
                        <label for="order_by" class="block text-sm font-semibold text-gray-700 mb-2">Ordenar por</label>
                        <select id="order_by" name="order_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none">
                            <option value="nome" {{ request('order_by') == 'nome' || !request('order_by') ? 'selected' : '' }}>Nome</option>
                            <option value="email" {{ request('order_by') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Data de cadastro</option>
                        </select>
                    </div>
                    <div>
                        <label for="order_dir" class="block text-sm font-semibold text-gray-700 mb-2">Direção</label>
                        <select id="order_dir" name="order_dir" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none">
                            <option value="asc" {{ request('order_dir') == 'asc' || !request('order_dir') ? 'selected' : '' }}>Crescente</option>
                            <option value="desc" {{ request('order_dir') == 'desc' ? 'selected' : '' }}>Decrescente</option>
                        </select>
                    </div>
                    <div class="flex flex-col justify-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200">
                            Filtrar
                        </button>
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200 text-center">Limpar</a>
                    </div>
                </div>
            </form>
        </div>

        @if(request('search'))
            <div class="mb-6 flex items-center gap-2">
                <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    <i class="fas fa-search"></i> Buscando: <strong>{{ request('search') }}</strong>
                </span>
            </div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b-2 border-gray-300">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nome</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 hidden sm:table-cell">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 hidden md:table-cell">Telefone</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 hidden lg:table-cell">Cadastrado em</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($usuarios as $usuario)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-amber-100 text-amber-700 font-semibold text-sm">
                                        {{ strtoupper(substr($usuario->nome, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $usuario->nome }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600 hidden sm:table-cell">{{ $usuario->email }}</td>
                            <td class="px-4 py-4 text-sm text-gray-600 hidden md:table-cell">{{ $usuario->telefone ?? 'Não informado' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-600 hidden lg:table-cell">{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'N/A' }}</td>
                            <td class="px-4 py-4 text-center">
                                <x-form.actions
                                    show="{{ route('users.show', $usuario->id_usuario) }}"
                                    edit="{{ route('users.edit', $usuario->id_usuario) }}"
                                    delete="{{ route('users.destroy', $usuario->id_usuario) }}"
                                />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="text-5xl text-gray-300 mb-4">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Nenhum usuário encontrado</h4>
                                    <p class="text-gray-600 mb-4">Não existem usuários cadastrados com os critérios especificados.</p>
                                    @if(request('search') || request('order_by') || request('order_dir'))
                                        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                                            <i class="fas fa-undo"></i> Limpar Filtros
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($usuarios->count() > 0)
            <div class="mt-6">
                {{ $usuarios->appends(request()->query())->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleFilter = document.getElementById('toggleFilter');
        const filterContainer = document.querySelector('.filter-container');

        // Verificar se há filtros aplicados
        const urlParams = new URLSearchParams(window.location.search);
        const hasFilters = urlParams.has('search') || urlParams.has('order_by') || urlParams.has('order_dir');

        // Mostrar filtros automaticamente se houver algum aplicado
        if (hasFilters) {
            filterContainer.style.display = 'block';
        }

        toggleFilter.addEventListener('click', function() {
            filterContainer.style.display = filterContainer.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>
@endpush
