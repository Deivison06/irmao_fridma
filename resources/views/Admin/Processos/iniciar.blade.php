@extends('layouts.app')

@section('page-title', 'Iniciar processo ' . $processo->id)
@section('page-subtitle', 'Cadastrar/Editar detalhes do processo')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>

    {{-- JSON com as unidades para o JS --}}
    @php
        $unidadesData = $processo->prefeitura->unidades->map(function ($unidade) {
            return [
                'id' => $unidade->id,
                'nome' => $unidade->nome,
                'servidor_responsavel' => $unidade->servidor_responsavel,
            ];
        });
    @endphp
    <script>
        const unidadesAssinantes = @json($unidadesData);
    </script>
    {{-- Fim JSON --}}

    <div class="py-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

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
                                    <th
                                        class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Tipo Contratação
                                    </th>
                                    <th
                                        class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Tipo Procedimento
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
                                    <td class="px-6 py-4 font-mono text-sm text-gray-900">
                                        {{ $processo->tipo_contratacao_nome }}
                                    </td>
                                    <td class="px-6 py-4 font-mono text-sm text-gray-900">
                                        {{ $processo->tipo_procedimento_nome }}
                                    </td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td colspan="6" class="px-6 py-4 text-sm text-gray-700">
                                        <strong>Objeto:</strong> {{ $processo->objeto }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

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
                    <div class="overflow-x-auto rounded-lg shadow-sm">
                        <!-- Área de Mensagens -->
                        <div id="message-container" class="p-4"></div>

                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">
                                        Documentos
                                    </th>
                                    <th
                                        class="w-40 px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase">
                                        Data
                                    </th>
                                    <th
                                        class="w-48 px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $documentos = [
                                        'capa' => [
                                            'titulo' => 'Capa do documento',
                                            'cor' => 'bg-red-500',
                                            'data_id' => 'data_capa',
                                            'campos' => [],
                                        ],
                                        'formalizacao' => [
                                            'titulo' => 'DOCUMENTO DE FORMALIZAÇÃO DE DEMANDA',
                                            'cor' => 'bg-blue-500',
                                            'data_id' => 'data_formalizacao',
                                            'campos' => [
                                                'secretaria',
                                                'unidade_setor',
                                                'servidor_responsavel',
                                                'demanda',
                                                'justificativa',
                                                'prazo_entrega',
                                                'local_entrega',
                                                'contratacoes_anteriores',
                                                'instrumento_vinculativo',
                                                'instrumento_vinculativo_outro',
                                                'prazo_vigencia',
                                                'prazo_vigencia_outro',
                                                'objeto_continuado',
                                                'descricao_necessidade_autorizacao',
                                                'responsavel_equipe_planejamento',
                                            ],
                                        ],
                                        'estudo_tecnico' => [
                                            'titulo' => 'INSTRUMENTOS DE PLANEJAMENTO ETP E MAPA DE RISCOS',
                                            'cor' => 'bg-purple-500',
                                            'data_id' => 'data_estudo_tecnico',
                                            'campos' => [
                                                'secretaria',
                                                'alinhamento_planejamento_anual',
                                                'responsavel_equipe_planejamento',
                                                'problema_resolvido',
                                                'justificativa',
                                                'descricao_necessidade',
                                                'inversao_fase',
                                                'solucoes_disponivel_mercado',
                                                'incluir_requisito_cada_caso_concreto',
                                                'solucao_escolhida',
                                                'justificativa_solucao_escolhida',
                                                'resultado_pretendidos',
                                                'impacto_ambiental',
                                                'tipo_srp',
                                                'prevista_plano_anual',
                                                'encaminhamento_pesquisa_preco',
                                                'encaminhamento_doacao_orcamentaria',
                                                'itens_e_seus_quantitativos_xml',
                                            ],
                                        ],
                                        'analise_mercado' => [
                                            'titulo' => 'ANÁLISE DE MERCADO (PESQUISA DE PRECOS)',
                                            'cor' => 'bg-green-500',
                                            'data_id' => 'data_analise_mercado',
                                            'campos' => ['secretaria'],
                                        ],
                                        'disponibilidade_orçamento' => [
                                            'titulo' => 'DISPONIBILIDADE ORÇAMENTÁRIA',
                                            'cor' => 'bg-yellow-500',
                                            'data_id' => 'data_disponibilidade_orçamento',
                                            'campos' => ['secretaria'],
                                        ],
                                        'termo_referencia' => [
                                            'titulo' => 'TERMO DE REFERÊNCIA',
                                            'cor' => 'bg-orange-500',
                                            'data_id' => 'data_termo_referencia',
                                            'campos' => ['secretaria'],
                                        ],
                                        'minutas' => [
                                            'titulo' => 'MINUTAS',
                                            'cor' => 'bg-pink-500',
                                            'data_id' => 'data_minutas',
                                            'campos' => ['secretaria'],
                                        ],
                                        'parecer_juridico' => [
                                            'titulo' => 'PARECER JURÍDICO',
                                            'cor' => 'bg-emerald-500',
                                            'data_id' => 'data_parecer_juridico',
                                            'campos' => ['secretaria'],
                                        ],
                                        'autorizacao_abertura_procedimento' => [
                                            'titulo' => 'AUTORIZAÇÃO ABERTURA PROCEDIMENTO LICITATÓRIO',
                                            'cor' => 'bg-teal-500',
                                            'data_id' => 'data_autorizacao_abertura_procedimento',
                                            'campos' => ['secretaria'],
                                        ],
                                        'abertura_fase_externa' => [
                                            'titulo' => 'ABERTURA FASE EXTERNA',
                                            'cor' => 'bg-cyan-500',
                                            'data_id' => 'data_abertura_fase_externa',
                                            'campos' => ['secretaria'],
                                        ],
                                        'publicacoes_avisos_licitacao' => [
                                            'titulo' => 'PUBLICAÇÕES DOS AVISOS DE LICITAÇÃO',
                                            'cor' => 'bg-indigo-500',
                                            'data_id' => 'data_publicacoes_avisos_licitacao',
                                            'campos' => ['secretaria'],
                                        ],
                                    ];
                                @endphp

                                @foreach ($documentos as $tipo => $doc)
                                    @php
                                        $documentoGerado = $processo->documentos
                                            ->where('tipo_documento', $tipo)
                                            ->first();
                                        $accordionId = "accordion-collapse-{$tipo}";
                                    @endphp

                                    {{-- Linha principal do documento --}}
                                    <tr class="transition-colors duration-150 hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-2 h-2 mr-3 {{ $doc['cor'] }} rounded-full">
                                                </div>
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $doc['titulo'] }}
                                                    @if ($documentoGerado)
                                                        <span class="ml-2 text-xs font-normal text-green-600">
                                                            ✓ Gerado em
                                                            {{ \Carbon\Carbon::parse($documentoGerado->gerado_em)->format('d/m/Y H:i') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- Botão para expandir/colapsar o acordeão --}}
                                            @if (!empty($doc['campos']))
                                                <button type="button"
                                                    class="mt-2 text-xs font-medium text-red-600 hover:text-red-800"
                                                    data-collapse-toggle="{{ $accordionId }}" aria-expanded="false"
                                                    aria-controls="{{ $accordionId }}">
                                                    <span class="collapse-text">Definir Campos e Assinantes</span>
                                                </button>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <input type="date"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                                id="{{ $doc['data_id'] }}"
                                                value="{{ $documentoGerado->data_selecionada ?? '' }}">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center space-x-2">
                                                <button type="button"
                                                    onclick="gerarPdf('{{ $processo->id }}', '{{ $tipo }}', document.getElementById('{{ $doc['data_id'] }}').value, event)"
                                                    class="px-4 py-2 text-xs font-medium text-white transition-colors duration-200 bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                    Gerar PDF
                                                </button>
                                                @if ($documentoGerado)
                                                    <a href="{{ route('admin.processo.documento.dowload', ['processo' => $processo->id, 'tipo' => $tipo]) }}"
                                                        download
                                                        class="p-2 text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                                        aria-label="Baixar documento">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                            <polyline points="7 10 12 15 17 10"></polyline>
                                                            <line x1="12" y1="15" x2="12"
                                                                y2="3"></line>
                                                        </svg>
                                                    </a>
                                                @else
                                                    <span
                                                        class="p-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed"
                                                        aria-hidden="true" title="Aguardando geração">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                            <polyline points="7 10 12 15 17 10"></polyline>
                                                            <line x1="12" y1="15" x2="12"
                                                                y2="3"></line>
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Linha do Acordeão (Collapse) - Apenas se tiver campos --}}
                                    @if (!empty($doc['campos']))
                                        <tr>
                                            <td colspan="3" class="p-0">
                                                <div id="{{ $accordionId }}" class="hidden">
                                                    <div class="p-4 border-t border-gray-200 bg-gray-50"
                                                        id="accordion-content-{{ $tipo }}">

                                                        <!-- Seção de Assinantes -->
                                                        <div class="pb-4 mb-6 border-b border-gray-200">
                                                            <h4 class="mb-3 text-sm font-semibold text-gray-700">Seleção de
                                                                Assinantes</h4>

                                                            <div id="assinantes-container-{{ $tipo }}">
                                                                <div class="flex items-center mb-3 space-x-2">
                                                                    {{-- Select da Unidade --}}
                                                                    <div class="flex-1">
                                                                        <label class="sr-only">Unidade</label>
                                                                        <select name="assinante_unidade[]"
                                                                            class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm unidade-select"
                                                                            onchange="updateResponsavel(this, '{{ $tipo }}')">
                                                                            <option value="">Selecione a Unidade
                                                                            </option>
                                                                            @foreach ($processo->prefeitura->unidades as $unidade)
                                                                                <option value="{{ $unidade->id }}">
                                                                                    {{ $unidade->nome }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    {{-- Input do Responsável --}}
                                                                    <div class="flex-1">
                                                                        <label class="sr-only">Responsável</label>
                                                                        <input type="text"
                                                                            name="assinante_responsavel[]"
                                                                            placeholder="Nome do Responsável" readonly
                                                                            class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm sm:text-sm responsavel-input">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <button type="button"
                                                                onclick="adicionarAssinante('{{ $tipo }}')"
                                                                class="px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                                + Adicionar Assinante
                                                            </button>
                                                        </div>

                                                        <!-- Seção de Campos do Formulário -->
                                                        <div>
                                                            <h4 class="mb-3 text-sm font-semibold text-gray-700">Campos do
                                                                Documento</h4>
                                                            <form
                                                                action="{{ route('admin.processos.detalhes.store', $processo) }}"
                                                                method="POST" x-data="formField({{ json_encode($processo->detalhe ?? null) }})"
                                                                @submit.prevent="submitForm">
                                                                @csrf
                                                                <input type="hidden" name="processo_id"
                                                                    value="{{ $processo->id }}">

                                                                @foreach ($doc['campos'] as $campo)
                                                                    <div
                                                                        class="p-3 mb-3 bg-white border border-gray-200 rounded-lg">
                                                                        @if ($campo === 'secretaria')
                                                                            <x-form-field name="secretaria"
                                                                                label="Secretaria" />
                                                                        @elseif($campo === 'unidade_setor')
                                                                            <div class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <label for="unidade_setor"
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">
                                                                                        Unidade / Setor / Departamento
                                                                                    </label>
                                                                                    <select id="unidade_setor"
                                                                                        x-model="unidade_setor"
                                                                                        @change="onUnidadeChange"
                                                                                        :disabled="confirmed.unidade_setor"
                                                                                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                                                                        <option value="">Selecione
                                                                                            uma unidade</option>
                                                                                        @foreach ($processo->prefeitura->unidades as $unidade)
                                                                                            <option
                                                                                                value="{{ $unidade->nome }}"
                                                                                                data-responsavel="{{ $unidade->servidor_responsavel }}"
                                                                                                {{ ($processo->detalhe->unidade_setor ?? '') == $unidade->nome ? 'selected' : '' }}>
                                                                                                {{ $unidade->nome }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('unidade_setor')"
                                                                                        x-show="!confirmed.unidade_setor"
                                                                                        :disabled="!unidade_setor"
                                                                                        class="px-3 py-2 text-white transition rounded-lg"
                                                                                        :class="!unidade_setor ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('unidade_setor')"
                                                                                        x-show="confirmed.unidade_setor"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'servidor_responsavel')
                                                                            <div class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <label for="servidor_responsavel"
                                                                                        class="block text-sm font-medium text-gray-700">
                                                                                        Servidor Responsável
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        id="servidor_responsavel"
                                                                                        x-model="servidor_responsavel"
                                                                                        value="{{ $processo->detalhe->servidor_responsavel ?? '' }}"
                                                                                        readonly
                                                                                        class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-lg shadow-sm sm:text-sm">
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'demanda')
                                                                            <x-form-field name="demanda" label="Demanda"
                                                                                type="textarea" />
                                                                        @elseif($campo === 'justificativa')
                                                                            <x-form-field name="justificativa"
                                                                                label="Justificativa da Necessidade da Contratação"
                                                                                type="textarea" />
                                                                        @elseif($campo === 'descricao_necessidade')
                                                                            <x-form-field name="descricao_necessidade"
                                                                                label="DESCRIÇÃO DA NECESSIDADE"
                                                                                type="textarea" />
                                                                        @elseif($campo === 'descricao_necessidade_autorizacao')
                                                                            <x-form-field
                                                                                name="descricao_necessidade_autorizacao"
                                                                                label="DESCRIÇÃO DA NECESSIDADE DE AUTORIZAÇÃO"
                                                                                type="textarea" />
                                                                        @elseif($campo === 'incluir_requisito_cada_caso_concreto')
                                                                            <x-form-field
                                                                                name="incluir_requisito_cada_caso_concreto"
                                                                                label="REQUISITOS REFERENTES A CADA CASO CONCRETO"
                                                                                type="textarea" />
                                                                        @elseif($campo === 'solucoes_disponivel_mercado')
                                                                            <x-form-field
                                                                                name="solucoes_disponivel_mercado"
                                                                                label="SOLUÇÕES DISPONÍVEIS NO MERCADO"
                                                                                type="textarea" />
                                                                        @elseif($campo === 'solucao_escolhida')
                                                                            <x-form-field name="solucao_escolhida"
                                                                                label="SOLUÇÃO ESCOLHIDA" />
                                                                        @elseif($campo === 'justificativa_solucao_escolhida')
                                                                            <x-form-field
                                                                                name="justificativa_solucao_escolhida"
                                                                                label="JUSTIFICATIVA DA SOLUÇÃO ESCOLHIDA"
                                                                                type="textarea" />
                                                                        @elseif($campo === 'resultado_pretendidos')
                                                                            <x-form-field name="resultado_pretendidos"
                                                                                label="RESULTADOS PRETENDIDOS"
                                                                                type="textarea" />
                                                                        @elseif($campo === 'impacto_ambiental')
                                                                            <x-form-field name="impacto_ambiental"
                                                                                label="IMPACTOS AMBIENTAIS"
                                                                                type="textarea" />
                                                                        @elseif($campo === 'tipo_srp')
                                                                            <div
                                                                                class="flex items-start pt-4 space-x-2 border-t border-gray-200">
                                                                                <div class="flex-1">
                                                                                    <span
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">Esse
                                                                                        Processo é do tipo SRP?</span>
                                                                                    <div class="flex mt-1 space-x-4">
                                                                                        <label
                                                                                            class="inline-flex items-center">
                                                                                            <input type="radio"
                                                                                                x-model="tipo_srp"
                                                                                                value="sim"
                                                                                                :disabled="confirmed.tipo_srp"
                                                                                                :checked="tipo_srp === 'sim'">
                                                                                            <span class="ml-2">Sim</span>
                                                                                        </label>
                                                                                        <label
                                                                                            class="inline-flex items-center">
                                                                                            <input type="radio"
                                                                                                x-model="tipo_srp"
                                                                                                value="nao"
                                                                                                :disabled="confirmed.tipo_srp"
                                                                                                :checked="tipo_srp === 'nao'">
                                                                                            <span class="ml-2">Não</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('tipo_srp')"
                                                                                        x-show="!confirmed.tipo_srp"
                                                                                        class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('tipo_srp')"
                                                                                        x-show="confirmed.tipo_srp"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'prevista_plano_anual')
                                                                            <div
                                                                                class="flex items-start pt-4 space-x-2 border-t border-gray-200">
                                                                                <div class="flex-1">
                                                                                    <span
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">
                                                                                        A CONTRATAÇÃO ESTÁ PREVISTA NO PLANO
                                                                                        DE CONTRATAÇÃO ANUAL?
                                                                                    </span>
                                                                                    <div class="flex mt-1 space-x-4">
                                                                                        <label
                                                                                            class="inline-flex items-center">
                                                                                            <input type="radio"
                                                                                                x-model="prevista_plano_anual"
                                                                                                value="sim"
                                                                                                :disabled="confirmed
                                                                                                    .prevista_plano_anual"
                                                                                                :checked="prevista_plano_anual === 'sim'">
                                                                                            <span class="ml-2">Sim</span>
                                                                                        </label>
                                                                                        <label
                                                                                            class="inline-flex items-center">
                                                                                            <input type="radio"
                                                                                                x-model="prevista_plano_anual"
                                                                                                value="nao"
                                                                                                :disabled="confirmed
                                                                                                    .prevista_plano_anual"
                                                                                                :checked="prevista_plano_anual === 'nao'">
                                                                                            <span class="ml-2">Não</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('prevista_plano_anual')"
                                                                                        x-show="!confirmed.prevista_plano_anual"
                                                                                        class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('prevista_plano_anual')"
                                                                                        x-show="confirmed.prevista_plano_anual"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'encaminhamento_pesquisa_preco')
                                                                            <div class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <label
                                                                                        for="encaminhamento_pesquisa_preco"
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">
                                                                                        Encaminhamento para pesquisa de
                                                                                        Preços
                                                                                    </label>
                                                                                    <select
                                                                                        id="encaminhamento_pesquisa_preco"
                                                                                        x-model="encaminhamento_pesquisa_preco"
                                                                                        @change="onUnidadeChange"
                                                                                        :disabled="confirmed
                                                                                            .encaminhamento_pesquisa_preco"
                                                                                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                                                                        <option value="">Selecione
                                                                                            uma unidade</option>
                                                                                        @foreach ($processo->prefeitura->unidades as $unidade)
                                                                                            <option
                                                                                                value="{{ $unidade->nome }}"
                                                                                                data-responsavel="{{ $unidade->servidor_responsavel }}"
                                                                                                {{ ($processo->detalhe->encaminhamento_pesquisa_preco ?? '') == $unidade->nome ? 'selected' : '' }}>
                                                                                                {{ $unidade->nome }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('encaminhamento_pesquisa_preco')"
                                                                                        x-show="!confirmed.encaminhamento_pesquisa_preco"
                                                                                        :disabled="!encaminhamento_pesquisa_preco"
                                                                                        class="px-3 py-2 text-white transition rounded-lg"
                                                                                        :class="!encaminhamento_pesquisa_preco ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('encaminhamento_pesquisa_preco')"
                                                                                        x-show="confirmed.encaminhamento_pesquisa_preco"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'encaminhamento_doacao_orcamentaria')
                                                                            <div class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <label
                                                                                        for="encaminhamento_doacao_orcamentaria"
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">
                                                                                        Encaminhamento para doação
                                                                                        orçamentária
                                                                                    </label>
                                                                                    <select
                                                                                        id="encaminhamento_doacao_orcamentaria"
                                                                                        x-model="encaminhamento_doacao_orcamentaria"
                                                                                        :disabled="confirmed
                                                                                            .encaminhamento_doacao_orcamentaria"
                                                                                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                                                                        <option value="">Selecione
                                                                                            uma unidade</option>
                                                                                        @foreach ($processo->prefeitura->unidades as $unidade)
                                                                                            <option
                                                                                                value="{{ $unidade->nome }}"
                                                                                                {{ ($processo->detalhe->encaminhamento_doacao_orcamentaria ?? '') == $unidade->nome ? 'selected' : '' }}>
                                                                                                {{ $unidade->nome }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('encaminhamento_doacao_orcamentaria')"
                                                                                        x-show="!confirmed.encaminhamento_doacao_orcamentaria"
                                                                                        :disabled="!
                                                                                        encaminhamento_doacao_orcamentaria"
                                                                                        class="px-3 py-2 text-white transition rounded-lg"
                                                                                        :class="!
                                                                                        encaminhamento_doacao_orcamentaria
                                                                                            ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('encaminhamento_doacao_orcamentaria')"
                                                                                        x-show="confirmed.encaminhamento_doacao_orcamentaria"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'problema_resolvido')
                                                                            <x-form-field name="problema_resolvido"
                                                                                label="Problema Resumido" />
                                                                        @elseif($campo === 'alinhamento_planejamento_anual')
                                                                            <x-form-field
                                                                                name="alinhamento_planejamento_anual"
                                                                                label="Alinhamento com o Planejamento Anual" />
                                                                        @elseif($campo === 'nome_equipe_planejamento')
                                                                            <x-form-field name="nome_equipe_planejamento"
                                                                                label="EQUIPE DE PLANEJAMENTO" />
                                                                        @elseif($campo === 'responsavel_equipe_planejamento')
                                                                            <x-form-field
                                                                                name="responsavel_equipe_planejamento"
                                                                                label="RESPONSAVEL EQUIPE DE PLANEJAMENTO" />
                                                                        @elseif($campo === 'prazo_entrega')
                                                                            <x-form-field name="prazo_entrega"
                                                                                label="Prazo de Entrega / Execução" />
                                                                        @elseif($campo === 'local_entrega')
                                                                            <x-form-field name="local_entrega"
                                                                                label="Local(is) e Horário(s) de Entrega" />
                                                                        @elseif($campo === 'fiscais')
                                                                            <x-form-field name="fiscais"
                                                                                label="Fiscal(is) Indicado(s)" />
                                                                        @elseif($campo === 'gestor')
                                                                            <x-form-field name="gestor"
                                                                                label="Gestor Indicado" />
                                                                        @elseif($campo === 'contratacoes_anteriores')
                                                                            <div
                                                                                class="flex items-start pt-4 space-x-2 border-t border-gray-200">
                                                                                <div class="flex-1">
                                                                                    <span
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">Houve
                                                                                        contratações anteriores?</span>
                                                                                    <div class="flex mt-1 space-x-4">
                                                                                        <label
                                                                                            class="inline-flex items-center">
                                                                                            <input type="radio"
                                                                                                x-model="contratacoes_anteriores"
                                                                                                value="sim"
                                                                                                :disabled="confirmed
                                                                                                    .contratacoes_anteriores"
                                                                                                :checked="contratacoes_anteriores === 'sim'">
                                                                                            <span class="ml-2">Sim</span>
                                                                                        </label>
                                                                                        <label
                                                                                            class="inline-flex items-center">
                                                                                            <input type="radio"
                                                                                                x-model="contratacoes_anteriores"
                                                                                                value="nao"
                                                                                                :disabled="confirmed
                                                                                                    .contratacoes_anteriores"
                                                                                                :checked="contratacoes_anteriores === 'nao'">
                                                                                            <span class="ml-2">Não</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('contratacoes_anteriores')"
                                                                                        x-show="!confirmed.contratacoes_anteriores"
                                                                                        class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('contratacoes_anteriores')"
                                                                                        x-show="confirmed.contratacoes_anteriores"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'objeto_continuado')
                                                                            <div
                                                                                class="flex items-start pt-4 space-x-2 border-t border-gray-200">
                                                                                <div class="flex-1">
                                                                                    <span
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">Objeto
                                                                                        Continuado?</span>
                                                                                    <div class="flex mt-1 space-x-4">
                                                                                        <label
                                                                                            class="inline-flex items-center">
                                                                                            <input type="radio"
                                                                                                x-model="objeto_continuado"
                                                                                                value="sim"
                                                                                                :disabled="confirmed
                                                                                                    .objeto_continuado"
                                                                                                :checked="objeto_continuado === 'sim'">
                                                                                            <span class="ml-2">Sim</span>
                                                                                        </label>
                                                                                        <label
                                                                                            class="inline-flex items-center">
                                                                                            <input type="radio"
                                                                                                x-model="objeto_continuado"
                                                                                                value="nao"
                                                                                                :disabled="confirmed
                                                                                                    .objeto_continuado"
                                                                                                :checked="objeto_continuado === 'nao'">
                                                                                            <span class="ml-2">Não</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('objeto_continuado')"
                                                                                        x-show="!confirmed.objeto_continuado"
                                                                                        class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('objeto_continuado')"
                                                                                        x-show="confirmed.objeto_continuado"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'inversao_fase')
                                                                            <div
                                                                                class="flex items-start pt-4 space-x-2 border-t border-gray-200">
                                                                                <div class="flex-1">
                                                                                    <span
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">Documento
                                                                                        contém inversão de fase?</span>
                                                                                    <div class="flex mt-1 space-x-4">
                                                                                        <label
                                                                                            class="inline-flex items-center">
                                                                                            <input type="radio"
                                                                                                x-model="inversao_fase"
                                                                                                value="sim"
                                                                                                :disabled="confirmed.inversao_fase"
                                                                                                :checked="inversao_fase === 'sim'">
                                                                                            <span class="ml-2">Sim</span>
                                                                                        </label>
                                                                                        <label
                                                                                            class="inline-flex items-center">
                                                                                            <input type="radio"
                                                                                                x-model="inversao_fase"
                                                                                                value="nao"
                                                                                                :disabled="confirmed.inversao_fase"
                                                                                                :checked="inversao_fase === 'nao'">
                                                                                            <span class="ml-2">Não</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('inversao_fase')"
                                                                                        x-show="!confirmed.inversao_fase"
                                                                                        class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('inversao_fase')"
                                                                                        x-show="confirmed.inversao_fase"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'instrumento_vinculativo')
                                                                            <div class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <span
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">Instrumento
                                                                                        Vinculativo</span>
                                                                                    <div class="mt-2 space-y-2">
                                                                                        @php
                                                                                            $instrumentos = [
                                                                                                'contrato' =>
                                                                                                    'Contrato',
                                                                                                'ata_registro_precos' =>
                                                                                                    'Ata de Registro de Preços',
                                                                                                'outro' => 'Outro',
                                                                                            ];
                                                                                        @endphp

                                                                                        @foreach ($instrumentos as $value => $label)
                                                                                            <div class="flex items-center">
                                                                                                <input type="checkbox"
                                                                                                    value="{{ $value }}"
                                                                                                    x-model="instrumento_vinculativo"
                                                                                                    :disabled="confirmed
                                                                                                        .instrumento_vinculativo"
                                                                                                    :checked="instrumento_vinculativo
                                                                                                        .includes(
                                                                                                            '{{ $value }}'
                                                                                                            )">
                                                                                                <span
                                                                                                    class="ml-2 text-sm">{{ $label }}</span>
                                                                                                @if ($value === 'outro')
                                                                                                    <input type="text"
                                                                                                        x-show="instrumento_vinculativo.includes('outro')"
                                                                                                        x-model="instrumento_vinculativo_outro"
                                                                                                        :disabled="confirmed
                                                                                                            .instrumento_vinculativo"
                                                                                                        class="w-32 px-2 py-1 ml-2 text-sm border-gray-300 rounded-lg shadow-sm">
                                                                                                @endif
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('instrumento_vinculativo')"
                                                                                        x-show="!confirmed.instrumento_vinculativo"
                                                                                        class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('instrumento_vinculativo')"
                                                                                        x-show="confirmed.instrumento_vinculativo"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'prazo_vigencia')
                                                                            <div class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <span
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">Prazo
                                                                                        de Vigência do Objeto</span>
                                                                                    <div class="mt-2 space-y-2">
                                                                                        @php
                                                                                            $prazos = [
                                                                                                'exercicio_financeiro' =>
                                                                                                    'Exercício financeiro da contratação (até 31/12)',
                                                                                                '12_meses' =>
                                                                                                    'Vigência de 12 meses',
                                                                                                'outro' => 'Outro',
                                                                                            ];
                                                                                        @endphp

                                                                                        @foreach ($prazos as $value => $label)
                                                                                            <div class="flex items-center">
                                                                                                <input type="checkbox"
                                                                                                    value="{{ $value }}"
                                                                                                    x-model="prazo_vigencia"
                                                                                                    :disabled="confirmed
                                                                                                        .prazo_vigencia"
                                                                                                    :checked="prazo_vigencia
                                                                                                        .includes(
                                                                                                            '{{ $value }}'
                                                                                                            )">
                                                                                                <span
                                                                                                    class="ml-2 text-sm">{{ $label }}</span>
                                                                                                @if ($value === 'outro')
                                                                                                    <input type="text"
                                                                                                        x-show="prazo_vigencia.includes('outro')"
                                                                                                        x-model="prazo_vigencia_outro"
                                                                                                        :disabled="confirmed
                                                                                                            .prazo_vigencia"
                                                                                                        class="w-32 px-2 py-1 ml-2 text-sm border-gray-300 rounded-lg shadow-sm">
                                                                                                @endif
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('prazo_vigencia')"
                                                                                        x-show="!confirmed.prazo_vigencia"
                                                                                        class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('prazo_vigencia')"
                                                                                        x-show="confirmed.prazo_vigencia"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'itens_e_seus_quantitativos_xml')
                                                                            <div class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <label
                                                                                        for="itens_e_seus_quantitativos_xml"
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">
                                                                                        ITENS E SEUS QUANTITATIVOS (XML /
                                                                                        Excel)
                                                                                    </label>
                                                                                    <input type="file"
                                                                                        id="itens_e_seus_quantitativos_xml"
                                                                                        name="itens_e_seus_quantitativos_xml"
                                                                                        accept=".xml, .xlsx, .xls, .csv"
                                                                                        class="block w-full mt-1 text-sm border-gray-300 rounded-lg shadow-sm cursor-pointer focus:ring-[#009496] focus:border-[#009496]">
                                                                                    <p class="mt-1 text-xs text-gray-500">
                                                                                        Selecione um arquivo XML ou Excel
                                                                                        contendo os itens da tabela.
                                                                                    </p>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('itens_e_seus_quantitativos_xml')"
                                                                                        x-show="!confirmed.itens_e_seus_quantitativos_xml"
                                                                                        class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('itens_e_seus_quantitativos_xml')"
                                                                                        x-show="confirmed.itens_e_seus_quantitativos_xml"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endforeach

                                                                <!-- Botões de Ação -->
                                                                <div
                                                                    class="flex justify-end pt-6 mt-6 space-x-3 border-t border-gray-200">
                                                                    <button type="submit"
                                                                        class="px-6 py-2 text-sm font-medium text-white bg-[#009496] rounded-lg hover:bg-[#007a7a] transition-colors duration-200">
                                                                        Salvar Campos deste Documento
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Botão para Baixar Todos os PDFs -->
                        <div class="flex justify-center p-4 mt-6 border-t border-gray-200 bg-gray-50">
                            <a href="{{ route('admin.processo.documento.dowload-all', ['processo' => $processo->id]) }}"
                                class="px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 bg-green-600 rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                📥 Baixar Todos os PDFs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inicialização do TinyMCE
        tinymce.init({
            selector: 'textarea',
            plugins: 'lists link table code charmap emoticons',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link table | emoticons charmap | code',
            menubar: false,
            branding: false,
            height: 300
        });

        // Inicialização da funcionalidade de acordeão
        document.querySelectorAll('[data-collapse-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-collapse-toggle');
                const targetEl = document.getElementById(targetId);
                const isExpanded = button.getAttribute('aria-expanded') === 'true';
                const span = button.querySelector('.collapse-text');

                if (isExpanded) {
                    targetEl.classList.add('hidden');
                    button.setAttribute('aria-expanded', 'false');
                    span.textContent = 'Definir Campos e Assinantes';
                } else {
                    targetEl.classList.remove('hidden');
                    button.setAttribute('aria-expanded', 'true');
                    span.textContent = 'Ocultar Campos e Assinantes';
                }
            });
        });

        // Funções para gerenciar assinantes
        function adicionarAssinante(tipoDocumento) {
            const container = document.getElementById(`assinantes-container-${tipoDocumento}`);
            const novoAssinante = document.createElement('div');
            novoAssinante.className = 'flex items-center mb-3 space-x-2';
            novoAssinante.innerHTML = `
                <div class="flex-1">
                    <label class="sr-only">Unidade</label>
                    <select name="assinante_unidade[]"
                            class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm unidade-select"
                            onchange="updateResponsavel(this, '${tipoDocumento}')">
                        <option value="">Selecione a Unidade</option>
                        @foreach ($processo->prefeitura->unidades as $unidade)
                            <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label class="sr-only">Responsável</label>
                    <input type="text" name="assinante_responsavel[]"
                           placeholder="Nome do Responsável" readonly
                           class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm sm:text-sm responsavel-input">
                </div>
                <button type="button" onclick="removerAssinante(this, '${tipoDocumento}')"
                        class="p-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                    🗑
                </button>
            `;
            container.appendChild(novoAssinante);
        }

        function removerAssinante(botao, tipoDocumento) {
            const container = document.getElementById(`assinantes-container-${tipoDocumento}`);
            const assinantes = container.querySelectorAll('.flex.items-center');
            if (assinantes.length > 1) {
                botao.closest('.flex.items-center').remove();
            }
        }

        function updateResponsavel(select, tipoDocumento) {
            const selectedUnidadeId = select.value;
            const selectedUnidade = unidadesAssinantes.find(u => u.id == selectedUnidadeId);
            const responsavelInput = select.closest('.flex.items-center').querySelector('.responsavel-input');

            if (responsavelInput && selectedUnidade) {
                responsavelInput.value = selectedUnidade.servidor_responsavel;
            } else if (responsavelInput) {
                responsavelInput.value = '';
            }
        }

        // Função auxiliar para obter os dados dos assinantes
        function getAssinantes(tipoDocumento) {
            const selects = document.querySelectorAll(
                `#accordion-content-${tipoDocumento} select[name="assinante_unidade[]"]`);
            const assinantes = [];
            selects.forEach(select => {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption.value) {
                    const unidade = unidadesAssinantes.find(u => u.id == select.value);
                    if (unidade) {
                        assinantes.push({
                            unidade_id: unidade.id,
                            unidade_nome: unidade.nome,
                            responsavel: unidade.servidor_responsavel
                        });
                    }
                }
            });
            return assinantes;
        }

        /**
         * Gera o PDF via AJAX
         */
        function gerarPdf(processoId, documento, data, event) {
            if (!data) {
                showMessage('Por favor, selecione uma data antes de gerar o PDF.', 'error');
                return;
            }

            const assinantes = getAssinantes(documento);
            const assinantesJson = JSON.stringify(assinantes);
            const assinantesEncoded = encodeURIComponent(assinantesJson);

            let url = `/admin/processos/${processoId}/pdf?documento=${documento}&data=${data}`;

            if (assinantes.length > 0) {
                url += `&assinantes=${assinantesEncoded}`;
            }

            const button = event.currentTarget;
            const originalText = button.textContent;

            button.textContent = 'Gerando...';
            button.disabled = true;

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage(data.message, 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        showMessage(data.message, 'error');
                    }
                })
                .catch(error => {
                    showMessage('Erro ao gerar PDF: ' + error, 'error');
                })
                .finally(() => {
                    button.textContent = originalText;
                    button.disabled = false;
                });
        }

        function showMessage(message, type) {
            const container = document.getElementById('message-container');
            const bgColor = type === 'success' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200';
            const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';

            container.innerHTML = `
                <div class="p-4 border rounded-md ${bgColor} ${textColor}">
                    <div class="flex items-center">
                        <span class="mr-2">${type === 'success' ? '✅' : '❌'}</span>
                        <span class="font-medium">${message}</span>
                    </div>
                </div>
            `;

            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);
        }

        // Alpine.js Component
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
                tipo_procedimento: existing?.tipo_procedimento ?? '',
                tipo_contratacao: existing?.tipo_contratacao ?? '',
                contratacoes_anteriores: existing?.contratacoes_anteriores ?? '',
                fiscais: existing?.fiscais ?? '',
                gestor: existing?.gestor ?? '',
                instrumento_vinculativo: existing?.instrumento_vinculativo ?? [],
                instrumento_vinculativo_outro: existing?.instrumento_vinculativo_outro ?? '',
                prazo_vigencia: existing?.prazo_vigencia ?? [],
                prazo_vigencia_outro: existing?.prazo_vigencia_outro ?? '',
                objeto_continuado: existing?.objeto_continuado ?? '',
                itens_e_seus_quantitativos_xml: existing?.itens_e_seus_quantitativos_xml ?? '',
                nome_equipe_planejamento: existing?.nome_equipe_planejamento ?? '',
                responsavel_equipe_planejamento: existing?.responsavel_equipe_planejamento ?? '',
                descricao_necessidade_autorizacao: existing?.descricao_necessidade_autorizacao ?? '',
                solucoes_disponivel_mercado: existing?.solucoes_disponivel_mercado ?? '',
                incluir_requisito_cada_caso_concreto: existing?.incluir_requisito_cada_caso_concreto ?? '',
                descricao_necessidade: existing?.descricao_necessidade ?? '',
                alinhamento_planejamento_anual: existing?.alinhamento_planejamento_anual ?? '',
                problema_resolvido: existing?.problema_resolvido ?? '',
                inversao_fase: existing?.inversao_fase ?? '',
                solucao_escolhida: existing?.solucao_escolhida ?? '',
                justificativa_solucao_escolhida: existing?.justificativa_solucao_escolhida ?? '',
                impacto_ambiental: existing?.impacto_ambiental ?? '',
                resultado_pretendidos: existing?.resultado_pretendidos ?? '',
                tipo_srp: existing?.tipo_srp ?? '',
                encaminhamento_pesquisa_preco: existing?.encaminhamento_pesquisa_preco ?? '',
                encaminhamento_doacao_orcamentaria: existing?.encaminhamento_doacao_orcamentaria ?? '',
                prevista_plano_anual: existing?.prevista_plano_anual ?? '',

                // Controle de confirmação
                confirmed: {
                    secretaria: !!existing?.secretaria,
                    unidade_setor: !!existing?.unidade_setor,
                    servidor_responsavel: !!existing?.servidor_responsavel,
                    tipo_procedimento: !!existing?.tipo_procedimento,
                    tipo_contratacao: !!existing?.tipo_contratacao,
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
                    itens_e_seus_quantitativos_xml: !!existing?.itens_e_seus_quantitativos_xml,
                    nome_equipe_planejamento: !!existing?.nome_equipe_planejamento,
                    responsavel_equipe_planejamento: !!existing?.responsavel_equipe_planejamento,
                    descricao_necessidade_autorizacao: !!existing?.descricao_necessidade_autorizacao,
                    solucoes_disponivel_mercado: !!existing?.solucoes_disponivel_mercado,
                    incluir_requisito_cada_caso_concreto: !!existing?.incluir_requisito_cada_caso_concreto,
                    descricao_necessidade: !!existing?.descricao_necessidade,
                    alinhamento_planejamento_anual: !!existing?.alinhamento_planejamento_anual,
                    problema_resolvido: !!existing?.problema_resolvido,
                    inversao_fase: !!existing?.inversao_fase,
                    solucao_escolhida: !!existing?.solucao_escolhida,
                    justificativa_solucao_escolhida: !!existing?.justificativa_solucao_escolhida,
                    impacto_ambiental: !!existing?.impacto_ambiental,
                    resultado_pretendidos: !!existing?.resultado_pretendidos,
                    tipo_srp: !!existing?.tipo_srp,
                    encaminhamento_pesquisa_preco: !!existing?.encaminhamento_pesquisa_preco,
                    encaminhamento_doacao_orcamentaria: !!existing?.encaminhamento_doacao_orcamentaria,
                    prevista_plano_anual: !!existing?.prevista_plano_anual,
                },

                onUnidadeChange() {
                    const selectElement = document.getElementById('unidade_setor');
                    const selectedOption = selectElement.options[selectElement.selectedIndex];

                    if (selectedOption && selectedOption.value) {
                        const servidorResponsavel = selectedOption.getAttribute('data-responsavel');
                        this.servidor_responsavel = servidorResponsavel || '';
                    } else {
                        this.servidor_responsavel = '';
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

                // Salva campo individual
                async saveField(field) {
                    const formData = new FormData();
                    formData.append('processo_id', {{ $processo->id }});
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content'));

                    // Quando salvar unidade_setor, também salva o servidor_responsavel
                    if (field === 'unidade_setor' && this.servidor_responsavel) {
                        formData.append('servidor_responsavel', this.servidor_responsavel);
                    }

                    // Campos do TinyMCE
                    const tinyMceFields = [
                        'demanda', 'justificativa', 'descricao_necessidade', 'descricao_necessidade_autorizacao',
                        'solucoes_disponivel_mercado', 'incluir_requisito_cada_caso_concreto',
                        'justificativa_solucao_escolhida', 'impacto_ambiental', 'resultado_pretendidos'
                    ];

                    if (tinyMceFields.includes(field)) {
                        const editor = tinymce.get(field);
                        const content = editor ? editor.getContent() : this[field];
                        formData.append(field, content);
                    }
                    // Arquivos
                    else if (field === 'itens_e_seus_quantitativos_xml') {
                        const fileInput = document.getElementById('itens_e_seus_quantitativos_xml');
                        if (fileInput && fileInput.files.length > 0) {
                            formData.append(field, fileInput.files[0]);
                        }
                    }
                    // Arrays
                    else if (Array.isArray(this[field])) {
                        if (this[field].length === 0) {
                            formData.append(field, '');
                        } else {
                            this[field].forEach(v => formData.append(field + '[]', v));
                        }

                        if (field === 'instrumento_vinculativo' && this.instrumento_vinculativo_outro) {
                            formData.append('instrumento_vinculativo_outro', this.instrumento_vinculativo_outro);
                        }
                        if (field === 'prazo_vigencia' && this.prazo_vigencia_outro) {
                            formData.append('prazo_vigencia_outro', this.prazo_vigencia_outro);
                        }
                    }
                    // Campos normais
                    else {
                        formData.append(field, this[field]);
                    }

                    try {
                        const response = await fetch("{{ route('admin.processos.detalhes.store', $processo) }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: formData
                        });

                        const responseData = await response.json();

                        if (response.ok) {
                            this.confirmed[field] = true;
                            if (field === 'unidade_setor' && this.servidor_responsavel) {
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

                // Submit do formulário completo
                submitForm() {
                    this.$el.submit();
                }
            }
        }
    </script>
@endsection
