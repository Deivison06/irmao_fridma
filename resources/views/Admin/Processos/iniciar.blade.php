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
                'numero_portaria' => $unidade->numero_portaria,
                'data_portaria' => $unidade->data_portaria,
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
                                        <strong>Objeto:</strong> {!! $processo->objeto !!}
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
                                                'alinhamento_planejamento_anual',
                                                'problema_resolvido',
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
                                            'campos' => ['secretaria', 'painel_preco_tce', 'anexo_pdf_analise_mercado'],
                                        ],
                                        'disponibilidade_orçamento' => [
                                            'titulo' => 'DISPONIBILIDADE ORÇAMENTÁRIA',
                                            'cor' => 'bg-yellow-500',
                                            'data_id' => 'data_disponibilidade_orçamento',
                                            'campos' => ['secretaria', 'dotacao_orcamentaria'],
                                        ],
                                        'termo_referencia' => [
                                            'titulo' => 'TERMO DE REFERÊNCIA',
                                            'cor' => 'bg-orange-500',
                                            'data_id' => 'data_termo_referencia',
                                            'campos' => [
                                                'secretaria',
                                                'encaminhamento_elaborar_editais',
                                                'encaminhamento_parecer_juridico',
                                                'encaminhamento_autorizacao_abertura',
                                                'valor_estimado',
                                            ],
                                        ],
                                        'minutas' => [
                                            'titulo' => 'MINUTAS',
                                            'cor' => 'bg-pink-500',
                                            'data_id' => 'data_minutas',
                                            'campos' => ['secretaria', 'anexar_minuta'],
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
                                            'campos' => ['secretaria', 'portaria_agente_equipe_pdf'],
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
                                        <td class="flex gap-2 px-6 py-4 text-center">
                                            <input type="date"
                                                class="w-40 px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                                id="{{ $doc['data_id'] }}"
                                                value="{{ $documentoGerado->data_selecionada ?? '' }}">

                                            @if ($tipo === 'parecer_juridico')
                                                <!-- Dropdown de Parecer -->
                                                <select id="parecer_select_{{ $tipo }}"
                                                    name="parecer_select_{{ $tipo }}"
                                                    class="block w-40 px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                                                    <option value="">Selecione o Parecer</option>
                                                    <option value="parecer_1">Parecer 1</option>
                                                    <option value="parecer_2">Parecer 2</option>
                                                    <option value="parecer_3">Parecer 3</option>
                                                </select>
                                            @endif
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
                                                            <h4 class="mb-4 text-sm font-semibold text-gray-700">Seleção de Assinantes</h4>

                                                            <div id="assinantes-container-{{ $tipo }}" class="space-y-3">
                                                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                                                    {{-- Select da Unidade --}}
                                                                    <div class="flex-1 min-w-[180px]">
                                                                        <label for="assinante_unidade_{{ $tipo }}" class="block mb-1 text-xs font-medium text-gray-600">
                                                                            Unidade
                                                                        </label>
                                                                        <select
                                                                            name="assinante_unidade[]"
                                                                            id="assinante_unidade_{{ $tipo }}"
                                                                            class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 unidade-select"
                                                                            onchange="updateResponsavel(this, '{{ $tipo }}')"
                                                                        >
                                                                            <option value="">Selecione a Unidade</option>
                                                                            @foreach ($processo->prefeitura->unidades as $unidade)
                                                                                <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    {{-- Input do Responsável e (opcionalmente) Portaria --}}
                                                                    <div class="flex flex-col flex-1 gap-2 sm:flex-row sm:items-center sm:gap-3">
                                                                        {{-- Nome do Responsável --}}
                                                                        <div class="flex-1 min-w-[200px]">
                                                                            <label class="block mb-1 text-xs font-medium text-gray-600">
                                                                                Responsável
                                                                            </label>
                                                                            <input
                                                                                type="text"
                                                                                name="assinante_responsavel[]"
                                                                                placeholder="Nome do Responsável"
                                                                                readonly
                                                                                class="block w-full px-3 py-2 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm responsavel-input"
                                                                            >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- Botão de adicionar assinante --}}
                                                            <div class="mt-4">
                                                                <button
                                                                    type="button"
                                                                    onclick="adicionarAssinante('{{ $tipo }}')"
                                                                    class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-white bg-blue-500 rounded-md shadow hover:bg-blue-600 focus:ring-2 focus:ring-blue-300"
                                                                >
                                                                    + Adicionar Assinante
                                                                </button>
                                                            </div>
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
                                                                            <div
                                                                                class="relative p-5 mb-4 transition-all duration-300 bg-white border-2 border-purple-200 border-dashed shadow-sm group rounded-xl hover:border-purple-300 hover:shadow-md">
                                                                                <div
                                                                                    class="flex items-start justify-between">
                                                                                    {{-- Conteúdo principal --}}
                                                                                    <div class="flex-1 min-w-0">
                                                                                        <div
                                                                                            class="flex items-center mb-2">
                                                                                            <div
                                                                                                class="p-2 mr-3 transition-colors duration-300 rounded-lg bg-purple-50 group-hover:bg-purple-100">
                                                                                                <svg class="w-5 h-5 text-purple-600"
                                                                                                    fill="none"
                                                                                                    stroke="currentColor"
                                                                                                    stroke-width="2"
                                                                                                    viewBox="0 0 24 24">
                                                                                                    <path
                                                                                                        stroke-linecap="round"
                                                                                                        stroke-linejoin="round"
                                                                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                                                </svg>
                                                                                            </div>
                                                                                            <label
                                                                                                for="itens_e_seus_quantitativos_xml"
                                                                                                class="block text-sm font-semibold text-purple-700 cursor-pointer">
                                                                                                📦 Itens e Seus
                                                                                                Quantitativos
                                                                                            </label>
                                                                                        </div>

                                                                                        <div class="relative">
                                                                                            <input type="file"
                                                                                                id="itens_e_seus_quantitativos_xml"
                                                                                                name="itens_e_seus_quantitativos_xml"
                                                                                                accept=".xml, .xlsx, .xls, .csv"
                                                                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                                                                onchange="updateFileName('itens_e_seus_quantitativos_xml', this)">

                                                                                            <div
                                                                                                class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                                                                                <span
                                                                                                    id="itens_e_seus_quantitativos_xml_nome"
                                                                                                    class="text-sm font-medium text-gray-500">
                                                                                                    Clique para selecionar
                                                                                                    arquivo (XML/Excel)
                                                                                                </span>
                                                                                                <div
                                                                                                    class="flex items-center space-x-2">
                                                                                                    <div
                                                                                                        class="flex items-center space-x-1 text-purple-600">
                                                                                                        <svg class="w-4 h-4"
                                                                                                            fill="none"
                                                                                                            stroke="currentColor"
                                                                                                            viewBox="0 0 24 24">
                                                                                                            <path
                                                                                                                stroke-linecap="round"
                                                                                                                stroke-linejoin="round"
                                                                                                                stroke-width="2"
                                                                                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                                                                        </svg>
                                                                                                        <span
                                                                                                            class="text-xs font-semibold">XML</span>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="w-px h-4 bg-gray-300">
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="flex items-center space-x-1 text-cyan-600">
                                                                                                        <svg class="w-4 h-4"
                                                                                                            fill="none"
                                                                                                            stroke="currentColor"
                                                                                                            viewBox="0 0 24 24">
                                                                                                            <path
                                                                                                                stroke-linecap="round"
                                                                                                                stroke-linejoin="round"
                                                                                                                stroke-width="2"
                                                                                                                d="M9 17v-2a4 4 0 00-4-4H3m12 2a4 4 0 014 4v2m-8-6h6m-6-4h6m2 5h4m-4-3h4M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m0 0h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V7z" />
                                                                                                        </svg>
                                                                                                        <span
                                                                                                            class="text-xs font-semibold">XLSX/CSV</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <p
                                                                                            class="flex items-center mt-2 text-xs text-gray-500">
                                                                                            <svg class="w-3 h-3 mr-1 text-purple-500"
                                                                                                fill="currentColor"
                                                                                                viewBox="0 0 20 20">
                                                                                                <path fill-rule="evenodd"
                                                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                                                    clip-rule="evenodd" />
                                                                                            </svg>
                                                                                            Arquivo XML ou Excel contendo os
                                                                                            itens da tabela e seus
                                                                                            quantitativos
                                                                                        </p>
                                                                                    </div>

                                                                                    {{-- Botões de ação --}}
                                                                                    <div
                                                                                        class="flex flex-col pt-6 pl-4 space-y-2">
                                                                                        <button type="button"
                                                                                            @click="saveField('itens_e_seus_quantitativos_xml')"
                                                                                            x-show="!confirmed.itens_e_seus_quantitativos_xml"
                                                                                            class="p-2 text-white transition-all duration-200 transform bg-purple-500 rounded-lg shadow-sm hover:bg-purple-600 hover:scale-105 hover:shadow-md"
                                                                                            title="Confirmar arquivo">
                                                                                            <svg class="w-4 h-4"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M5 13l4 4L19 7" />
                                                                                            </svg>
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            @click="toggleConfirm('itens_e_seus_quantitativos_xml')"
                                                                                            x-show="confirmed.itens_e_seus_quantitativos_xml"
                                                                                            class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md"
                                                                                            title="Remover arquivo">
                                                                                            <svg class="w-4 h-4"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M6 18L18 6M6 6l12 12" />
                                                                                            </svg>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                                {{-- Indicador de status --}}
                                                                                <div class="absolute top-3 right-3">
                                                                                    <div x-show="confirmed.itens_e_seus_quantitativos_xml"
                                                                                        class="w-2 h-2 bg-purple-500 rounded-full animate-pulse">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'painel_preco_tce')
                                                                            <div
                                                                                class="relative p-5 mb-4 transition-all duration-300 bg-white border-2 border-dashed shadow-sm group rounded-xl border-cyan-200 hover:border-cyan-300 hover:shadow-md">
                                                                                <div
                                                                                    class="flex items-start justify-between">
                                                                                    {{-- Conteúdo principal --}}
                                                                                    <div class="flex-1 min-w-0">
                                                                                        <div
                                                                                            class="flex items-center mb-2">
                                                                                            <div
                                                                                                class="p-2 mr-3 transition-colors duration-300 rounded-lg bg-cyan-50 group-hover:bg-cyan-100">
                                                                                                <svg class="w-5 h-5 text-cyan-600"
                                                                                                    fill="none"
                                                                                                    stroke="currentColor"
                                                                                                    stroke-width="2"
                                                                                                    viewBox="0 0 24 24">
                                                                                                    <path
                                                                                                        stroke-linecap="round"
                                                                                                        stroke-linejoin="round"
                                                                                                        d="M9 17v-2a4 4 0 00-4-4H3m12 2a4 4 0 014 4v2m-8-6h6m-6-4h6m2 5h4m-4-3h4M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m0 0h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V7z" />
                                                                                                </svg>
                                                                                            </div>
                                                                                            <label for="painel_preco_tce"
                                                                                                class="block text-sm font-semibold cursor-pointer text-cyan-700">
                                                                                                📊 Painel de Preço TCE
                                                                                            </label>
                                                                                        </div>

                                                                                        <div class="relative">
                                                                                            <input type="file"
                                                                                                id="painel_preco_tce"
                                                                                                name="painel_preco_tce"
                                                                                                accept=".xlsx, .xls, .csv"
                                                                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                                                                onchange="updateFileName('painel_preco_tce', this)">

                                                                                            <div
                                                                                                class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                                                                                <span
                                                                                                    id="painel_preco_tce_nome"
                                                                                                    class="text-sm font-medium text-gray-500">
                                                                                                    Clique para selecionar
                                                                                                    arquivo (Excel/CSV)
                                                                                                </span>
                                                                                                <div
                                                                                                    class="flex items-center space-x-2 text-cyan-600">
                                                                                                    <svg class="w-4 h-4"
                                                                                                        fill="none"
                                                                                                        stroke="currentColor"
                                                                                                        viewBox="0 0 24 24">
                                                                                                        <path
                                                                                                            stroke-linecap="round"
                                                                                                            stroke-linejoin="round"
                                                                                                            stroke-width="2"
                                                                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                                                    </svg>
                                                                                                    <span
                                                                                                        class="text-xs font-semibold">XLSX/CSV</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <p
                                                                                            class="flex items-center mt-2 text-xs text-gray-500">
                                                                                            <svg class="w-3 h-3 mr-1 text-cyan-500"
                                                                                                fill="currentColor"
                                                                                                viewBox="0 0 20 20">
                                                                                                <path fill-rule="evenodd"
                                                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                                                    clip-rule="evenodd" />
                                                                                            </svg>
                                                                                            Arquivo Excel ou CSV contendo os
                                                                                            dados do painel de preços TCE
                                                                                        </p>
                                                                                    </div>

                                                                                    {{-- Botões de ação --}}
                                                                                    <div
                                                                                        class="flex flex-col pt-6 pl-4 space-y-2">
                                                                                        <button type="button"
                                                                                            @click="saveField('painel_preco_tce')"
                                                                                            x-show="!confirmed.painel_preco_tce"
                                                                                            class="p-2 text-white transition-all duration-200 transform rounded-lg shadow-sm bg-cyan-500 hover:bg-cyan-600 hover:scale-105 hover:shadow-md"
                                                                                            title="Confirmar arquivo">
                                                                                            <svg class="w-4 h-4"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M5 13l4 4L19 7" />
                                                                                            </svg>
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            @click="toggleConfirm('painel_preco_tce')"
                                                                                            x-show="confirmed.painel_preco_tce"
                                                                                            class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md"
                                                                                            title="Remover arquivo">
                                                                                            <svg class="w-4 h-4"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M6 18L18 6M6 6l12 12" />
                                                                                            </svg>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                                {{-- Indicador de status --}}
                                                                                <div class="absolute top-3 right-3">
                                                                                    <div x-show="confirmed.painel_preco_tce"
                                                                                        class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <script>
                                                                                function updateFileName(fieldId, input) {
                                                                                    const fileName = input.files[0]?.name || 'Nenhum arquivo selecionado';
                                                                                    document.getElementById(`${fieldId}_nome`).textContent = fileName;
                                                                                }
                                                                            </script>
                                                                        @elseif($campo === 'encaminhamento_elaborar_editais')
                                                                            <div class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <label
                                                                                        for="encaminhamento_elaborar_editais"
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">
                                                                                        Encaminhamento para ELABORAÇÃO DE EDITAL E MINUTA DE CONTRATO
                                                                                    </label>
                                                                                    <select
                                                                                        id="encaminhamento_elaborar_editais"
                                                                                        x-model="encaminhamento_elaborar_editais"
                                                                                        @change="onUnidadeChange"
                                                                                        :disabled="confirmed
                                                                                            .encaminhamento_elaborar_editais"
                                                                                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                                                                        <option value="">Selecione
                                                                                            uma unidade</option>
                                                                                        @foreach ($processo->prefeitura->unidades as $unidade)
                                                                                            <option
                                                                                                value="{{ $unidade->nome }}"
                                                                                                data-responsavel="{{ $unidade->servidor_responsavel }}"
                                                                                                {{ ($processo->detalhe->encaminhamento_elaborar_editais ?? '') == $unidade->nome ? 'selected' : '' }}>
                                                                                                {{ $unidade->nome }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('encaminhamento_elaborar_editais')"
                                                                                        x-show="!confirmed.encaminhamento_elaborar_editais"
                                                                                        :disabled="!encaminhamento_elaborar_editais"
                                                                                        class="px-3 py-2 text-white transition rounded-lg"
                                                                                        :class="!encaminhamento_elaborar_editais
                                                                                            ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('encaminhamento_elaborar_editais')"
                                                                                        x-show="confirmed.encaminhamento_elaborar_editais"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'encaminhamento_parecer_juridico')
                                                                            <div class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <label
                                                                                        for="encaminhamento_parecer_juridico"
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">
                                                                                        Encaminhamento para ELABORAÇÃO DE PARECER JURÍDICO
                                                                                    </label>
                                                                                    <select
                                                                                        id="encaminhamento_parecer_juridico"
                                                                                        x-model="encaminhamento_parecer_juridico"
                                                                                        @change="onUnidadeChange"
                                                                                        :disabled="confirmed
                                                                                            .encaminhamento_parecer_juridico"
                                                                                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                                                                        <option value="">Selecione
                                                                                            uma unidade</option>
                                                                                        @foreach ($processo->prefeitura->unidades as $unidade)
                                                                                            <option
                                                                                                value="{{ $unidade->nome }}"
                                                                                                data-responsavel="{{ $unidade->servidor_responsavel }}"
                                                                                                {{ ($processo->detalhe->encaminhamento_parecer_juridico ?? '') == $unidade->nome ? 'selected' : '' }}>
                                                                                                {{ $unidade->nome }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('encaminhamento_parecer_juridico')"
                                                                                        x-show="!confirmed.encaminhamento_parecer_juridico"
                                                                                        :disabled="!encaminhamento_parecer_juridico"
                                                                                        class="px-3 py-2 text-white transition rounded-lg"
                                                                                        :class="!encaminhamento_parecer_juridico
                                                                                            ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('encaminhamento_parecer_juridico')"
                                                                                        x-show="confirmed.encaminhamento_parecer_juridico"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'encaminhamento_autorizacao_abertura')
                                                                            <div class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <label
                                                                                        for="encaminhamento_autorizacao_abertura"
                                                                                        class="block mb-1 text-sm font-medium text-gray-700">
                                                                                        Encaminhamento para AUTORIZAÇÃO DE ABERTURA DE PROCEDIMENTO PELA AUTORIDADE COMPETENTE
                                                                                    </label>
                                                                                    <select
                                                                                        id="encaminhamento_autorizacao_abertura"
                                                                                        x-model="encaminhamento_autorizacao_abertura"
                                                                                        @change="onUnidadeChange"
                                                                                        :disabled="confirmed
                                                                                            .encaminhamento_autorizacao_abertura"
                                                                                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                                                                                        <option value="">Selecione
                                                                                            uma unidade</option>
                                                                                        @foreach ($processo->prefeitura->unidades as $unidade)
                                                                                            <option
                                                                                                value="{{ $unidade->nome }}"
                                                                                                data-responsavel="{{ $unidade->servidor_responsavel }}"
                                                                                                {{ ($processo->detalhe->encaminhamento_autorizacao_abertura ?? '') == $unidade->nome ? 'selected' : '' }}>
                                                                                                {{ $unidade->nome }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="flex pt-6 space-x-1">
                                                                                    <button type="button"
                                                                                        @click="saveField('encaminhamento_autorizacao_abertura')"
                                                                                        x-show="!confirmed.encaminhamento_autorizacao_abertura"
                                                                                        :disabled="!
                                                                                        encaminhamento_autorizacao_abertura"
                                                                                        class="px-3 py-2 text-white transition rounded-lg"
                                                                                        :class="!
                                                                                        encaminhamento_autorizacao_abertura
                                                                                            ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                                                                                        ✔
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        @click="toggleConfirm('encaminhamento_autorizacao_abertura')"
                                                                                        x-show="confirmed.encaminhamento_autorizacao_abertura"
                                                                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                                                        ✖
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'valor_estimado')
                                                                            <x-form-field name="valor_estimado"
                                                                                label="valor_estimado" />
                                                                        @elseif($campo === 'anexo_pdf_analise_mercado')
                                                                            {{-- Campo de anexo PDF - Versão Melhorada --}}
                                                                            <div
                                                                                class="relative p-6 mb-4 transition-all duration-300 bg-white border-2 border-dashed shadow-sm group rounded-xl border-emerald-300 hover:border-emerald-400 hover:shadow-md">
                                                                                <div class="flex items-start space-x-4">
                                                                                    {{-- Ícone --}}
                                                                                    <div class="flex-shrink-0">
                                                                                        <div
                                                                                            class="p-3 transition-colors duration-300 rounded-lg bg-emerald-50 group-hover:bg-emerald-100">
                                                                                            <svg class="w-6 h-6 text-emerald-600"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="2"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                                            </svg>
                                                                                        </div>
                                                                                    </div>

                                                                                    {{-- Conteúdo principal --}}
                                                                                    <div class="flex-1 min-w-0">
                                                                                        <label
                                                                                            for="anexo_pdf_analise_mercado"
                                                                                            class="block mb-2 text-sm font-semibold cursor-pointer text-emerald-700">
                                                                                            📎 Anexar PDF à Análise de
                                                                                            Mercado
                                                                                        </label>

                                                                                        <div class="relative">
                                                                                            <input type="file"
                                                                                                id="anexo_pdf_analise_mercado"
                                                                                                name="anexo_pdf_analise_mercado"
                                                                                                accept="application/pdf"
                                                                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                                                                onchange="document.getElementById('anexo_nome').textContent = this.files[0]?.name || 'Nenhum arquivo selecionado'">

                                                                                            <div
                                                                                                class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                                                                                <span id="anexo_nome"
                                                                                                    class="text-sm font-medium text-gray-500">Clique
                                                                                                    para selecionar um
                                                                                                    arquivo</span>
                                                                                                <div
                                                                                                    class="flex items-center space-x-2 text-gray-400">
                                                                                                    <svg class="w-4 h-4"
                                                                                                        fill="none"
                                                                                                        stroke="currentColor"
                                                                                                        viewBox="0 0 24 24">
                                                                                                        <path
                                                                                                            stroke-linecap="round"
                                                                                                            stroke-linejoin="round"
                                                                                                            stroke-width="2"
                                                                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                                                                    </svg>
                                                                                                    <span
                                                                                                        class="text-xs font-medium">PDF</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <p
                                                                                            class="flex items-center mt-2 text-xs text-gray-500">
                                                                                            <svg class="w-3 h-3 mr-1 text-emerald-500"
                                                                                                fill="currentColor"
                                                                                                viewBox="0 0 20 20">
                                                                                                <path fill-rule="evenodd"
                                                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                                                    clip-rule="evenodd" />
                                                                                            </svg>
                                                                                            O arquivo será anexado
                                                                                            automaticamente ao documento
                                                                                            gerado
                                                                                        </p>
                                                                                    </div>

                                                                                    {{-- Botões de ação --}}
                                                                                    <div
                                                                                        class="flex flex-col items-center pt-1 space-y-2">
                                                                                        <button type="button"
                                                                                            @click="saveField('anexo_pdf_analise_mercado')"
                                                                                            x-show="!confirmed.anexo_pdf_analise_mercado"
                                                                                            class="p-2 text-white transition-all duration-200 transform rounded-lg shadow-sm bg-emerald-500 hover:bg-emerald-600 hover:scale-105 hover:shadow-md"
                                                                                            title="Confirmar arquivo">
                                                                                            <svg class="w-4 h-4"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M5 13l4 4L19 7" />
                                                                                            </svg>
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            @click="toggleConfirm('anexo_pdf_analise_mercado')"
                                                                                            x-show="confirmed.anexo_pdf_analise_mercado"
                                                                                            class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md"
                                                                                            title="Remover arquivo">
                                                                                            <svg class="w-4 h-4"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M6 18L18 6M6 6l12 12" />
                                                                                            </svg>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                                {{-- Indicador de status --}}
                                                                                <div class="absolute top-3 right-3">
                                                                                    <div x-show="confirmed.anexo_pdf_analise_mercado"
                                                                                        class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'portaria_agente_equipe_pdf')
                                                                            {{-- Campo de anexo PDF - Versão Melhorada --}}
                                                                            <div
                                                                                class="relative p-6 mb-4 transition-all duration-300 bg-white border-2 border-dashed shadow-sm group rounded-xl border-emerald-300 hover:border-emerald-400 hover:shadow-md">
                                                                                <div class="flex items-start space-x-4">
                                                                                    {{-- Ícone --}}
                                                                                    <div class="flex-shrink-0">
                                                                                        <div
                                                                                            class="p-3 transition-colors duration-300 rounded-lg bg-emerald-50 group-hover:bg-emerald-100">
                                                                                            <svg class="w-6 h-6 text-emerald-600"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="2"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                                            </svg>
                                                                                        </div>
                                                                                    </div>

                                                                                    {{-- Conteúdo principal --}}
                                                                                    <div class="flex-1 min-w-0">
                                                                                        <label
                                                                                            for="portaria_agente_equipe_pdf"
                                                                                            class="block mb-2 text-sm font-semibold cursor-pointer text-emerald-700">
                                                                                            📎 Anexar PDF à PORTARIA DE
                                                                                            AGENTE DE CONTRATAÇÃO E EQUIPE
                                                                                            DE APOIO

                                                                                        </label>

                                                                                        <div class="relative">
                                                                                            <input type="file"
                                                                                                id="portaria_agente_equipe_pdf"
                                                                                                name="portaria_agente_equipe_pdf"
                                                                                                accept="application/pdf"
                                                                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                                                                onchange="document.getElementById('anexo_pdf_portaria').textContent = this.files[0]?.name || 'Nenhum arquivo selecionado'">

                                                                                            <div
                                                                                                class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                                                                                <span
                                                                                                    id="anexo_pdf_portaria"
                                                                                                    class="text-sm font-medium text-gray-500">Clique
                                                                                                    para selecionar um
                                                                                                    arquivo</span>
                                                                                                <div
                                                                                                    class="flex items-center space-x-2 text-gray-400">
                                                                                                    <svg class="w-4 h-4"
                                                                                                        fill="none"
                                                                                                        stroke="currentColor"
                                                                                                        viewBox="0 0 24 24">
                                                                                                        <path
                                                                                                            stroke-linecap="round"
                                                                                                            stroke-linejoin="round"
                                                                                                            stroke-width="2"
                                                                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                                                                    </svg>
                                                                                                    <span
                                                                                                        class="text-xs font-medium">PDF</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <p
                                                                                            class="flex items-center mt-2 text-xs text-gray-500">
                                                                                            <svg class="w-3 h-3 mr-1 text-emerald-500"
                                                                                                fill="currentColor"
                                                                                                viewBox="0 0 20 20">
                                                                                                <path fill-rule="evenodd"
                                                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                                                    clip-rule="evenodd" />
                                                                                            </svg>
                                                                                            O arquivo será anexado
                                                                                            automaticamente ao documento
                                                                                            gerado
                                                                                        </p>
                                                                                    </div>

                                                                                    {{-- Botões de ação --}}
                                                                                    <div
                                                                                        class="flex flex-col items-center pt-1 space-y-2">
                                                                                        <button type="button"
                                                                                            @click="saveField('portaria_agente_equipe_pdf')"
                                                                                            x-show="!confirmed.portaria_agente_equipe_pdf"
                                                                                            class="p-2 text-white transition-all duration-200 transform rounded-lg shadow-sm bg-emerald-500 hover:bg-emerald-600 hover:scale-105 hover:shadow-md"
                                                                                            title="Confirmar arquivo">
                                                                                            <svg class="w-4 h-4"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M5 13l4 4L19 7" />
                                                                                            </svg>
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            @click="toggleConfirm('portaria_agente_equipe_pdf')"
                                                                                            x-show="confirmed.portaria_agente_equipe_pdf"
                                                                                            class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md"
                                                                                            title="Remover arquivo">
                                                                                            <svg class="w-4 h-4"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M6 18L18 6M6 6l12 12" />
                                                                                            </svg>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                                {{-- Indicador de status --}}
                                                                                <div class="absolute top-3 right-3">
                                                                                    <div x-show="confirmed.portaria_agente_equipe_pdf"
                                                                                        class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($campo === 'dotacao_orcamentaria')
                                                                            @if($processo->detalhe->tipo_srp == 'nao')
                                                                                <x-form-field name="dotacao_orcamentaria"
                                                                                    label="CASO A LICITAÇÃO NÃO SEJA DO TIPO SRP, DESCREVA ABAIXO A DOTAÇÃO ORÇAMENTÁRIA"
                                                                                    type="textarea" />
                                                                            @endif
                                                                        @elseif($campo === 'anexar_minuta')
                                                                            {{-- Campo de anexo PDF - Versão Melhorada --}}
                                                                            <div
                                                                                class="relative p-6 mb-4 transition-all duration-300 bg-white border-2 border-dashed shadow-sm group rounded-xl border-emerald-300 hover:border-emerald-400 hover:shadow-md">
                                                                                <div class="flex items-start space-x-4">
                                                                                    {{-- Ícone --}}
                                                                                    <div class="flex-shrink-0">
                                                                                        <div
                                                                                            class="p-3 transition-colors duration-300 rounded-lg bg-emerald-50 group-hover:bg-emerald-100">
                                                                                            <svg class="w-6 h-6 text-emerald-600"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="2"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                                            </svg>
                                                                                        </div>
                                                                                    </div>

                                                                                    {{-- Conteúdo principal --}}
                                                                                    <div class="flex-1 min-w-0">
                                                                                        <label for="anexar_minuta"
                                                                                            class="block mb-2 text-sm font-semibold cursor-pointer text-emerald-700">
                                                                                            📎 Anexar PDF à Minutas
                                                                                        </label>

                                                                                        <div class="relative">
                                                                                            <input type="file"
                                                                                                id="anexar_minuta"
                                                                                                name="anexar_minuta"
                                                                                                accept="application/pdf"
                                                                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                                                                onchange="document.getElementById('anexo_pdf_minuta').textContent = this.files[0]?.name || 'Nenhum arquivo selecionado'">

                                                                                            <div
                                                                                                class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                                                                                <span id="anexo_pdf_minuta"
                                                                                                    class="text-sm font-medium text-gray-500">Clique
                                                                                                    para selecionar um
                                                                                                    arquivo</span>
                                                                                                <div
                                                                                                    class="flex items-center space-x-2 text-gray-400">
                                                                                                    <svg class="w-4 h-4"
                                                                                                        fill="none"
                                                                                                        stroke="currentColor"
                                                                                                        viewBox="0 0 24 24">
                                                                                                        <path
                                                                                                            stroke-linecap="round"
                                                                                                            stroke-linejoin="round"
                                                                                                            stroke-width="2"
                                                                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                                                                    </svg>
                                                                                                    <span
                                                                                                        class="text-xs font-medium">PDF</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <p
                                                                                            class="flex items-center mt-2 text-xs text-gray-500">
                                                                                            <svg class="w-3 h-3 mr-1 text-emerald-500"
                                                                                                fill="currentColor"
                                                                                                viewBox="0 0 20 20">
                                                                                                <path fill-rule="evenodd"
                                                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                                                    clip-rule="evenodd" />
                                                                                            </svg>
                                                                                            O arquivo será anexado
                                                                                            automaticamente ao documento
                                                                                            gerado
                                                                                        </p>
                                                                                    </div>

                                                                                    {{-- Botões de ação --}}
                                                                                    <div
                                                                                        class="flex flex-col items-center pt-1 space-y-2">
                                                                                        <button type="button"
                                                                                            @click="saveField('anexar_minuta')"
                                                                                            x-show="!confirmed.anexar_minuta"
                                                                                            class="p-2 text-white transition-all duration-200 transform rounded-lg shadow-sm bg-emerald-500 hover:bg-emerald-600 hover:scale-105 hover:shadow-md"
                                                                                            title="Confirmar arquivo">
                                                                                            <svg class="w-4 h-4"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M5 13l4 4L19 7" />
                                                                                            </svg>
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            @click="toggleConfirm('anexar_minuta')"
                                                                                            x-show="confirmed.anexar_minuta"
                                                                                            class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md"
                                                                                            title="Remover arquivo">
                                                                                            <svg class="w-4 h-4"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M6 18L18 6M6 6l12 12" />
                                                                                            </svg>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                                {{-- Indicador de status --}}
                                                                                <div class="absolute top-3 right-3">
                                                                                    <div x-show="confirmed.anexar_minuta"
                                                                                        class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse">
                                                                                    </div>
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
        document.addEventListener('alpine:init', () => {
            // Inicializa TinyMCE em todos os textareas com x-ref terminando em _editor
            document.querySelectorAll('textarea[x-ref$="_editor"]').forEach(textarea => {
                tinymce.init({
                    selector: '#' + textarea.id,
                    plugins: 'lists link table code charmap emoticons',
                    toolbar: 'undo redo | bold italic underline | bullist numlist | link table | emoticons charmap | code',
                    menubar: false,
                    branding: false,
                    height: 300,
                    setup: function(editor) {
                        editor.on('change keyup', function() {
                            // Atualiza o valor do textarea e dispara evento input para Alpine
                            textarea.value = editor.getContent();
                            textarea.dispatchEvent(new Event('input', {
                                bubbles: true
                            }));
                        });
                    }
                });
            });
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
                            class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm unidade-select min-w-[300px]"
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
                           class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm sm:text-sm responsavel-input min-w-[300px]">
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
            const assinanteDiv = select.closest('.flex.items-center');

            // Preenche o campo responsável
            const responsavelInput = assinanteDiv.querySelector('.responsavel-input');
            if (responsavelInput) {
                responsavelInput.value = selectedUnidade?.servidor_responsavel || '';
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
                            responsavel: unidade.servidor_responsavel,
                            numero_portaria: unidade.numero_portaria,
                            data_portaria: unidade.data_portaria,
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

            const parecer = document.getElementById('parecer_select_' + documento)?.value || '';
            const assinantes = getAssinantes(documento);
            const assinantesJson = JSON.stringify(assinantes);
            const assinantesEncoded = encodeURIComponent(assinantesJson);

            let url = `/admin/processos/${processoId}/pdf?documento=${documento}&data=${data}`;

            if (parecer) {
                url += `&parecer=${parecer}`;
            }
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
                painel_preco_tce: existing?.painel_preco_tce ?? '',
                anexo_pdf_analise_mercado: existing?.anexo_pdf_analise_mercado ?? '',

                encaminhamento_elaborar_editais: existing?.encaminhamento_elaborar_editais ?? '',
                encaminhamento_parecer_juridico: existing?.encaminhamento_parecer_juridico ?? '',
                encaminhamento_autorizacao_abertura: existing?.encaminhamento_autorizacao_abertura ?? '',
                valor_estimado: existing?.valor_estimado ?? '',
                portaria_agente_equipe_pdf: existing?.portaria_agente_equipe_pdf ?? '',
                dotacao_orcamentaria: existing?.dotacao_orcamentaria ?? '',
                anexar_minuta: existing?.anexar_minuta ?? '',

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
                    painel_preco_tce: !!existing?.painel_preco_tce,
                    anexo_pdf_analise_mercado: !!existing?.anexo_pdf_analise_mercado,

                    encaminhamento_elaborar_editais: !!existing?.encaminhamento_elaborar_editais,
                    encaminhamento_parecer_juridico: !!existing?.encaminhamento_parecer_juridico,
                    encaminhamento_autorizacao_abertura: !!existing?.encaminhamento_autorizacao_abertura,
                    valor_estimado: !!existing?.valor_estimado,
                    portaria_agente_equipe_pdf: !!existing?.portaria_agente_equipe_pdf,
                    anexar_minuta: !!existing?.anexar_minuta,
                    dotacao_orcamentaria: !!existing?.dotacao_orcamentaria,
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
                        'justificativa_solucao_escolhida', 'impacto_ambiental', 'resultado_pretendidos',
                        'dotacao_orcamentaria'
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
                    } else if (field === 'painel_preco_tce') {
                        const fileInput = document.getElementById('painel_preco_tce');
                        if (fileInput && fileInput.files.length > 0) {
                            formData.append(field, fileInput.files[0]);
                        }
                    } else if (field === 'anexo_pdf_analise_mercado') {
                        const fileInput = document.getElementById('anexo_pdf_analise_mercado');
                        if (fileInput && fileInput.files.length > 0) {
                            formData.append(field, fileInput.files[0]);
                        }
                    } else if (field === 'portaria_agente_equipe_pdf') {
                        const fileInput = document.getElementById('portaria_agente_equipe_pdf');
                        if (fileInput && fileInput.files.length > 0) {
                            formData.append(field, fileInput.files[0]);
                        }
                    } else if (field === 'anexar_minuta') {
                        const fileInput = document.getElementById('anexar_minuta');
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
