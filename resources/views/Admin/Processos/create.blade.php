@extends('layouts.app')
@section('page-title', 'Gestão de Processos')
@section('page-subtitle', 'Preencha os dados do processo')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
    <div class="py-6">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Informações do Processo</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.processos.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            {{-- PREFEITURA --}}
                            <div>
                                <label for="prefeitura_id" class="block text-sm font-medium text-gray-700">Prefeitura</label>
                                <select name="prefeitura_id" id="prefeitura_id"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-[#009496] focus:border-[#009496]">
                                    <option value="">Selecione a prefeitura</option>
                                    @foreach ($prefeituras as $prefeitura)
                                        <option value="{{ $prefeitura->id }}"
                                            {{ old('prefeitura_id') == $prefeitura->id ? 'selected' : '' }}>
                                            {{ $prefeitura->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('prefeitura_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- MODALIDADE --}}
                            <div>
                                <label for="modalidade" class="block text-sm font-medium text-gray-700">Modalidade</label>
                                <select name="modalidade" id="modalidade"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-[#009496] focus:border-[#009496]">
                                    <option value="">Selecione a modalidade</option>
                                    @foreach (\App\Enums\ModalidadeEnum::cases() as $modalidade)
                                        <option value="{{ $modalidade->value }}"
                                            {{ old('modalidade') == $modalidade->value ? 'selected' : '' }}>
                                            {{ $modalidade->getDisplayName() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('modalidade')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nº PROCESSO --}}
                            <div>
                                <label for="numero_processo" class="block text-sm font-medium text-gray-700">Nº do
                                    Processo</label>
                                <input type="text" name="numero_processo" id="numero_processo"
                                    value="{{ old('numero_processo') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-[#009496] focus:border-[#009496]">
                                @error('numero_processo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nº PROCEDIMENTO --}}
                            <div>
                                <label for="numero_procedimento" class="block text-sm font-medium text-gray-700">Nº do
                                    Procedimento</label>
                                <input type="text" name="numero_procedimento" id="numero_procedimento"
                                    value="{{ old('numero_procedimento') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-[#009496] focus:border-[#009496]">
                                @error('numero_procedimento')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nº PORTARIA --}}
                            <div>
                                <label for="numero_portaria" class="block text-sm font-medium text-gray-700">Nº da
                                    Portaria</label>
                                <input type="text" name="numero_portaria" id="numero_portaria"
                                    value="{{ old('numero_portaria') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-[#009496] focus:border-[#009496]">
                                @error('numero_portaria')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- DATA DA PORTARIA --}}
                            <div>
                                <label for="data_portaria" class="block text-sm font-medium text-gray-700">Data da
                                    Portaria</label>
                                <input type="date" name="data_portaria" id="data_portaria"
                                    value="{{ old('data_portaria') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-[#009496] focus:border-[#009496]">
                                @error('data_portaria')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- TIPO DE PROCEDIMENTO --}}
                            <div>
                                <label for="tipo_procedimento" class="block mb-1 text-sm font-medium text-gray-700">
                                    Tipo de Procedimento
                                </label>
                                <select name="tipo_procedimento" id="tipo_procedimento"
                                    class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                    <option value="">Selecione o tipo de procedimento</option>
                                    @foreach (\App\Enums\TipoProcedimentoEnum::cases() as $enum)
                                        <option value="{{ $enum->value }}"
                                            {{ old('tipo_procedimento', $processo->tipo_procedimento?->value ?? '') == $enum->value ? 'selected' : '' }}>
                                            {{ $enum->getDisplayName() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_procedimento')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- TIPO DE CONTRATAÇÃO --}}
                            <div>
                                <label for="tipo_contratacao" class="block mb-1 text-sm font-medium text-gray-700">
                                    Tipo de Contratação
                                </label>
                                <select name="tipo_contratacao" id="tipo_contratacao"
                                    class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                    <option value="">Selecione o tipo de contratação</option>
                                    @foreach (\App\Enums\TipoContratacaoEnum::cases() as $enum)
                                        <option value="{{ $enum->value }}"
                                            {{ old('tipo_contratacao', $processo->tipo_contratacao?->value ?? '') == $enum->value ? 'selected' : '' }}>
                                            {{ $enum->getDisplayName() }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('tipo_contratacao')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- OBJETO --}}
                            <div class="md:col-span-2">
                                <label for="objeto" class="block text-sm font-medium text-gray-700">Objeto</label>
                                <textarea name="objeto" id="objeto" rows="4"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-[#009496] focus:border-[#009496]">{{ old('objeto') }}</textarea>
                                @error('objeto')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- BOTÕES --}}
                        <div class="flex justify-end mt-6 space-x-4">
                            <a href="{{ route('admin.processos.index') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-[#009496] rounded-md hover:bg-[#244853]">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        tinymce.init({
            selector: 'textarea', // aplica em todos os <textarea>
            plugins: 'lists link table code charmap emoticons',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link table | emoticons charmap | code',
            menubar: false,
            branding: false, // remove "Powered by Tiny"
            height: 300
        });
    </script>
@endsection
