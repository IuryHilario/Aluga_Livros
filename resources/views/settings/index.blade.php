@extends('layouts.app')

@section('title', 'Configurações - '  . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Configurações')

@section('breadcrumb')
<span>Configurações</span>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">
            <i class="fas fa-cog text-amber-600 mr-3"></i>Configurações do Sistema
        </h2>
        <p class="text-gray-600">Gerencie as configurações e preferências do seu sistema de biblioteca</p>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3 animate-pulse">
            <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
            <div>
                <h3 class="font-semibold text-green-800">Sucesso!</h3>
                <p class="text-green-700 text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="mb-6 border-b border-gray-200 flex flex-wrap gap-2 bg-white rounded-t-lg p-4 sm:p-6">
        <button class="tab-button active px-4 sm:px-6 py-3 font-medium text-gray-700 border-b-2 border-amber-600 text-amber-600 transition-all duration-200 hover:text-amber-700" data-tab="general">
            <i class="fas fa-sliders-h mr-2"></i><span class="hidden sm:inline">Geral</span>
        </button>
        <button class="tab-button px-4 sm:px-6 py-3 font-medium text-gray-600 border-b-2 border-transparent hover:text-gray-700 transition-all duration-200" data-tab="loans">
            <i class="fas fa-handshake mr-2"></i><span class="hidden sm:inline">Empréstimos</span>
        </button>
        <button class="tab-button px-4 sm:px-6 py-3 font-medium text-gray-600 border-b-2 border-transparent hover:text-gray-700 transition-all duration-200" data-tab="notifications">
            <i class="fas fa-bell mr-2"></i><span class="hidden sm:inline">Notificações</span>
        </button>
        <button class="tab-button px-4 sm:px-6 py-3 font-medium text-gray-600 border-b-2 border-transparent hover:text-gray-700 transition-all duration-200" data-tab="backup">
            <i class="fas fa-database mr-2"></i><span class="hidden sm:inline">Backup</span>
        </button>
    </div>

    <!-- Form Content -->
    <form action="{{ route('settings.update') }}" method="POST" class="space-y-0">
        @csrf

        <!-- GENERAL SETTINGS TAB -->
        <div class="tab-content active bg-white rounded-b-lg p-6 sm:p-8 shadow-md" id="general-content">
            <!-- Informações da Biblioteca -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                    <div class="bg-amber-100 rounded-lg p-3">
                        <i class="fas fa-building text-amber-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Informações da Biblioteca</h3>
                        <p class="text-sm text-gray-600">Detalhes principais do seu sistema</p>
                    </div>
                </div>

                <x-form.input
                    label="Nome da Biblioteca"
                    placeholder="Digite o nome da biblioteca"
                    type="text"
                    name="settings[system_name]"
                    id="system_name"
                    value="{{ $settings['system_name'] ?? 'Aluga Livros' }}"
                    required
                />
            </div>

            <!-- Interface de Usuário -->
            <div>
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                    <div class="bg-blue-100 rounded-lg p-3">
                        <i class="fas fa-palette text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Interface de Usuário</h3>
                        <p class="text-sm text-gray-600">Personalize a experiência visual</p>
                    </div>
                </div>

                <!-- Checkbox: Show Book Covers -->
                <div class="mb-6 flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-gray-300 transition-colors duration-200">
                    <input type="hidden" name="settings[show_book_covers]" value="0">
                    <input type="checkbox" id="show_book_covers" name="settings[show_book_covers]" value="1"
                           class="w-5 h-5 text-amber-600 rounded focus:ring-2 focus:ring-amber-500 cursor-pointer"
                           {{ isset($settings['show_book_covers']) && $settings['show_book_covers'] ? 'checked' : '' }}>
                    <label for="show_book_covers" class="ml-3 flex flex-col cursor-pointer">
                        <span class="font-medium text-gray-900">Mostrar capas dos livros nas listagens</span>
                        <span class="text-sm text-gray-600">Exibe as capas dos livros em visualizações de lista</span>
                    </label>
                </div>

                <!-- Select: Items Per Page -->
                <div>
                    <label for="items_per_page" class="block text-sm font-semibold text-gray-700 mb-2">
                        Itens por página <span class="text-red-500">*</span>
                    </label>
                    <select id="items_per_page" name="settings[items_per_page]" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all duration-200" required>
                        <option value="10" {{ ($settings['items_per_page'] ?? 10) == 10 ? 'selected' : '' }}>10 itens</option>
                        <option value="25" {{ ($settings['items_per_page'] ?? 10) == 25 ? 'selected' : '' }}>25 itens</option>
                        <option value="50" {{ ($settings['items_per_page'] ?? 10) == 50 ? 'selected' : '' }}>50 itens</option>
                        <option value="100" {{ ($settings['items_per_page'] ?? 10) == 100 ? 'selected' : '' }}>100 itens</option>
                    </select>
                    <p class="mt-2 text-sm text-gray-600">Quantos itens deseja visualizar por página</p>
                </div>
            </div>
        </div>

        <!-- LOANS SETTINGS TAB -->
        <div class="tab-content bg-white rounded-b-lg p-6 sm:p-8 shadow-md" id="loans-content" style="display: none;">
            <!-- Regras de Empréstimo -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                    <div class="bg-purple-100 rounded-lg p-3">
                        <i class="fas fa-handshake text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Regras de Empréstimo</h3>
                        <p class="text-sm text-gray-600">Configure os parâmetros de empréstimos</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form.input
                        label="Período de Empréstimo (dias)"
                        placeholder="Digite o período de empréstimo"
                        type="number"
                        name="settings[loan_period]"
                        id="loan_period"
                        value="{{ $settings['loan_period'] ?? 14 }}"
                        min="1"
                        max="60"
                        required
                    />

                    <x-form.input
                        label="Máximo Livros por Usuário"
                        placeholder="Digite o máximo de livros por usuário"
                        type="number"
                        name="settings[max_loans_per_user]"
                        id="max_loans_per_user"
                        value="{{ $settings['max_loans_per_user'] ?? 3 }}"
                        min="1"
                        max="10"
                        required
                    />
                </div>
            </div>

            <!-- Renovações -->
            <div>
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                    <div class="bg-green-100 rounded-lg p-3">
                        <i class="fas fa-redo text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Renovações</h3>
                        <p class="text-sm text-gray-600">Defina as políticas de renovação</p>
                    </div>
                </div>

                <x-form.input
                    label="Número Máximo de Renovações Permitidas"
                    placeholder="Digite o número máximo de renovações permitidas"
                    type="number"
                    name="settings[max_renewals]"
                    id="max_renewals"
                    value="{{ $settings['max_renewals'] ?? 2 }}"
                    min="0"
                    max="5"
                    required
                />

                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-gray-300 transition-colors duration-200">
                    <input type="hidden" name="settings[allow_renewal_with_pending]" value="0">
                    <input type="checkbox" id="allow_renewal_with_pending" name="settings[allow_renewal_with_pending]" value="1"
                           class="w-5 h-5 text-amber-600 rounded focus:ring-2 focus:ring-amber-500 cursor-pointer"
                           {{ isset($settings['allow_renewal_with_pending']) && $settings['allow_renewal_with_pending'] ? 'checked' : '' }}>
                    <label for="allow_renewal_with_pending" class="ml-3 flex flex-col cursor-pointer">
                        <span class="font-medium text-gray-900">Permitir renovações com outras pendências</span>
                        <span class="text-sm text-gray-600">Permite renovação mesmo havendo outras pendências</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- NOTIFICATIONS SETTINGS TAB -->
        <div class="tab-content bg-white rounded-b-lg p-6 sm:p-8 shadow-md" id="notifications-content" style="display: none;">
            <!-- E-mail Configuration -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                    <div class="bg-indigo-100 rounded-lg p-3">
                        <i class="fas fa-envelope text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Configuração de E-mail</h3>
                        <p class="text-sm text-gray-600">Defina os parâmetros de envio de e-mails</p>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-gray-300 transition-colors duration-200 mb-6">
                    <input type="hidden" name="settings[enable_email_notifications]" value="0">
                    <input type="checkbox" id="enable_email_notifications" name="settings[enable_email_notifications]" value="1"
                           class="w-5 h-5 text-amber-600 rounded focus:ring-2 focus:ring-amber-500 cursor-pointer"
                           {{ isset($settings['enable_email_notifications']) && $settings['enable_email_notifications'] ? 'checked' : '' }}>
                    <label for="enable_email_notifications" class="ml-3 flex flex-col cursor-pointer">
                        <span class="font-medium text-gray-900">Ativar notificações por e-mail</span>
                        <span class="text-sm text-gray-600">Permite o envio de notificações aos usuários</span>
                    </label>
                </div>

                <div class="email-notification-settings grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-amber-50 border border-amber-200 rounded-lg" id="email-settings" style="{{ isset($settings['enable_email_notifications']) && $settings['enable_email_notifications'] ? '' : 'display: none;' }}">
                    <div>
                        <label for="email_from_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome de Remetente <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="email_from_name" name="settings[email_from_name]"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all duration-200"
                               autocomplete="off"
                               value="{{ $settings['email_from_name'] ?? 'Aluga Livros' }}">
                    </div>

                    <div>
                        <label for="email_from_address" class="block text-sm font-semibold text-gray-700 mb-2">
                            E-mail de Remetente <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email_from_address" name="settings[email_from_address]"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all duration-200"
                               autocomplete="off"
                               value="{{ $settings['email_from_address'] ?? 'noreply@alugalivros.com' }}">
                    </div>
                </div>
            </div>

            <!-- Alerts Configuration -->
            <div>
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                    <div class="bg-red-100 rounded-lg p-3">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Alertas e Lembretes</h3>
                        <p class="text-sm text-gray-600">Configure notificações de vencimento e atrasos</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <x-form.input
                        label="Dias antes do vencimento para enviar lembrete"
                        placeholder="Digite o número de dias"
                        type="number"
                        name="settings[days_before_due_reminder]"
                        id="days_before_due_reminder"
                        value="{{ $settings['days_before_due_reminder'] ?? 2 }}"
                        min="1"
                        max="7"
                        required
                    />

                    <x-form.input
                        label="Frequência de notificações de atraso (dias)"
                        placeholder="Digite a frequência de notificações"
                        type="number"
                        name="settings[overdue_notice_frequency]"
                        id="overdue_notice_frequency"
                        value="{{ $settings['overdue_notice_frequency'] ?? 3 }}"
                        min="1"
                        max="7"
                        required
                    />
                </div>

                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-gray-300 transition-colors duration-200">
                    <input type="hidden" name="settings[send_overdue_notices]" value="0">
                    <input type="checkbox" id="send_overdue_notices" name="settings[send_overdue_notices]" value="1"
                           class="w-5 h-5 text-amber-600 rounded focus:ring-2 focus:ring-amber-500 cursor-pointer"
                           {{ isset($settings['send_overdue_notices']) && $settings['send_overdue_notices'] ? 'checked' : '' }}>
                    <label for="send_overdue_notices" class="ml-3 flex flex-col cursor-pointer">
                        <span class="font-medium text-gray-900">Enviar notificações de atraso</span>
                        <span class="text-sm text-gray-600">Notifica usuários sobre empréstimos atrasados</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- BACKUP SETTINGS TAB -->
        <div class="tab-content bg-white rounded-b-lg p-6 sm:p-8 shadow-md" id="backup-content" style="display: none;">
            <!-- Automatic Backup -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                    <div class="bg-cyan-100 rounded-lg p-3">
                        <i class="fas fa-server text-cyan-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Backup Automático</h3>
                        <p class="text-sm text-gray-600">Configure backups automáticos do sistema</p>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-gray-300 transition-colors duration-200 mb-6">
                    <input type="hidden" name="settings[enable_auto_backup]" value="0">
                    <input type="checkbox" id="enable_auto_backup" name="settings[enable_auto_backup]" value="1"
                           class="w-5 h-5 text-amber-600 rounded focus:ring-2 focus:ring-amber-500 cursor-pointer"
                           {{ isset($settings['enable_auto_backup']) && $settings['enable_auto_backup'] ? 'checked' : '' }}>
                    <label for="enable_auto_backup" class="ml-3 flex flex-col cursor-pointer">
                        <span class="font-medium text-gray-900">Ativar backup automático</span>
                        <span class="text-sm text-gray-600">O sistema criará backups automaticamente</span>
                    </label>
                </div>

                <div id="backup-settings" class="p-4 bg-cyan-50 border border-cyan-200 rounded-lg space-y-6" style="{{ isset($settings['enable_auto_backup']) && $settings['enable_auto_backup'] ? '' : 'display: none;' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="backup_frequency" class="block text-sm font-semibold text-gray-700 mb-2">
                                Frequência de Backup <span class="text-red-500">*</span>
                            </label>
                            <select id="backup_frequency" name="settings[backup_frequency]" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all duration-200" required>
                                <option value="daily" {{ ($settings['backup_frequency'] ?? 'weekly') == 'daily' ? 'selected' : '' }}>Diário</option>
                                <option value="weekly" {{ ($settings['backup_frequency'] ?? 'weekly') == 'weekly' ? 'selected' : '' }}>Semanal</option>
                                <option value="monthly" {{ ($settings['backup_frequency'] ?? 'weekly') == 'monthly' ? 'selected' : '' }}>Mensal</option>
                            </select>
                            <p class="mt-2 text-sm text-gray-600">Com que frequência os backups serão criados</p>
                        </div>

                        <div>
                            <label for="backup_retention" class="block text-sm font-semibold text-gray-700 mb-2">
                                Número de Backups a Manter <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="backup_retention" name="settings[backup_retention]"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all duration-200"
                                   value="{{ $settings['backup_retention'] ?? 5 }}" min="1" max="30" required>
                            <p class="mt-2 text-sm text-gray-600">Backups mais antigos serão automaticamente excluídos</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Backup Actions -->
            <div>
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                    <div class="bg-teal-100 rounded-lg p-3">
                        <i class="fas fa-tools text-teal-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Ações de Backup Manual</h3>
                        <p class="text-sm text-gray-600">Crie ou gerencie backups manualmente</p>
                    </div>
                </div>

                <div class="p-6 bg-gradient-to-r from-teal-50 to-cyan-50 border-l-4 border-teal-500 rounded-lg">
                    <p class="text-gray-700 mb-4">Você pode criar backups manualmente ou gerenciar os backups existentes através da página de gerenciamento.</p>
                    <a href="{{ route('settings.backups') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-database"></i>
                        Gerenciar Backups
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center sm:justify-start p-6 bg-gray-50 border-t border-gray-200 rounded-b-lg">
            <button type="submit" class="px-8 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2 order-first sm:order-none">
                <i class="fas fa-save"></i>
                Salvar Configurações
            </button>
            <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gerenciamento de abas com transição suave
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.getAttribute('data-tab');

                // Remove active from all buttons and contents
                tabButtons.forEach(tab => {
                    tab.classList.remove('active', 'border-amber-600', 'text-amber-600');
                    tab.classList.add('border-transparent', 'text-gray-600');
                });
                tabContents.forEach(content => {
                    content.style.display = 'none';
                    content.classList.remove('active');
                });

                // Add active to clicked button and corresponding content
                button.classList.add('active', 'border-amber-600', 'text-amber-600');
                button.classList.remove('border-transparent', 'text-gray-600');
                const contentElement = document.getElementById(`${tabName}-content`);
                if (contentElement) {
                    contentElement.style.display = 'block';
                    contentElement.classList.add('active');
                }
            });
        });

        // Email notifications toggle
        const emailNotificationsCheckbox = document.getElementById('enable_email_notifications');
        const emailSettings = document.getElementById('email-settings');

        if (emailNotificationsCheckbox) {
            emailNotificationsCheckbox.addEventListener('change', function() {
                emailSettings.style.display = this.checked ? 'grid' : 'none';
            });
        }

        // Auto backup toggle
        const autoBackupCheckbox = document.getElementById('enable_auto_backup');
        const backupSettings = document.getElementById('backup-settings');

        if (autoBackupCheckbox) {
            autoBackupCheckbox.addEventListener('change', function() {
                backupSettings.style.display = this.checked ? 'block' : 'none';
            });
        }

        // Auto-hide success alerts
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
