@extends('layouts.app')

@section('page-title', 'Iniciar processo ' . $processo->id)
@section('page-subtitle', 'Cadastrar/Editar detalhes do processo')

@section('content')
    <div class="py-8">

        <!-- Tabela de Processos -->
        <div class="mb-8 overflow-hidden bg-white border border-gray-100 shadow-sm rounded-2xl">
            <!-- Header da Tabela -->
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <div class="flex flex-col items-start justify-between lg:flex-row lg:items-center">
                    <h3 class="text-xl font-semibold text-gray-800">Processos Licitatórios</h3>
                    <span class="mt-2 text-sm text-gray-500 lg:mt-0">
                        {{ $processo->modalidade->getDisplayName() }}
                    </span>
                </div>
            </div>

            <!-- Tabela -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Documentos
                            </th>
                            <th class="px-6 py-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Linha 1: dados principais -->
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
                                <!-- Adicione este botão na seção de ações da tabela -->
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.processos.visualizar-pdf', $processo->id) }}" target="_blank"
                                        class="p-2 text-white transition-colors duration-200 bg-red-600 rounded-lg hover:bg-red-700"
                                        title="Visualizar PDF">
                                        {{-- <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg> --}}
                                        Gerar PDF
                                    </a>
                                    {{-- <a href="{{ route('admin.processos.pdf', $processo->id) }}"
                                        class="p-2 text-white transition-colors duration-200 bg-[#009496] rounded-lg hover:bg-[#007a7a]"
                                        title="Download PDF">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow rounded-2xl">

                <form action="{{ route('admin.processos.detalhes.store', $processo) }}" method="POST"
                    x-data="formField({{ json_encode($processo->detalhe ?? null) }})" @submit.prevent="submitForm">
                    @csrf

                    <x-form-field name="secretaria" label="Secretaria" />

                    <!-- Unidade/Setor/Departamento -->
                    <div class="flex items-start mb-4 space-x-2">
                        <div class="flex-1">
                            <label for="unidade_setor" class="block text-sm font-medium text-gray-700">
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
                            <button type="button" @click="saveField('unidade_setor')" x-show="!confirmed.unidade_setor"
                                :disabled="!unidade_setor" class="px-3 py-2 text-white transition rounded-lg"
                                :class="!unidade_setor ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-600'">
                                ✔
                            </button>
                            <button type="button" @click="toggleConfirm('unidade_setor')" x-show="confirmed.unidade_setor"
                                class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                ✖
                            </button>
                        </div>
                    </div>

                    <!-- Servidor Responsável -->
                    <div class="flex items-start mb-4 space-x-2">
                        <div class="flex-1">
                            <label for="servidor_responsavel" class="block text-sm font-medium text-gray-700">
                                Servidor Responsável
                            </label>
                            <select id="servidor_responsavel" x-model="servidor_responsavel"
                                :disabled="confirmed.servidor_responsavel"
                                class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                <option value="">Selecione um servidor</option>
                                @foreach ($processo->prefeitura->unidades as $unidade)
                                    @if ($unidade->servidor_responsavel)
                                        <option value="{{ $unidade->servidor_responsavel }}"
                                            {{ ($processo->detalhe->servidor_responsavel ?? '') == $unidade->servidor_responsavel ? 'selected' : '' }}>
                                            {{ $unidade->servidor_responsavel }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="flex pt-6 space-x-1">
                            <button type="button" @click="saveField('servidor_responsavel')"
                                x-show="!confirmed.servidor_responsavel" :disabled="!servidor_responsavel"
                                class="px-3 py-2 text-white transition rounded-lg"
                                :class="!servidor_responsavel ? 'bg-gray-400 cursor-not-allowed' :
                                    'bg-green-500 hover:bg-green-600'">
                                ✔
                            </button>
                            <button type="button" @click="toggleConfirm('servidor_responsavel')"
                                x-show="confirmed.servidor_responsavel"
                                class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                ✖
                            </button>
                        </div>
                    </div>

                    <x-form-field name="demanda" label="Demanda" type="textarea" />
                    <x-form-field name="justificativa" label="Justificativa da Necessidade da Contratação"
                        type="textarea" />
                    <x-form-field name="prazo_entrega" label="Prazo de Entrega / Execução" />
                    <x-form-field name="local_entrega" label="Local(is) e Horário(s) de Entrega" />

                    <!-- Contratações Anteriores -->
                    <div class="flex items-start mb-4 space-x-2">
                        <div class="flex-1">
                            <span class="block text-sm font-medium text-gray-700">Houve contratações anteriores?</span>
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

                    <x-form-field name="fiscais" label="Fiscal(is) Indicado(s)" />
                    <x-form-field name="gestor" label="Gestor Indicado" />

                    <!-- Instrumento Vinculativo -->
                    <div class="mb-4">
                        <span class="block text-sm font-medium text-gray-700">Instrumento Vinculativo</span>
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
                                    <input type="checkbox" value="{{ $value }}" x-model="instrumento_vinculativo"
                                        :disabled="confirmed.instrumento_vinculativo"
                                        :checked="instrumento_vinculativo.includes('{{ $value }}')">
                                    <span class="ml-2">{{ $label }}</span>
                                    @if ($value === 'outro')
                                        <input type="text" x-show="instrumento_vinculativo.includes('outro')"
                                            x-model="instrumento_vinculativo_outro"
                                            :disabled="confirmed.instrumento_vinculativo"
                                            class="ml-2 border-gray-300 rounded-lg shadow-sm">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="flex mt-2 space-x-1">
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
                    <div class="mb-4">
                        <span class="block text-sm font-medium text-gray-700">Prazo de Vigência do Objeto</span>
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
                                    <span class="ml-2">{{ $label }}</span>
                                    @if ($value === 'outro')
                                        <input type="text" x-show="prazo_vigencia.includes('outro')"
                                            x-model="prazo_vigencia_outro" :disabled="confirmed.prazo_vigencia"
                                            class="ml-2 border-gray-300 rounded-lg shadow-sm">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="flex mt-2 space-x-1">
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
                    <div class="flex items-start mb-4 space-x-2">
                        <div class="flex-1">
                            <span class="block text-sm font-medium text-gray-700">Objeto Continuado?</span>
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

                    <div class="flex justify-end mt-6 space-x-3">
                        <a href="{{ route('admin.processos.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-[#009496] rounded-lg hover:bg-[#007a7a]">
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

                // Alterna o estado de confirmação E TENTA SALVAR
                toggleConfirm(field) {
                    // Se está desconfirmado (false) e vai confirmar (true), chama o saveField
                    if (!this.confirmed[field]) {
                        this.saveField(field);
                    } else {
                        // Se vai desconfirmar, apenas altera o estado
                        this.confirmed[field] = false;
                    }
                },

                async saveField(field) {
                    const formData = new FormData();
                    const value = this[field];

                    // Garante o processo_id
                    formData.append('processo_id', {{ $processo->id }});
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content'));

                    // Tratamento de arrays
                    if (Array.isArray(value)) {
                        // Se o array está vazio, enviamos uma string vazia para que o Laravel entenda
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

                        if (response.ok) {
                            this.confirmed[field] = true;
                            console.log(field + ' salvo com sucesso!');
                            // Opcional: Remover o alert para uma UX melhor
                            // alert(field + ' salvo com sucesso!');
                        } else {
                            // Se falhou, a gente não confirma.
                            this.confirmed[field] = false;
                            const errorData = await response.json();
                            console.error('Erro ao salvar campo:', field, errorData);
                            alert('Erro ao salvar ' + field + '. Verifique o console.');
                        }
                    } catch (error) {
                        this.confirmed[field] = false;
                        console.error('Erro de rede ao salvar campo:', field, error);
                        alert('Erro de rede ao salvar ' + field + '.');
                    }
                }
            }
        }
    </script>

@endsection
