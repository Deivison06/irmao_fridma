{{-- resources/views/components/date-time-field.blade.php --}}
@props([
    'name',
    'label',
    'dateField' => 'data_evento',
    'timeField' => 'hora_evento',
    'saveMethod' => 'saveDataHora',
])

<div class="p-5 mb-4 bg-white border border-gray-200 shadow-sm rounded-xl">
    <h4 class="pb-2 mb-4 text-base font-semibold text-gray-700 border-b border-gray-200">
        📅 {{ $label }}
    </h4>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        {{-- Campo Data --}}
        <div class="flex flex-col">
            <label for="{{ $dateField }}" class="mb-1 text-sm font-medium text-gray-600">
                DATA
            </label>
            <input
                type="date"
                id="{{ $dateField }}"
                name="{{ $dateField }}"
                x-model="{{ $dateField }}"
                :disabled="confirmed.{{ $name }}"
                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        {{-- Campo Hora --}}
        <div class="flex flex-col">
            <label for="{{ $timeField }}" class="mb-1 text-sm font-medium text-gray-600">
                HORA
            </label>
            <input
                type="time"
                id="{{ $timeField }}"
                name="{{ $timeField }}"
                x-model="{{ $timeField }}"
                :disabled="confirmed.{{ $name }}"
                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >
        </div>
    </div>

    {{-- Status da data/hora salva --}}
    <div x-show="confirmed.{{ $name }}" class="p-3 mt-4 border border-green-200 rounded-lg bg-green-50">
        <div class="flex items-center text-sm text-green-700">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">Data/Hora salva:</span>
            <span x-text="{{ $dateField }} + ' ' + {{ $timeField }}" class="ml-2 font-semibold"></span>
        </div>
    </div>

    <div class="flex justify-end mt-5 space-x-3">
        <button
            type="button"
            @click="{{ $saveMethod }}()"
            :disabled="!{{ $dateField }} || !{{ $timeField }}"
            x-show="!confirmed.{{ $name }}"
            class="flex items-center px-5 py-2 text-white transition bg-green-500 rounded-lg hover:bg-green-600 disabled:bg-gray-400 disabled:cursor-not-allowed"
        >
            ✓ Salvar Data/Hora
        </button>

        <button
            type="button"
            @click="toggleConfirm('{{ $name }}')"
            x-show="confirmed.{{ $name }}"
            class="flex items-center px-5 py-2 text-white transition bg-red-500 rounded-lg hover:bg-red-600"
        >
            ✗ Alterar Data/Hora
        </button>
    </div>
</div>
