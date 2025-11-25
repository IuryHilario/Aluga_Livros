<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-900 mb-2">
        {{ $labelNome }}

        @if($required)<span class="text-red-600">*</span>@endif
    </label>
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" placeholder="{{ $placeHolder }}" value="{{ $value }}"
            class="w-full rounded-lg border @if($errors->has($name)) border-red-500 @else border-gray-300 @endif bg-gray-50 px-4 py-2.5 text-sm focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition-all duration-200"
            @if($required) required @endif
            autocomplete="off"
            >
    @if($errors->has($name))
        <p class="mt-1 text-sm text-red-600">{{ $errors->first($name) }}</p>
    @endif
</div>