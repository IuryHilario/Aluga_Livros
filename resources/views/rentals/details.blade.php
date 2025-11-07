@extends('layouts.app')

@section('title', 'Detalhes do Aluguel - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Detalhes do Aluguel')

@vite(['resources/css/rentals/rentals.css'])

@section('breadcrumb')
<a href="{{ route('rentals.index') }}">Aluguéis</a> / <span>Detalhes</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md border-l-4 border-amber-500 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Aluguel N° {{ $aluguel->id_aluguel }}</h2>
                <div class="mt-3 flex items-center gap-3">
                    <span class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold {{ $aluguel->ds_status == 'Ativo' ? 'bg-blue-100 text-blue-800' : ($aluguel->ds_status == 'Devolvido' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                        {{ $aluguel->ds_status }}
                        @if($aluguel->isAtrasado())
                            <span class="text-red-600 ml-2">({{ $aluguel->diasAtraso() }} dias atrasado)</span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                @if($aluguel->ds_status != 'Devolvido')
                    @if($aluguel->podeRenovar())
                        <a href="{{ route('rentals.renew', $aluguel->id_aluguel) }}" class="flex items-center justify-center px-4 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-medium text-sm action-btn renew">
                            <i class="fas fa-sync-alt mr-2"></i> Renovar
                        </a>
                    @endif
                    <a href="{{ route('rentals.return', $aluguel->id_aluguel) }}" class="flex items-center justify-center px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium text-sm action-btn return">
                        <i class="fas fa-undo mr-2"></i> Devolver
                    </a>
                @endif
                <a href="{{ route('rentals.index') }}" class="flex items-center justify-center px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium text-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
            <i class="fas fa-check-circle text-green-600 text-lg mt-0.5"></i>
            <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-red-600 text-lg mt-0.5"></i>
            <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Info Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Livro Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-amber-500">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-amber-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-book text-amber-600"></i> Livro
                </h3>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    @if($aluguel->livro->capa)
                        <img src="{{ route('books.capa', $aluguel->id_livro) }}" alt="{{ $aluguel->livro->titulo }}" class="w-full h-48 object-cover rounded-lg">
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-5xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $aluguel->livro->titulo }}</h4>
                <p class="text-gray-600 text-sm mb-4">por {{ $aluguel->livro->autor }}</p>
                <div class="space-y-2 text-sm mb-4 pb-4 border-b border-gray-200">
                    @if($aluguel->livro->isbn)
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-barcode text-amber-600"></i> <span>ISBN: {{ $aluguel->livro->isbn }}</span>
                        </div>
                    @endif
                    @if($aluguel->livro->categoria)
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-tag text-amber-600"></i> <span>{{ $aluguel->livro->categoria }}</span>
                        </div>
                    @endif
                </div>
                <a href="{{ route('books.show', $aluguel->id_livro) }}" class="inline-flex items-center text-amber-600 hover:text-amber-700 font-medium text-sm transition-colors">
                    Ver detalhes <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Usuário Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-blue-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-user text-blue-600"></i> Usuário
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-circle text-2xl text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">{{ $aluguel->usuario->nome }}</h4>
                    </div>
                </div>
                <div class="space-y-2 text-sm pb-4 border-b border-gray-200">
                    <div class="flex items-center gap-2 text-gray-600">
                        <i class="fas fa-envelope text-blue-600"></i> <span>{{ $aluguel->usuario->email }}</span>
                    </div>
                    @if($aluguel->usuario->telefone)
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-phone text-blue-600"></i> <span>{{ $aluguel->usuario->telefone }}</span>
                        </div>
                    @endif
                </div>
                <a href="{{ route('users.show', $aluguel->id_usuario) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors mt-4">
                    Ver perfil <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Timeline and Renewals Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Timeline Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-green-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-green-600"></i> Linha do Tempo
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Timeline Item 1: Retirada -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <div class="h-12 w-0.5 bg-gray-200"></div>
                        </div>
                        <div class="pb-6">
                            <p class="text-xs font-semibold text-gray-500 uppercase">{{ date('d/m/Y', strtotime($aluguel->dt_aluguel)) }}</p>
                            <h4 class="font-semibold text-gray-900">Retirada</h4>
                            <p class="text-sm text-gray-600">Livro retirado pelo usuário</p>
                        </div>
                    </div>

                    <!-- Timeline Item 2: Devolução Prevista -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 {{ $aluguel->isAtrasado() ? 'bg-red-100 text-red-600' : ($aluguel->ds_status == 'Devolvido' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600') }} rounded-full flex items-center justify-center">
                                <i class="fas {{ $aluguel->isAtrasado() ? 'fa-times' : ($aluguel->ds_status == 'Devolvido' ? 'fa-check' : 'fa-clock') }} text-sm"></i>
                            </div>
                            @if($aluguel->dt_devolucao_efetiva)
                                <div class="h-12 w-0.5 bg-gray-200"></div>
                            @endif
                        </div>
                        <div class="pb-6">
                            <p class="text-xs font-semibold text-gray-500 uppercase">{{ date('d/m/Y', strtotime($aluguel->dt_devolucao)) }}</p>
                            <h4 class="font-semibold text-gray-900">Devolução Prevista</h4>
                            <p class="text-sm text-gray-600">
                                @if($aluguel->isAtrasado())
                                    <span class="text-red-600 font-medium">Data de devolução excedida</span>
                                @elseif($aluguel->ds_status == 'Devolvido')
                                    <span class="text-green-600 font-medium">Data prevista inicialmente</span>
                                @else
                                    Data limite para devolução
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Timeline Item 3: Devolução Efetiva -->
                    @if($aluguel->dt_devolucao_efetiva)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase">{{ date('d/m/Y', strtotime($aluguel->dt_devolucao_efetiva)) }}</p>
                            <h4 class="font-semibold text-gray-900">Devolução Efetiva</h4>
                            <p class="text-sm text-gray-600">Livro devolvido à biblioteca</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Renewals Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-purple-500">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-purple-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-sync-alt text-purple-600"></i> Renovações
                </h3>
            </div>
            <div class="p-6">
                @php
                    $maxRenovacoesPermitidas = intval($settings['max_renewals'] ?? 2);
                    $porcentagem = ($aluguel->nu_renovacoes / $maxRenovacoesPermitidas) * 100;
                @endphp

                <!-- Counter -->
                <div class="mb-6 p-4 bg-purple-50 rounded-lg border border-purple-100">
                    <div class="flex items-center justify-center gap-2">
                        <span class="text-3xl font-bold text-purple-600">{{ $aluguel->nu_renovacoes }}</span>
                        <span class="text-2xl text-gray-400">/</span>
                        <span class="text-3xl font-bold text-gray-400">{{ $maxRenovacoesPermitidas }}</span>
                    </div>
                    <p class="text-center text-sm text-gray-600 mt-2">Renovações realizadas</p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-6">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full transition-all duration-300" style="width: {{ min($porcentagem, 100) }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-2">
                        <span>0</span>
                        <span>{{ $maxRenovacoesPermitidas }}</span>
                    </div>
                </div>

                <!-- Status -->
                @if($aluguel->ds_status != 'Devolvido')
                <div class="mb-6 p-4 rounded-lg {{ $aluguel->podeRenovar() ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas {{ $aluguel->podeRenovar() ? 'fa-check-circle text-green-600 text-lg' : 'fa-times-circle text-red-600 text-lg' }}"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold {{ $aluguel->podeRenovar() ? 'text-green-900' : 'text-red-900' }}">
                                {{ $aluguel->podeRenovar() ? 'Disponível para renovação' : 'Não disponível para renovação' }}
                            </h4>
                            <p class="text-sm {{ $aluguel->podeRenovar() ? 'text-green-700' : 'text-red-700' }} mt-1">
                                @if($aluguel->podeRenovar())
                                    Este empréstimo pode ser renovado por mais dias.
                                @else
                                    @if($aluguel->nu_renovacoes >= $maxRenovacoesPermitidas)
                                        Limite máximo de renovações atingido.
                                    @elseif($aluguel->isAtrasado())
                                        O empréstimo está atrasado.
                                    @else
                                        Não é possível renovar no momento.
                                    @endif
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- History -->
                @if($aluguel->nu_renovacoes > 0)
                <div class="pt-4 border-t border-gray-200">
                    <h4 class="font-semibold text-gray-900 mb-3">Histórico de Renovações</h4>
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-history text-purple-600 text-lg"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Última renovação</p>
                            <p class="text-sm text-gray-600">{{ $aluguel->ultima_renovacao ? date('d/m/Y', strtotime($aluguel->ultima_renovacao)) : 'Data não registrada' }}</p>
                        </div>
                    </div>
                </div>
                @else
                <div class="pt-4 border-t border-gray-200 text-center">
                    <i class="fas fa-info-circle text-gray-400 text-2xl mb-2 block"></i>
                    <p class="text-sm text-gray-600">Este aluguel ainda não foi renovado</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.return-button').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const href = btn.getAttribute('href');
            Swal.fire({
                title: 'Confirmar Devolução',
                text: 'Tem certeza que deseja registrar a devolução deste livro?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    });

    document.querySelectorAll('.renew-button, .action-btn.renew').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const href = btn.getAttribute('href');
            Swal.fire({
                title: 'Confirmar Renovação',
                text: 'Tem certeza que deseja renovar este empréstimo?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
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
