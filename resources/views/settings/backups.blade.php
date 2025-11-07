@extends('layouts.app')

@section('title', 'Gerenciamento de Backups - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Gerenciamento de Backups')

@section('breadcrumb')
<a href="{{ route('settings.index') }}" class="text-amber-600 hover:text-amber-700 transition-colors duration-200">Configurações</a>
<i class="fas fa-chevron-right text-gray-400 mx-2"></i>
<span class="text-gray-700">Backups</span>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2 flex items-center gap-3">
                <div class="bg-cyan-100 rounded-lg p-3">
                    <i class="fas fa-server text-cyan-600 text-xl"></i>
                </div>
                <span>Gerenciamento de Backups</span>
            </h2>
            <p class="text-gray-600">Gerencie os backups do seu sistema para proteção de dados</p>
        </div>
        <form action="{{ route('settings.backup.create') }}" method="POST" class="flex-shrink-0">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-plus-circle"></i>
                <span>Criar Novo Backup</span>
            </button>
        </form>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3 animate-pulse">
            <i class="fas fa-check-circle text-green-600 mt-0.5 flex-shrink-0"></i>
            <div>
                <h3 class="font-semibold text-green-800">Sucesso!</h3>
                <p class="text-green-700 text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Error Alert -->
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3 animate-pulse">
            <i class="fas fa-exclamation-circle text-red-600 mt-0.5 flex-shrink-0"></i>
            <div>
                <h3 class="font-semibold text-red-800">Erro!</h3>
                <p class="text-red-700 text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Info and Status Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Info Card -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-start gap-4">
                <div class="bg-blue-100 rounded-lg p-4 flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Sobre os Backups</h3>
                    <p class="text-gray-700 mb-2">Os backups incluem todos os dados do banco de dados e arquivos importantes do sistema. Recomendamos manter backups regulares para garantir a segurança dos seus dados.</p>
                    <p class="text-gray-600 text-sm">
                        <strong>💡 Dica:</strong> Faça o download dos backups e armazene-os em locais diferentes para maior segurança.
                    </p>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-teal-500">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-teal-600"></i>
                Status de Backup
            </h3>
            <div class="space-y-3">
                <!-- Auto Backup Status -->
                <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                    <span class="text-gray-700 font-medium">Automático:</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ isset($settings['enable_auto_backup']) && $settings['enable_auto_backup'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        <i class="fas fa-circle mr-2" style="font-size: 0.5rem;"></i>
                        {{ isset($settings['enable_auto_backup']) && $settings['enable_auto_backup'] ? 'Ativado' : 'Desativado' }}
                    </span>
                </div>

                <!-- Frequency -->
                <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                    <span class="text-gray-700 font-medium">Frequência:</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        @switch($settings['backup_frequency'] ?? 'weekly')
                            @case('daily')
                                <i class="fas fa-calendar-day mr-1"></i> Diário
                                @break
                            @case('weekly')
                                <i class="fas fa-calendar-week mr-1"></i> Semanal
                                @break
                            @case('monthly')
                                <i class="fas fa-calendar-alt mr-1"></i> Mensal
                                @break
                            @default
                                {{ $settings['backup_frequency'] ?? 'Semanal' }}
                        @endswitch
                    </span>
                </div>

                <!-- Retention -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-700 font-medium">Retenção:</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        <i class="fas fa-history mr-1"></i> {{ $settings['backup_retention'] ?? 5 }} backups
                    </span>
                </div>

                <!-- Settings Link -->
                <a href="{{ route('settings.index') }}" class="block w-full text-center px-4 py-2 bg-teal-100 hover:bg-teal-200 text-teal-800 font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-cog mr-2"></i> Alterar Configurações
                </a>
            </div>
        </div>
    </div>

    <!-- Backups List -->
    @if(count($backups) > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-history text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Backups Disponíveis</h3>
                    </div>
                </div>
                <span class="text-sm font-medium text-gray-600 bg-white px-4 py-2 rounded-full">
                    {{ count($backups) }} {{ count($backups) == 1 ? 'backup' : 'backups' }}
                </span>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                <i class="fas fa-file-archive text-amber-600 mr-2"></i>Nome do Arquivo
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                <i class="fas fa-weight text-amber-600 mr-2"></i>Tamanho
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                <i class="fas fa-calendar text-amber-600 mr-2"></i>Data de Criação
                            </th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">
                                <i class="fas fa-tools text-amber-600 mr-2"></i>Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($backups as $backup)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-amber-100 rounded-lg p-2 flex-shrink-0">
                                        <i class="fas fa-file-archive text-amber-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 truncate" title="{{ $backup['filename'] }}">{{ $backup['filename'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700 font-medium">{{ $backup['size'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700">{{ $backup['created_at'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('settings.backup.download', $backup['filename']) }}"
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium rounded-lg transition-all duration-200"
                                       title="Download">
                                        <i class="fas fa-download"></i>
                                        <span class="hidden sm:inline">Download</span>
                                    </a>
                                    <form action="{{ route('settings.backup.delete', $backup['filename']) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-2 bg-red-100 hover:bg-red-200 text-red-800 font-medium rounded-lg transition-all duration-200"
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                            <span class="hidden sm:inline">Excluir</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-database text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Nenhum Backup Encontrado</h3>
            <p class="text-gray-600 mb-6">Não há backups disponíveis no momento. Crie seu primeiro backup para proteger seus dados.</p>
            <form action="{{ route('settings.backup.create') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus-circle"></i>
                    <span>Criar Primeiro Backup</span>
                </button>
            </form>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete form confirmation
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Esta ação não pode ser desfeita! O backup será excluído permanentemente.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        confirmButton: 'px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg',
                        cancelButton: 'px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.animate-pulse');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.3s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    });
</script>
@endpush
@endsection