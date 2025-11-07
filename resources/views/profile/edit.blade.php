@extends('layouts.app')

@section('title', 'Meu Perfil - '  . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Meu Perfil')

@section('breadcrumb')
<span>Meu Perfil</span>
@endsection

@section('content')
<!-- Profile Container -->
<div class="w-full max-w-4xl mx-auto">
    <!-- Profile Header Card -->
    <div class="bg-gradient-to-r from-amber-50 to-amber-100 rounded-lg shadow-md p-6 mb-8">
        <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
            <!-- Avatar -->
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center shadow-lg flex-shrink-0">
                <span class="text-3xl sm:text-4xl font-bold text-white">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
            </div>
            <!-- Welcome Text -->
            <div class="text-center sm:text-left flex-1">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">
                    Olá, {{ explode(' ', Auth::user()->name)[0] }}!
                </h2>
                <p class="text-gray-600 mt-1">
                    Gerencie suas informações pessoais e senha aqui
                </p>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex gap-2 sm:gap-4 mb-6 border-b border-gray-200 overflow-x-auto">
        <button class="tab-button active"
                data-tab="personal-info"
                class="px-4 sm:px-6 py-3 font-medium text-gray-700 border-b-2 border-transparent hover:text-amber-600 focus:outline-none focus:border-amber-500 transition-colors duration-200 whitespace-nowrap active:border-amber-600">
            <i class="fas fa-user-circle mr-2"></i>
            <span class="hidden sm:inline">Informações Pessoais</span>
            <span class="sm:hidden">Pessoais</span>
        </button>
        <button class="tab-button"
                data-tab="security"
                class="px-4 sm:px-6 py-3 font-medium text-gray-700 border-b-2 border-transparent hover:text-amber-600 focus:outline-none focus:border-amber-500 transition-colors duration-200 whitespace-nowrap">
            <i class="fas fa-lock mr-2"></i>
            <span>Segurança</span>
        </button>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('PATCH')

        <!-- Personal Information Tab -->
        <div class="tab-content active" id="personal-info-content">
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <!-- Panel Header -->
                <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 sm:py-6">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900">
                        <i class="fas fa-user-edit text-amber-600 mr-2"></i>
                        Informações Pessoais
                    </h3>
                    <p class="text-gray-600 text-sm mt-1">
                        Atualize suas informações básicas da conta
                    </p>
                </div>
                <!-- Panel Body -->
                <div class="p-6 sm:p-8 space-y-6">
                    <x-form.input
                        label="Nome Completo"
                        name="name"
                        type="text"
                        value="{{ old('name', Auth::user()->name) }}"
                        required
                    />

                    <x-form.input
                        label="E-mail"
                        name="email"
                        type="email"
                        value="{{ old('email', Auth::user()->email) }}"
                        required
                    />
                </div>
            </div>
        </div>

        <!-- Security Tab -->
        <div class="tab-content hidden" id="security-content">
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <!-- Panel Header -->
                <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 sm:py-6">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900">
                        <i class="fas fa-lock text-amber-600 mr-2"></i>
                        Alterar Senha
                    </h3>
                    <p class="text-gray-600 text-sm mt-1">
                        Mantenha sua conta segura atualizando sua senha regularmente
                    </p>
                </div>
                <!-- Panel Body -->
                <div class="p-6 sm:p-8 space-y-6">
                    <!-- Current Password -->
                    <div class="mb-6">
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Senha Atual <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="current_password"
                                   name="current_password"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 transition-all duration-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none @error('current_password') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   autocomplete="off" />
                            <button type="button"
                                    class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none">
                                <i class="fas fa-eye text-lg"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nova Senha <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 transition-all duration-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   autocomplete="off" />
                            <button type="button"
                                    class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none">
                                <i class="fas fa-eye text-lg"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmar Nova Senha <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 transition-all duration-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none"
                                   autocomplete="off" />
                            <button type="button"
                                    class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none">
                                <i class="fas fa-eye text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row gap-3 justify-end mt-8">
            <a href="{{ route('dashboard') }}"
               class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500/20 transition-all duration-200 text-center">
                <i class="fas fa-times mr-2"></i>
                <span class="hidden sm:inline">Cancelar</span>
                <span class="sm:hidden">Voltar</span>
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-amber-600 text-white font-medium hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all duration-200 flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                <span>Salvar Alterações</span>
            </button>
        </div>
    </form>
</div>

<!-- Alert Messages Container -->
<div id="alerts-container" class="fixed bottom-4 right-4 z-50 space-y-3 w-full max-w-sm px-4 sm:px-0"></div>

@vite(['resources/js/profile.js'])
@endsection
