@extends('layouts.app')

@section('page-title', 'Iniciar processo ' . $processo->id)
@section('page-subtitle', 'Cadastrar/Editar detalhes do processo')

@section('content')
    {{-- OBSERVAÇÃO IMPORTANTE: Certifique-se de que o seu layout (layouts.app)
       inclua o Alpine.js e a tag meta para o CSRF Token no <head>:
       <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <div class="py-8">
        <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow rounded-2xl">

                <form action="{{ route('admin.processos.detalhes.store', $processo) }}" method="POST" x-data="formField({{ json_encode($processo->detalhe ?? null) }})">
                    @csrf

                    {{-- REMOVEMOS A DIRETIVA @check. A lógica de salvar/confirmar está no componente. --}}
                    <x-form-field name="secretaria" label="Secretaria" />
                    <div class="flex items-start mb-4 space-x-2">
                        <div class="flex-1">
                            <label for="unidade_setor" class="block text-sm font-medium text-gray-700">
                                Unidade / Setor / Departamento
                            </label>
                            <select id="unidade_setor" x-model="unidade_setor"
                                :disabled="confirmed.unidade_setor"
                                class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                <option value="">Selecione uma unidade</option>
                                @foreach($processo->prefeitura->unidades as $unidade)
                                    <option value="{{ $unidade->nome }}">{{ $unidade->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex pt-6 space-x-1">
                            <button type="button" @click="saveField('unidade_setor')"
                                x-show="!confirmed.unidade_setor"
                                :disabled="!unidade_setor"
                                class="px-3 py-2 text-white transition rounded-lg"
                                :class="!unidade_setor ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-600'">✔</button>
                            <button type="button" @click="toggleConfirm('unidade_setor')"
                                x-show="confirmed.unidade_setor"
                                class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">✖</button>
                        </div>
                    </div>

                    <div class="flex items-start mb-4 space-x-2">
                        <div class="flex-1">
                            <label for="servidor_responsavel" class="block text-sm font-medium text-gray-700">
                                Servidor Responsável
                            </label>
                            <select id="servidor_responsavel" x-model="servidor_responsavel"
                                :disabled="confirmed.servidor_responsavel"
                                class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                <option value="">Selecione um servidor</option>
                                {{-- Supondo que você tenha uma coleção de $servidores --}}
                                @foreach($processo->prefeitura->unidades as $unidade)
                                    <option value="{{ $unidade->servidor_responsavel }}">{{ $unidade->servidor_responsavel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex pt-6 space-x-1">
                            <button type="button" @click="saveField('servidor_responsavel')"
                                x-show="!confirmed.servidor_responsavel"
                                :disabled="!servidor_responsavel"
                                class="px-3 py-2 text-white transition rounded-lg"
                                :class="!servidor_responsavel ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-600'">✔</button>
                            <button type="button" @click="toggleConfirm('servidor_responsavel')"
                                x-show="confirmed.servidor_responsavel"
                                class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">✖</button>
                        </div>
                    </div>
                    <x-form-field name="demanda" label="Demanda" type="textarea" />
                    <x-form-field name="justificativa" label="Justificativa da Necessidade da Contratação" type="textarea" />
                    <x-form-field name="prazo_entrega" label="Prazo de Entrega / Execução" />
                    <x-form-field name="local_entrega" label="Local(is) e Horário(s) de Entrega" />

                    <div class="flex items-start mb-4 space-x-2">
                        <div class="flex-1">
                            <span class="block text-sm font-medium text-gray-700">Houve contratações anteriores?</span>
                            <div class="flex mt-1 space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" x-model="contratacoes_anteriores" value="sim"
                                        :disabled="confirmed.contratacoes_anteriores">
                                    <span class="ml-2">Sim</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" x-model="contratacoes_anteriores" value="nao"
                                        :disabled="confirmed.contratacoes_anteriores">
                                    <span class="ml-2">Não</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex pt-6 space-x-1">
                            <button type="button" @click="saveField('contratacoes_anteriores')"
                                x-show="!confirmed.contratacoes_anteriores"
                                class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">✔</button>
                            <button type="button" @click="toggleConfirm('contratacoes_anteriores')"
                                x-show="confirmed.contratacoes_anteriores"
                                class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">✖</button>
                        </div>
                    </div>

                    <x-form-field name="fiscais" label="Fiscal(is) Indicado(s)" />
                    <x-form-field name="gestor" label="Gestor Indicado" />

                    <div class="mb-4">
                        <span class="block text-sm font-medium text-gray-700">Instrumento Vinculativo</span>
                        <div class="mt-2 space-y-2">
                            <template x-for="item in ['contrato','ata_registro_precos','outro']" :key="item">
                                <div class="flex items-center">
                                    <input type="checkbox" :value="item" x-model="instrumento_vinculativo"
                                        :disabled="confirmed.instrumento_vinculativo">
                                    <span
                                        x-text="item==='contrato' ? 'Contrato' : item==='ata_registro_precos' ? 'Ata de Registro de Preços' : 'Outro'"
                                        class="ml-2"></span>
                                    <input type="text" x-show="item==='outro'" x-model="instrumento_vinculativo_outro"
                                        :disabled="confirmed.instrumento_vinculativo"
                                        class="ml-2 border-gray-300 rounded-lg shadow-sm">
                                </div>
                            </template>
                        </div>
                        <div class="flex mt-2 space-x-1">
                            <button type="button" @click="saveField('instrumento_vinculativo')"
                                x-show="!confirmed.instrumento_vinculativo"
                                class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">✔</button>
                            <button type="button" @click="toggleConfirm('instrumento_vinculativo')"
                                x-show="confirmed.instrumento_vinculativo"
                                class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">✖</button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="block text-sm font-medium text-gray-700">Prazo de Vigência do Objeto</span>
                        <div class="mt-2 space-y-2">
                            <template x-for="item in ['exercicio_financeiro','12_meses','outro']" :key="item">
                                <div class="flex items-center">
                                    <input type="checkbox" :value="item" x-model="prazo_vigencia"
                                        :disabled="confirmed.prazo_vigencia">
                                    <span
                                        x-text="item==='exercicio_financeiro' ? 'Exercício financeiro da contratação (até 31/12)' : item==='12_meses' ? 'Vigência de 12 meses' : 'Outro'"
                                        class="ml-2"></span>
                                    <input type="text" x-show="item==='outro'" x-model="prazo_vigencia_outro"
                                        :disabled="confirmed.prazo_vigencia"
                                        class="ml-2 border-gray-300 rounded-lg shadow-sm">
                                </div>
                            </template>
                        </div>
                        <div class="flex mt-2 space-x-1">
                            <button type="button" @click="saveField('prazo_vigencia')" x-show="!confirmed.prazo_vigencia"
                                class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">✔</button>
                            <button type="button" @click="toggleConfirm('prazo_vigencia')"
                                x-show="confirmed.prazo_vigencia"
                                class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">✖</button>
                        </div>
                    </div>

                    <div class="flex items-start mb-4 space-x-2">
                        <div class="flex-1">
                            <span class="block text-sm font-medium text-gray-700">Objeto Continuado?</span>
                            <div class="flex mt-1 space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" x-model="objeto_continuado" value="sim"
                                        :disabled="confirmed.objeto_continuado">
                                    <span class="ml-2">Sim</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" x-model="objeto_continuado" value="nao"
                                        :disabled="confirmed.objeto_continuado">
                                    <span class="ml-2">Não</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex pt-6 space-x-1">
                            <button type="button" @click="saveField('objeto_continuado')"
                                x-show="!confirmed.objeto_continuado"
                                class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">✔</button>
                            <button type="button" @click="toggleConfirm('objeto_continuado')"
                                x-show="confirmed.objeto_continuado"
                                class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">✖</button>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 space-x-3">
                        <a href="{{ route('admin.processos.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Cancelar</a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-[#009496] rounded-lg hover:bg-[#007a7a]">Salvar
                            tudo</button>
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
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

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
