@props([
    'name',
    'label',
    'type' => 'text', // 'text', 'textarea', 'password', etc.
])

@php
    // Definição centralizada das classes de estilo para inputs/textareas
    $fieldClasses = 'block w-full mt-1 border-gray-300 rounded-lg shadow-sm sm:text-sm ' .
                    'focus:ring-[#009496] focus:border-[#009496] ' .
                    'aria-disabled:bg-gray-100';

    // Definição das classes dos botões
    $saveButtonBase = 'px-3 py-2 text-white transition rounded-lg';
    $saveButtonDisabled = 'bg-gray-400 cursor-not-allowed';
    $saveButtonEnabled = 'bg-green-500 hover:bg-green-600';
    $cancelButtonClasses = 'px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600';
@endphp

{{-- Usando $attributes->merge para aplicar classes e atributos ao div principal --}}
<div {{ $attributes->except(['type', 'label', 'name'])->merge(['class' => 'flex items-start mb-4 space-x-2']) }}>
    <div class="flex-1">
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>

        @if ($type === 'textarea')
            <textarea
                id="{{ $name }}"
                x-model="{{ $name }}"
                x-ref="{{ $name }}_editor"
                :disabled="confirmed.{{ $name }}"
                rows="3"
                @input="{{ $name }} = $event.target.value"
                {{-- Aplica a classe centralizada e permite que classes adicionais sejam passadas --}}
                {{ $attributes->whereDoesntStartWith('class')->merge(['class' => $fieldClasses, 'aria-disabled' => "confirmed.{$name}"]) }}
            >{{ $attributes->get('value') ?? '' }}</textarea>
        @else
            <input
                type="{{ $type }}"
                id="{{ $name }}"
                x-model="{{ $name }}"
                :disabled="confirmed.{{ $name }}"
                {{-- Aplica a classe centralizada e permite que classes adicionais sejam passadas --}}
                {{ $attributes->whereDoesntStartWith('class')->merge(['class' => $fieldClasses, 'aria-disabled' => "confirmed.{$name}"]) }}
            >
        @endif
    </div>

    {{-- Botões de Confirmação e Alteração --}}
    <div class="flex pt-6 space-x-1">

        <button type="button" @click="saveField('{{ $name }}')" x-show="!confirmed.{{ $name }}"
            :disabled="!{{ $name }}"
            class="{{ $saveButtonBase }}"
            :class="!{{ $name }} ? '{{ $saveButtonDisabled }}' : '{{ $saveButtonEnabled }}'">
            ✔
        </button>

        <button type="button" @click="toggleConfirm('{{ $name }}')" x-show="confirmed.{{ $name }}"
            class="{{ $cancelButtonClasses }}">
            ✖
        </button>
    </div>
</div>
