@props([
    'name',
    'label',
    'type' => 'text' // 'text' ou 'textarea'
])

<div class="flex items-start mb-4 space-x-2">
    <div class="flex-1">
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>

        @if($type === 'textarea')
            <textarea
                id="{{ $name }}"
                x-model="{{ $name }}"
                :disabled="confirmed.{{ $name }}"
                rows="3"
                class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm"></textarea>
        @else
            <input
                type="text"
                id="{{ $name }}"
                x-model="{{ $name }}"
                :disabled="confirmed.{{ $name }}"
                class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm">
        @endif
    </div>

    {{-- A classe 'pt-6' ajuda a alinhar os botões com inputs text/textarea --}}
    <div class="flex pt-6 space-x-1">

        <button type="button"
                @click="saveField('{{ $name }}')"
                x-show="!confirmed.{{ $name }}"
                :disabled="!{{ $name }}" {{-- Desabilita se o campo estiver vazio --}}
                class="px-3 py-2 text-white transition rounded-lg"
                :class="!{{ $name }} ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-600'">
            ✔
        </button>

        <button type="button"
                @click="toggleConfirm('{{ $name }}')"
                x-show="confirmed.{{ $name }}"
                class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
            ✖
        </button>
    </div>
</div>
