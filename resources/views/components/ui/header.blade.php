    <div class="bg-gradient-to-r from-amber-50 to-amber-100 px-4 sm:px-6 lg:px-8 py-6 border-b border-amber-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="{{ $icon }} text-amber-600"></i> {{ $title }}
            </h3>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <button class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200" id="toggleFilter">
                <i class="fas fa-filter mr-2"></i> Filtro
            </button>
            <a href="{{ $route }}" class="inline-flex items-center justify-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200">
                <i class="{{ $icon }} mr-2"></i> {{ $name }}
            </a>
        </div>
    </div>