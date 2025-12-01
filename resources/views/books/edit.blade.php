@extends('layouts.app')

@section('title', 'Editar Livro - ' . ($settings['system_name'] ?? 'Aluga Livros'))

@section('page-title', 'Editar Livro')

@section('breadcrumb')
    <a href="{{ route('books.index') }}" class="hover:text-amber-600 transition-colors duration-200">Livros</a> / <span>Editar</span>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
    <!-- Header -->
    <div class="border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
        <h3 class="text-lg sm:text-xl font-semibold text-gray-900">Editar: {{ $livro->titulo }}</h3>
        <p class="text-sm text-gray-600 mt-1">Modifique os dados do livro conforme necessário</p>
    </div>

    <!-- Body -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <form action="{{ route('books.update', $livro->id_livro) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-2xl">
            @csrf
            @method('PUT')

            <!-- Título -->
            <div>
                <x-form.input
                    labelNome="Título do Livro"
                    type="text"
                    id="titulo"
                    name="titulo"
                    placeHolder="Digite o título do livro"
                    value="{{ old('titulo', $livro->titulo) }}"
                    :required="true"
                />
            </div>

            <!-- Autor -->
            <div>
                <x-form.input
                    labelNome="Autor"
                    type="text"
                    id="autor"
                    name="autor"
                    placeHolder="Digite o nome do autor"
                    value="{{ old('autor', $livro->autor) }}"
                    :required="true"
                />
            </div>

            <!-- Editora -->
            <div>
                <x-form.input
                    labelNome="Editora"
                    type="text"
                    id="editor"
                    name="editor"
                    placeHolder="Digite o nome da editora"
                    value="{{ old('editor', $livro->editor) }}"
                />
            </div>

            <!-- Ano de Publicação e Quantidade em Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <x-form.input
                        labelNome="Ano de Publicação"
                        type="number"
                        id="ano_publicacao"
                        name="ano_publicacao"
                        placeHolder="Ano de Publicação"
                        value="{{ old('ano_publicacao', $livro->ano_publicacao) }}"
                        :required="true"
                    />
                </div>

                <div>
                    <x-form.input
                        labelNome="Quantidade de Exemplares"
                        type="number"
                        id="quantidade"
                        name="quantidade"
                        placeHolder="Quantidade"
                        value="{{ old('quantidade', $livro->quantidade) }}"
                        :required="true"
                    />
                </div>
            </div>

            <!-- Capa do Livro -->
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-3">Capa do Livro</label>

                <!-- Current Cover -->
                @if($livro->capa)
                    <div class="mb-4 p-4 rounded-lg bg-gray-50 border border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-3">Capa Atual</p>
                        <div class="flex items-start gap-4">
                            <img src="{{ route('books.capa', $livro->id_livro) }}" alt="Capa atual"
                                 class="h-40 w-32 object-cover rounded-lg border border-gray-200">
                            <div class="flex-1 pt-2">
                                <p class="text-xs text-gray-600">Substitua por uma nova capa se necessário</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Upload Area -->
                <div class="mt-4 flex flex-col">
                    <label for="capa" class="relative flex items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-8 transition-colors duration-200 hover:border-amber-500 hover:bg-amber-50 cursor-pointer">
                        <div class="text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm font-medium text-gray-900">Clique para upload de nova capa</p>
                            <p class="text-xs text-gray-600 mt-1">JPG, PNG até 2MB</p>
                        </div>
                        <input type="file" id="capa" name="capa" class="sr-only" accept="image/jpeg,image/png">
                    </label>
                </div>
                @error('capa')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Image Preview -->
                <div id="image-preview" class="mt-4 hidden">
                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-3">Nova Capa</p>
                        <div class="flex items-start gap-4">
                            <img id="preview-img" src="" alt="Preview" class="h-40 w-32 object-cover rounded-lg border border-gray-200">
                            <div class="flex-1 pt-2">
                                <p class="text-xs text-gray-600" id="preview-filename"></p>
                                <button type="button" id="remove-preview" class="mt-3 text-sm text-red-600 hover:text-red-700 font-medium">
                                    <i class="fas fa-trash mr-1"></i> Remover
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 sm:pt-6 border-t border-gray-200">
                <a href="{{ route('books.index') }}" class="inline-flex items-center justify-center rounded-lg px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg px-6 py-2.5 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i> Atualizar Livro
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const capaInput = document.getElementById('capa');
        const imagePreview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        const previewFilename = document.getElementById('preview-filename');
        const removePreview = document.getElementById('remove-preview');

        capaInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewFilename.textContent = file.name;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        removePreview.addEventListener('click', function(e) {
            e.preventDefault();
            capaInput.value = '';
            imagePreview.classList.add('hidden');
        });
    });
</script>
@endpush
@endsection