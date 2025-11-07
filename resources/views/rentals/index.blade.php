@extends('layouts.app')

@section('title', 'Aluguéis - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Aluguéis Ativos')

@vite(['resources/css/rentals/rentals.css'])

@section('breadcrumb')
<a href="{{ route('rentals.index') }}">Aluguéis</a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <x-ui.header
        title="Lista de Aluguéis"
        icon=""
        name="Novo Aluguel"
        :route="route('rentals.create')"
    />

    <!-- Filters Section -->
    <div class="filter-container bg-white rounded-lg shadow-md p-4 sm:p-6 hidden" id="filters-section">
        <form action="{{ route('rentals.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700 mb-2">Usuário</label>
                    <input type="text" id="user" name="user" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm" placeholder="Nome do usuário" value="{{ request('user') }}" autocomplete="off">
                </div>
                <div>
                    <label for="book" class="block text-sm font-medium text-gray-700 mb-2">Livro</label>
                    <input type="text" id="book" name="book" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm" placeholder="Título do livro" value="{{ request('book') }}" autocomplete="off">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm">
                        <option value="">Todos</option>
                        <option value="Ativo" {{ request('status') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="Atrasado" {{ request('status') == 'Atrasado' ? 'selected' : '' }}>Atrasado</option>
                    </select>
                </div>
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Data Inicial</label>
                    <input type="date" id="start_date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm" value="{{ request('start_date') }}">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Data Final</label>
                    <input type="date" id="end_date" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm" value="{{ request('end_date') }}">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 pt-2">
                <button type="submit" class="flex items-center justify-center px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200 text-sm font-medium">
                    <i class="fas fa-search mr-2"></i> Filtrar
                </button>
                <a href="{{ route('rentals.index') }}" class="flex items-center justify-center px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200 text-sm font-medium">
                    <i class="fas fa-redo mr-2"></i> Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
            <i class="fas fa-check-circle text-green-600 text-lg mt-0.5"></i>
            <div>
                <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-red-600 text-lg mt-0.5"></i>
            <div>
                <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Content Section -->
    @if(count($alugueis) > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Mobile Cards View -->
            <div class="block lg:hidden space-y-4 p-4 sm:p-6">
                @foreach($alugueis as $aluguel)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow {{ $aluguel->isAtrasado() ? 'border-l-4 border-l-red-500' : 'border-l-4 border-l-green-500' }}">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm">
                                    <a href="{{ route('books.show', $aluguel->id_livro) }}" class="text-amber-600 hover:text-amber-700">
                                        {{ $aluguel->livro->titulo }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-xs mt-1">
                                    <a href="{{ route('users.show', $aluguel->id_usuario) }}" class="hover:text-amber-600">
                                        {{ $aluguel->usuario->nome }}
                                    </a>
                                </p>
                            </div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $aluguel->ds_status == 'Ativo' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                {{ $aluguel->ds_status }}
                                @if($aluguel->isAtrasado())
                                    <span class="text-red-600">({{ $aluguel->diasAtraso() }}d)</span>
                                @endif
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs mb-4 pb-4 border-b border-gray-200">
                            <div>
                                <p class="text-gray-600">Retirada</p>
                                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($aluguel->dt_aluguel)->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Devolução</p>
                                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($aluguel->dt_devolucao)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <x-form.actions
                                :show="route('rentals.show', $aluguel->id_aluguel)"
                                :devolver="route('rentals.return', $aluguel->id_aluguel)"
                                :email="$aluguel->ds_status == 'Atrasado' ? route('rentals.notification', $aluguel->id_aluguel) : null"
                            />
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
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($alugueis as $aluguel)
                            <tr class="hover:bg-gray-50 transition-colors {{ $aluguel->isAtrasado() ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4">
                                    <a href="{{ route('users.show', $aluguel->id_usuario) }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                                        {{ $aluguel->usuario->nome }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('books.show', $aluguel->id_livro) }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">
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
                                    <div class="flex items-center gap-2">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $aluguel->ds_status == 'Ativo' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $aluguel->ds_status }}
                                        </span>
                                        @if($aluguel->isAtrasado())
                                            <span class="text-xs text-red-600 font-medium">({{ $aluguel->diasAtraso() }}d)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        <x-form.actions
                                            :show="route('rentals.show', $aluguel->id_aluguel)"
                                            :devolver="route('rentals.return', $aluguel->id_aluguel)"
                                            :email="$aluguel->ds_status == 'Atrasado' ? route('rentals.notification', $aluguel->id_aluguel) : null"
                                        />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($alugueis, 'links'))
                <div class="border-t border-gray-200 px-4 sm:px-6 py-4">
                    {{ $alugueis->appends(request()->query())->links('components.pagination') }}
                </div>
            @endif
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-inbox text-3xl text-gray-400"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Nenhum aluguel ativo</h3>
            <p class="text-gray-600 mb-6">Não existem aluguéis ativos no momento.</p>
            <a href="{{ route('rentals.create') }}" class="inline-flex items-center px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200 font-medium">
                <i class="fas fa-plus mr-2"></i> Registrar Aluguel
            </a>
        </div>
    @endif
</div>
@endsection

<!-- Modal de confirmação para reenvio de e-mail de atraso -->
<div class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm" id="emailModal">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="border-b border-red-200 bg-red-50 px-6 py-4 flex items-center gap-3">
            <i class="fas fa-envelope text-2xl text-red-600"></i>
            <h5 class="text-lg font-semibold text-red-900">Reenviar E-mail de Atraso</h5>
        </div>
        <div class="p-6">
            <div class="mb-6 text-center">
                <p class="text-gray-700">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                    Deseja reenviar o e-mail de atraso para <span id="modalUserName" class="font-semibold text-gray-900"></span>?
                </p>
            </div>
            <div class="flex gap-3">
                <button class="flex-1 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200 font-medium text-sm" id="confirmEmailSend">
                    <i class="fas fa-paper-plane mr-2"></i> Enviar
                </button>
                <button class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200 font-medium text-sm" id="cancelEmailSend">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('styles')
<style>
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleFilter = document.getElementById('toggleFilter');
        const filterContainer = document.querySelector('.filter-container');

        // Verificar se há filtros aplicados
        const urlParams = new URLSearchParams(window.location.search);
        const hasFilters = urlParams.has('user') || urlParams.has('book') ||
                          urlParams.has('status') || urlParams.has('start_date') ||
                          urlParams.has('end_date');

        if (hasFilters) {
            filterContainer.classList.remove('hidden');
        }

        toggleFilter.addEventListener('click', function() {
            filterContainer.classList.toggle('hidden');
        });

        // Modal de confirmação de e-mail de atraso
        let selectedRentalId = null;
        const emailModal = document.getElementById('emailModal');
        const cancelEmailSend = document.getElementById('cancelEmailSend');
        const confirmEmailSend = document.getElementById('confirmEmailSend');

        document.querySelectorAll('.action-btn.email').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                selectedRentalId = btn.getAttribute('data-rental-id');
                const userName = btn.closest('tr') ?
                    btn.closest('tr').querySelector('td:nth-child(1)').textContent.trim() :
                    btn.closest('div').parentElement.querySelector('a').textContent.trim();
                document.getElementById('modalUserName').textContent = userName;
                emailModal.classList.remove('hidden');
            });
        });

        function closeModal() {
            emailModal.classList.add('hidden');
            selectedRentalId = null;
        }

        cancelEmailSend.addEventListener('click', closeModal);

        emailModal.addEventListener('click', function(event) {
            if (event.target === emailModal) closeModal();
        });

        confirmEmailSend.addEventListener('click', function() {
            if (selectedRentalId) {
                window.location.href = "{{ url('rentals/notification') }}/" + selectedRentalId;
            }
        });

        document.querySelectorAll('.action-btn.return').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const href = btn.getAttribute('href');
                Swal.fire({
                    title: 'Confirmar Devolução',
                    text: 'Tem certeza que deseja marcar este livro como devolvido?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#b45309'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    });
</script>
@endpush
