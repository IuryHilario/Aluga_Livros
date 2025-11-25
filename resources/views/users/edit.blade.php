@extends('layouts.app')

@section('title', 'Editar Usuário - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Editar Usuário')

@section('breadcrumb')
<a href="{{ route('users.index') }}">Usuários</a> / <span>Editar</span>
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-amber-50 to-amber-100 px-4 sm:px-6 lg:px-8 py-6 border-b border-amber-200">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Formulário de Edição</h3>
        </div>

    <!-- Body -->
    <div class="p-4 sm:p-6 lg:p-8 max-w-2xl">
        <form action="{{ route('users.update', $usuario->id_usuario) }}" method="POST" class="form-usuario space-y-4">
            @csrf
            @method('PUT')

            <x-form.input
                labelNome="Nome Completo"
                type="text"
                name="nome"
                id="nome"
                value="{{ old('nome', $usuario->nome) }}"
                :required="true"
            />

            <x-form.input
                labelNome="E-mail"
                type="email"
                name="email"
                id="email"
                value="{{ old('email', $usuario->email) }}"
                :required="true"
            />

            <x-form.input
                labelNome="Telefone"
                type="tel"
                name="telefone"
                id="telefone"
                value="{{ old('telefone', $usuario->telefone) }}"
                placeHolder="(00) 00000-0000"
            />

            <x-form.input
                labelNome="Máximo de Livros Permitidos"
                placeHolder="Digite o máximo de livros permitidos"
                type="number"
                name="max_emprestimos"
                id="max_emprestimos"
                value="{{ old('max_emprestimos', $settings['max_loans_per_user'] ?? 3) }}"
                min="1"
                max="{{ $settings['max_loans_per_user'] ?? 3 }}"
                :required="true"
            />

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200 font-medium">
                    <i class="fas fa-save mr-2"></i> Atualizar
                </button>
                <a href="{{ route('users.index', $usuario->id_usuario) }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200 font-medium">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Máscara para o campo de telefone
        const telefoneInput = document.getElementById('telefone');
        if (telefoneInput) {
            telefoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);

                if (value.length > 2) {
                    value = '(' + value.substring(0, 2) + ') ' + value.substring(2);
                }
                if (value.length > 10) {
                    value = value.substring(0, 10) + '-' + value.substring(10);
                }
                e.target.value = value;
            });
        }
    });
</script>
@endpush
