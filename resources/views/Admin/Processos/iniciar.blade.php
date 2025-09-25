@extends('layouts.app')

@section('page-title', 'Iniciar processo ' . $processo->id)
@section('page-subtitle', 'Cadastrar/Editar detalhes do processo')

@section('content')
    <div class="py-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Seção de Documentos -->
            <div class="mb-8">
                <div class="overflow-hidden bg-white border border-gray-100 shadow-sm rounded-2xl">
                    <!-- Header -->
                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex flex-col items-start justify-between lg:flex-row lg:items-center">
                            <h3 class="text-xl font-semibold text-gray-800">Gerar Documentos</h3>
                            <span class="mt-2 text-sm text-gray-500 lg:mt-0">
                                {{ $processo->modalidade->getDisplayName() }}
                            </span>
                        </div>
                    </div>

                    <!-- Tabela de Documentos -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Documentos
                                    </th>
                                    <th
                                        class="w-40 px-6 py-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Capa do documento -->
                                <tr class="transition-colors duration-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 w-8 h-8 rounded-full bg-[#009496]/10 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-[#009496]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-6 0H5m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    Capa do documento
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center">
                                            <a href="{{ route('admin.processos.pdf', [
                                                'processo' => $processo->id,
                                                'documento' => 'capa',
                                            ]) }}"
                                                target="_blank"
                                                class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600 rounded-lg hover:bg-red-700"
                                                title="Visualizar PDF">
                                                Gerar PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Documento Formalização de Demanda -->
                                <tr class="transition-colors duration-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 w-8 h-8 rounded-full bg-[#009496]/10 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-[#009496]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-6 0H5m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    DOCUMENTO FORMALIZAÇÃO DE DEMANDA
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center">
                                            <a href="{{ route('admin.processos.pdf', [
                                                'processo' => $processo->id,
                                                'documento' => 'formalizacao',
                                            ]) }}"
                                                target="_blank"
                                                class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600 rounded-lg hover:bg-red-700"
                                                title="Visualizar PDF">
                                                Gerar PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- AUTORIZAÇÃO PARA ELABORAÇÃO DE ESTUDO TÉCNICO -->
                                <tr class="transition-colors duration-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 w-8 h-8 rounded-full bg-[#009496]/10 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-[#009496]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-6 0H5m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    AUTORIZAÇÃO PARA ELABORAÇÃO DE ESTUDO TÉCNICO
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center">
                                            <a href="{{ route('admin.processos.pdf', [
                                                'processo' => $processo->id,
                                                'documento' => 'autorizacao',
                                            ]) }}"
                                                target="_blank"
                                                class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600 rounded-lg hover:bg-red-700"
                                                title="Visualizar PDF">
                                                Gerar PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Seção de Informações do Processo -->
            <div class="mb-8">
                <div class="overflow-hidden bg-white border border-gray-100 shadow-sm rounded-2xl">
                    <!-- Header -->
                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex flex-col items-start justify-between lg:flex-row lg:items-center">
                            <h3 class="text-xl font-semibold text-gray-800">Processos Licitatórios</h3>
                        </div>
                    </div>

                    <!-- Tabela de Informações -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Prefeitura
                                    </th>
                                    <th
                                        class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Modalidade
                                    </th>
                                    <th
                                        class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Nº Processo
                                    </th>
                                    <th
                                        class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Nº Procedimento
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="transition-colors duration-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 w-8 h-8 rounded-full bg-[#009496]/10 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-[#009496]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-6 0H5m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $processo->prefeitura->nome }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex px-2.5 py-0.5 text-xs font-medium rounded-full
                                            @if ($processo->modalidade->value === 'dispensa') bg-purple-100 text-purple-800
                                            @elseif($processo->modalidade->value === 'inexigibilidade') bg-pink-100 text-pink-800
                                            @elseif($processo->modalidade->value === 'pregão') bg-blue-100 text-blue-800
                                            @elseif($processo->modalidade->value === 'concorrência') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $processo->modalidade->getDisplayName() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-sm text-gray-900">
                                        {{ $processo->numero_processo }}
                                    </td>
                                    <td class="px-6 py-4 font-mono text-sm text-gray-900">
                                        {{ $processo->numero_procedimento }}
                                    </td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td colspan="4" class="px-6 py-4 text-sm text-gray-700">
                                        <strong>Objeto:</strong> {{ $processo->objeto }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Formulário de Detalhes -->
            <div class="p-6 bg-white shadow rounded-2xl">
                <form action="{{ route('admin.processos.detalhes.store', $processo) }}" method="POST"
                    x-data="formField({{ json_encode($processo->detalhe ?? null) }})" @submit.prevent="submitForm">
                    @csrf

                    <div class="space-y-6">
                        <!-- Campos principais em sequência -->
                        <x-form-field name="secretaria" label="Secretaria" />

                        <!-- Unidade/Setor/Departamento -->
                        <div class="flex items-start space-x-2">
                            <div class="flex-1">
                                <label for="unidade_setor" class="block mb-1 text-sm font-medium text-gray-700">
                                    Unidade / Setor / Departamento
                                </label>
                                <select id="unidade_setor" x-model="unidade_setor" :disabled="confirmed.unidade_setor"
                                    class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                    <option value="">Selecione uma unidade</option>
                                    @foreach ($processo->prefeitura->unidades as $unidade)
                                        <option value="{{ $unidade->nome }}"
                                            {{ ($processo->detalhe->unidade_setor ?? '') == $unidade->nome ? 'selected' : '' }}>
                                            {{ $unidade->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex pt-6 space-x-1">
                                <button type="button" @click="saveField('unidade_setor')"
                                    x-show="!confirmed.unidade_setor" :disabled="!unidade_setor"
                                    class="px-3 py-2 text-white transition rounded-lg"
                                    :class="!unidade_setor ? 'bg-gray-400 cursor-not-allowed' :
                                        'bg-green-500 hover:bg-green-600'">
                                    ✔
                                </button>
                                <button type="button" @click="toggleConfirm('unidade_setor')"
                                    x-show="confirmed.unidade_setor"
                                    class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                    ✖
                                </button>
                            </div>
                        </div>

                        <!-- Servidor Responsável -->
                        <div class="flex items-start space-x-2">
                            <div class="flex-1">
                                <label for="servidor_responsavel" class="block text-sm font-medium text-gray-700">
                                    Servidor Responsável
                                </label>
                                <input type="text" id="servidor_responsavel" x-model="servidor_responsavel"
                                    value="{{ $processo->detalhe->servidor_responsavel ?? '' }}" readonly
                                    class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-lg shadow-sm sm:text-sm">
                            </div>
                        </div>

                        <x-form-field name="prazo_entrega" label="Prazo de Entrega / Execução" />
                        <x-form-field name="local_entrega" label="Local(is) e Horário(s) de Entrega" />

                        <x-form-field name="demanda" label="Demanda" type="textarea" />
                        <x-form-field name="justificativa" label="Justificativa da Necessidade da Contratação"
                            type="textarea" />

                        <x-form-field name="fiscais" label="Fiscal(is) Indicado(s)" />
                        <x-form-field name="gestor" label="Gestor Indicado" />

                        <!-- Contratações Anteriores -->
                        <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
                            <div class="flex-1">
                                <span class="block mb-1 text-sm font-medium text-gray-700">Houve contratações
                                    anteriores?</span>
                                <div class="flex mt-1 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" x-model="contratacoes_anteriores" value="sim"
                                            :disabled="confirmed.contratacoes_anteriores"
                                            :checked="contratacoes_anteriores === 'sim'">
                                        <span class="ml-2">Sim</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" x-model="contratacoes_anteriores" value="nao"
                                            :disabled="confirmed.contratacoes_anteriores"
                                            :checked="contratacoes_anteriores === 'nao'">
                                        <span class="ml-2">Não</span>
                                    </label>
                                </div>
                            </div>
                            <div class="flex pt-6 space-x-1">
                                <button type="button" @click="saveField('contratacoes_anteriores')"
                                    x-show="!confirmed.contratacoes_anteriores"
                                    class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                    ✔
                                </button>
                                <button type="button" @click="toggleConfirm('contratacoes_anteriores')"
                                    x-show="confirmed.contratacoes_anteriores"
                                    class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                    ✖
                                </button>
                            </div>
                        </div>

                        <!-- Instrumento Vinculativo -->
                        <div class="flex items-start space-x-2">
                            <div class="flex-1">
                                <span class="block mb-1 text-sm font-medium text-gray-700">Instrumento Vinculativo</span>
                                <div class="mt-2 space-y-2">
                                    @php
                                        $instrumentos = [
                                            'contrato' => 'Contrato',
                                            'ata_registro_precos' => 'Ata de Registro de Preços',
                                            'outro' => 'Outro',
                                        ];
                                    @endphp

                                    @foreach ($instrumentos as $value => $label)
                                        <div class="flex items-center">
                                            <input type="checkbox" value="{{ $value }}"
                                                x-model="instrumento_vinculativo"
                                                :disabled="confirmed.instrumento_vinculativo"
                                                :checked="instrumento_vinculativo.includes('{{ $value }}')">
                                            <span class="ml-2 text-sm">{{ $label }}</span>
                                            @if ($value === 'outro')
                                                <input type="text" x-show="instrumento_vinculativo.includes('outro')"
                                                    x-model="instrumento_vinculativo_outro"
                                                    :disabled="confirmed.instrumento_vinculativo"
                                                    class="w-32 px-2 py-1 ml-2 text-sm border-gray-300 rounded-lg shadow-sm">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex pt-6 space-x-1">
                                <button type="button" @click="saveField('instrumento_vinculativo')"
                                    x-show="!confirmed.instrumento_vinculativo"
                                    class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                    ✔
                                </button>
                                <button type="button" @click="toggleConfirm('instrumento_vinculativo')"
                                    x-show="confirmed.instrumento_vinculativo"
                                    class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                    ✖
                                </button>
                            </div>
                        </div>

                        <!-- Prazo de Vigência -->
                        <div class="flex items-start space-x-2">
                            <div class="flex-1">
                                <span class="block mb-1 text-sm font-medium text-gray-700">Prazo de Vigência do
                                    Objeto</span>
                                <div class="mt-2 space-y-2">
                                    @php
                                        $prazos = [
                                            'exercicio_financeiro' => 'Exercício financeiro da contratação (até 31/12)',
                                            '12_meses' => 'Vigência de 12 meses',
                                            'outro' => 'Outro',
                                        ];
                                    @endphp

                                    @foreach ($prazos as $value => $label)
                                        <div class="flex items-center">
                                            <input type="checkbox" value="{{ $value }}" x-model="prazo_vigencia"
                                                :disabled="confirmed.prazo_vigencia"
                                                :checked="prazo_vigencia.includes('{{ $value }}')">
                                            <span class="ml-2 text-sm">{{ $label }}</span>
                                            @if ($value === 'outro')
                                                <input type="text" x-show="prazo_vigencia.includes('outro')"
                                                    x-model="prazo_vigencia_outro" :disabled="confirmed.prazo_vigencia"
                                                    class="w-32 px-2 py-1 ml-2 text-sm border-gray-300 rounded-lg shadow-sm">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex pt-6 space-x-1">
                                <button type="button" @click="saveField('prazo_vigencia')"
                                    x-show="!confirmed.prazo_vigencia"
                                    class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                    ✔
                                </button>
                                <button type="button" @click="toggleConfirm('prazo_vigencia')"
                                    x-show="confirmed.prazo_vigencia"
                                    class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                    ✖
                                </button>
                            </div>
                        </div>

                        <!-- Objeto Continuado -->
                        <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
                            <div class="flex-1">
                                <span class="block mb-1 text-sm font-medium text-gray-700">Objeto Continuado?</span>
                                <div class="flex mt-1 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" x-model="objeto_continuado" value="sim"
                                            :disabled="confirmed.objeto_continuado"
                                            :checked="objeto_continuado === 'sim'">
                                        <span class="ml-2">Sim</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" x-model="objeto_continuado" value="nao"
                                            :disabled="confirmed.objeto_continuado"
                                            :checked="objeto_continuado === 'nao'">
                                        <span class="ml-2">Não</span>
                                    </label>
                                </div>
                            </div>
                            <div class="flex pt-6 space-x-1">
                                <button type="button" @click="saveField('objeto_continuado')"
                                    x-show="!confirmed.objeto_continuado"
                                    class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                    ✔
                                </button>
                                <button type="button" @click="toggleConfirm('objeto_continuado')"
                                    x-show="confirmed.objeto_continuado"
                                    class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                    ✖
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex justify-end pt-6 mt-6 space-x-3 border-t border-gray-200">
                        <a href="{{ route('admin.processos.index') }}"
                            class="px-6 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 bg-gray-100 rounded-lg hover:bg-gray-200">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-[#009496] rounded-lg hover:bg-[#007a7a] transition-colors duration-200">
                            Salvar tudo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function formField(existing = {}) {
            return {
                // Campos do formulário
                secretaria: existing?.secretaria ?? '',
                unidade_setor: existing?.unidade_setor ?? '',
                servidor_responsavel: existing?.servidor_responsavel ?? '',
                demanda: existing?.demanda ?? '',
                justificativa: existing?.justificativa ?? '',
                prazo_entrega: existing?.prazo_entrega ?? '',
                local_entrega: existing?.local_entrega ?? '',
                contratacoes_anteriores: existing?.contratacoes_anteriores ?? '',
                fiscais: existing?.fiscais ?? '',
                gestor: existing?.gestor ?? '',
                instrumento_vinculativo: existing?.instrumento_vinculativo ?? [],
                instrumento_vinculativo_outro: existing?.instrumento_vinculativo_outro ?? '',
                prazo_vigencia: existing?.prazo_vigencia ?? [],
                prazo_vigencia_outro: existing?.prazo_vigencia_outro ?? '',
                objeto_continuado: existing?.objeto_continuado ?? '',

                // Controle de confirmação de cada campo
                confirmed: {
                    secretaria: !!existing?.secretaria,
                    unidade_setor: !!existing?.unidade_setor,
                    servidor_responsavel: !!existing?.servidor_responsavel,
                    demanda: !!existing?.demanda,
                    justificativa: !!existing?.justificativa,
                    prazo_entrega: !!existing?.prazo_entrega,
                    local_entrega: !!existing?.local_entrega,
                    contratacoes_anteriores: !!existing?.contratacoes_anteriores,
                    fiscais: !!existing?.fiscais,
                    gestor: !!existing?.gestor,
                    instrumento_vinculativo: existing?.instrumento_vinculativo?.length > 0,
                    prazo_vigencia: existing?.prazo_vigencia?.length > 0,
                    objeto_continuado: !!existing?.objeto_continuado,
                },

                // Método para quando a unidade é alterada
                onUnidadeChange() {
                    if (this.unidade_setor) {
                        this.saveField('unidade_setor');
                    }
                },

                // Alterna o estado de confirmação
                toggleConfirm(field) {
                    if (!this.confirmed[field]) {
                        this.saveField(field);
                    } else {
                        this.confirmed[field] = false;
                    }
                },

                async saveField(field) {
                    const formData = new FormData();
                    const value = this[field];

                    formData.append('processo_id', {{ $processo->id }});
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content'));

                    if (Array.isArray(value)) {
                        if (value.length === 0) {
                            formData.append(field, '');
                        } else {
                            value.forEach(v => formData.append(field + '[]', v));
                        }

                        if (field === 'instrumento_vinculativo' && this.instrumento_vinculativo_outro) {
                            formData.append('instrumento_vinculativo_outro', this.instrumento_vinculativo_outro);
                        }
                        if (field === 'prazo_vigencia' && this.prazo_vigencia_outro) {
                            formData.append('prazo_vigencia_outro', this.prazo_vigencia_outro);
                        }
                    } else {
                        formData.append(field, value);
                    }

                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    try {
                        const response = await fetch("{{ route('admin.processos.detalhes.store', $processo) }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const responseData = await response.json();

                        if (response.ok) {
                            this.confirmed[field] = true;

                            // Se for unidade_setor e veio servidor_responsavel na resposta, atualiza o campo
                            if (field === 'unidade_setor' && responseData.servidor_responsavel) {
                                this.servidor_responsavel = responseData.servidor_responsavel;
                                this.confirmed.servidor_responsavel = true;
                            }

                            console.log(field + ' salvo com sucesso!');
                        } else {
                            this.confirmed[field] = false;
                            console.error('Erro ao salvar campo:', field, responseData);
                            alert('Erro ao salvar ' + field + '. Verifique o console.');
                        }
                    } catch (error) {
                        this.confirmed[field] = false;
                        console.error('Erro de rede ao salvar campo:', field, error);
                        alert('Erro de rede ao salvar ' + field + '.');
                    }
                },

                submitForm() {
                    // Implementar lógica de submit do formulário completo
                    this.$el.submit();
                }
            }
        }
    </script>
@endsection
