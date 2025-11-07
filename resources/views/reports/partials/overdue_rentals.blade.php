@if(count($overdueRentals) > 0)
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Usuário</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Livro</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Data Devolução</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Dias em Atraso</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($overdueRentals as $rental)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $rental->id_aluguel }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $rental->usuario->nome }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $rental->livro->titulo }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($rental->dt_devolucao)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            {{ $rental->diasAtraso() }} dias
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex gap-2">
                            <a href="{{ route('rentals.show', $rental->id_aluguel) }}" class="inline-flex items-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200" title="Ver Detalhes">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="inline-flex items-center px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors duration-200 notify" data-id="{{ $rental->id_usuario }}" title="Notificar Usuário">
                                <i class="fas fa-envelope"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="p-12 text-center">
        <i class="fas fa-check-circle text-5xl text-green-300 mb-4"></i>
        <p class="text-gray-500 text-lg">Não há aluguéis em atraso no momento.</p>
    </div>
@endif