<div class="flex flex-wrap gap-2">
    @if (!empty($show))
        <a href="{{ $show }}" class="inline-flex items-center justify-center px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200" title="Visualizar" data-tooltip="Visualizar">
            <i class="fas fa-eye"></i>
        </a>
    @endif

    @if (!empty($edit))
        <a href="{{ $edit }}" class="inline-flex items-center justify-center px-3 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors duration-200" title="Editar" data-tooltip="Editar">
            <i class="fas fa-edit"></i>
        </a>
    @endif

    @if (!empty($delete))
        <form action="{{ $delete }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este item?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center justify-center px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200" title="Excluir" data-tooltip="Excluir">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    @endif

    @if (!empty($devolver))
        <a href="{{ $devolver }}" class="inline-flex items-center justify-center px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200" title="Devolver" data-tooltip="Devolver">
            <i class="fas fa-undo"></i>
        </a>
    @endif

    @if (!empty($email))
        <a href="{{ $email }}" class="inline-flex items-center justify-center px-3 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors duration-200" title="Enviar Email" data-tooltip="Enviar Email" data-rental-id="{{ substr(strrchr($email, '/'), 1) }}">
            <i class="fas fa-envelope"></i>
        </a>
    @endif

    @if (!empty($renovar))
        <a href="{{ $renovar }}" class="inline-flex items-center justify-center px-3 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-colors duration-200" title="Renovar" data-tooltip="Renovar">
            <i class="fas fa-sync-alt"></i>
        </a>
    @endif
</div>
