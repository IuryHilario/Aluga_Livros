<div class="mb-6">
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-semibold text-gray-700 mb-2">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}" @if($required) required @endif
        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 transition-all duration-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none @error($name) border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
        autocomplete="off">

    @error($name)
        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
        </p>
    @enderror
</div>
