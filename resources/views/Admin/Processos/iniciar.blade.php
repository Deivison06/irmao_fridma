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
                                        <strong>Objeto:</strong> {!! strip_tags($processo->objeto) !!}
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
                                                                    <div class="flex flex-col gap-3 p-4 bg-white border border-gray-200 rounded-lg assinante-item">
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

                                                                            {{-- Campos do Responsável e Portaria --}}
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

                                                                                {{-- Número da Portaria --}}
                                                                                <div class="flex-1 min-w-[150px]">
                                                                                    <label class="block mb-1 text-xs font-medium text-gray-600">
                                                                                        Nº Portaria
                                                                                    </label>
                                                                                    <input
                                                                                        type="text"
                                                                                        name="assinante_portaria[]"
                                                                                        placeholder="Número da Portaria"
                                                                                        readonly
                                                                                        class="block w-full px-3 py-2 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm portaria-input"
                                                                                    >
                                                                                </div>

                                                                                {{-- Data da Portaria --}}
                                                                                <div class="flex-1 min-w-[150px]">
                                                                                    <label class="block mb-1 text-xs font-medium text-gray-600">
                                                                                        Data Portaria
                                                                                    </label>
                                                                                    <input
                                                                                        type="text"
                                                                                        name="assinante_data_portaria[]"
                                                                                        placeholder="Data da Portaria"
                                                                                        readonly
                                                                                        class="block w-full px-3 py-2 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm data-portaria-input"
                                                                                    >
                                                                                </div>
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
                                                                    @include('admin.Processos.partials.forms')
                                                                @endforeach
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
            document.querySelectorAll('textarea[x-ref$="_editor"]').forEach(textarea => {
                tinymce.init({
                    selector: '#' + textarea.id,
                    plugins: 'advlist lists link table code charmap emoticons',
                    toolbar: 'undo redo | bold italic underline | bullist numlist | styleselect | link table | emoticons charmap | code',
                    menubar: false,
                    branding: false,
                    height: 300,
                    advlist_bullet_styles: 'default,circle,square',
                    advlist_number_styles: 'default,lower-alpha,upper-alpha,lower-roman,upper-roman',
                    setup: function (editor) {
                        editor.on('change keyup', function () {
                            textarea.value = editor.getContent();
                            textarea.dispatchEvent(new Event('input', { bubbles: true }));
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
            novoAssinante.className = 'assinante-item flex flex-col gap-3 p-4 mb-3 bg-white border border-gray-200 rounded-lg';
            novoAssinante.innerHTML = `
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    {{-- Select da Unidade --}}
                    <div class="flex-1 min-w-[180px]">
                        <label class="block mb-1 text-xs font-medium text-gray-600">
                            Unidade
                        </label>
                        <select name="assinante_unidade[]"
                                class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 unidade-select"
                                onchange="updateResponsavel(this, '${tipoDocumento}')">
                            <option value="">Selecione a Unidade</option>
                            @foreach ($processo->prefeitura->unidades as $unidade)
                                <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Campos do Responsável e Portaria --}}
                    <div class="flex flex-col flex-1 gap-2 sm:flex-row sm:items-center sm:gap-3">
                        {{-- Nome do Responsável --}}
                        <div class="flex-1 min-w-[200px]">
                            <label class="block mb-1 text-xs font-medium text-gray-600">
                                Responsável
                            </label>
                            <input type="text" name="assinante_responsavel[]"
                                placeholder="Nome do Responsável" readonly
                                class="block w-full px-3 py-2 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm responsavel-input">
                        </div>

                        {{-- Número da Portaria --}}
                        <div class="flex-1 min-w-[150px]">
                            <label class="block mb-1 text-xs font-medium text-gray-600">
                                Nº Portaria
                            </label>
                            <input type="text" name="assinante_portaria[]"
                                placeholder="Número da Portaria" readonly
                                class="block w-full px-3 py-2 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm portaria-input">
                        </div>

                        {{-- Data da Portaria --}}
                        <div class="flex-1 min-w-[150px]">
                            <label class="block mb-1 text-xs font-medium text-gray-600">
                                Data Portaria
                            </label>
                            <input type="text" name="assinante_data_portaria[]"
                                placeholder="Data da Portaria" readonly
                                class="block w-full px-3 py-2 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm data-portaria-input">
                        </div>
                    </div>

                    {{-- Botão Remover --}}
                    <div class="flex items-end sm:pt-6">
                        <button type="button" onclick="removerAssinante(this, '${tipoDocumento}')"
                                class="p-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                            🗑 Remover
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(novoAssinante);
        }

        function removerAssinante(botao, tipoDocumento) {
            const container = document.getElementById(`assinantes-container-${tipoDocumento}`);
            const assinanteDiv = botao.closest('.assinante-item'); // ✅ CORRETO
            const todosAssinantes = container.querySelectorAll('.assinante-item');

            if (todosAssinantes.length > 1) {
                assinanteDiv.style.transition = 'opacity 0.3s ease';
                assinanteDiv.style.opacity = '0';
                setTimeout(() => assinanteDiv.remove(), 300);
            } else {
                showMessage('É obrigatório ter pelo menos um assinante.', 'error');
            }

        }

        function updateResponsavel(select, tipoDocumento) {
            const selectedUnidadeId = select.value;
            const selectedUnidade = unidadesAssinantes.find(u => u.id == selectedUnidadeId);
            const assinanteDiv = select.closest('.assinante-item') || select.closest('.flex.items-center');

            if (selectedUnidade) {
                // Preenche o campo responsável
                const responsavelInput = assinanteDiv.querySelector('.responsavel-input');
                if (responsavelInput) {
                    responsavelInput.value = selectedUnidade.servidor_responsavel || '';
                }

                // Preenche o número da portaria (se existir o campo)
                const portariaInput = assinanteDiv.querySelector('.portaria-input');
                if (portariaInput) {
                    portariaInput.value = selectedUnidade.numero_portaria || '';
                }

                // Preenche a data da portaria (se existir o campo)
                const dataPortariaInput = assinanteDiv.querySelector('.data-portaria-input');
                if (dataPortariaInput) {
                    dataPortariaInput.value = selectedUnidade.data_portaria || '';
                }

                // Atualiza também os campos no formulário principal quando for a unidade_setor
                if (select.id === 'unidade_setor') {
                    const servidorResponsavelInput = document.getElementById('servidor_responsavel');
                    if (servidorResponsavelInput) {
                        servidorResponsavelInput.value = selectedUnidade.servidor_responsavel || '';
                    }
                }
            } else {
                // Limpa os campos se nenhuma unidade for selecionada
                const responsavelInput = assinanteDiv.querySelector('.responsavel-input');
                if (responsavelInput) responsavelInput.value = '';

                const portariaInput = assinanteDiv.querySelector('.portaria-input');
                if (portariaInput) portariaInput.value = '';

                const dataPortariaInput = assinanteDiv.querySelector('.data-portaria-input');
                if (dataPortariaInput) dataPortariaInput.value = '';
            }
        }

        // Função auxiliar para obter os dados dos assinantes
        function getAssinantes(tipoDocumento) {
            const container = document.getElementById(`assinantes-container-${tipoDocumento}`);
            const selects = container.querySelectorAll('select[name="assinante_unidade[]"]');
            const assinantes = [];

            selects.forEach((select, index) => {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption.value) {
                    const unidade = unidadesAssinantes.find(u => u.id == select.value);
                    if (unidade) {
                        // Busca os valores dos inputs correspondentes
                        const assinanteDiv = select.closest('.assinante-item');
                        const responsavelInput = assinanteDiv.querySelector('input[name="assinante_responsavel[]"]');
                        const portariaInput = assinanteDiv.querySelector('input[name="assinante_portaria[]"]');
                        const dataPortariaInput = assinanteDiv.querySelector('input[name="assinante_data_portaria[]"]');

                        assinantes.push({
                            unidade_id: unidade.id,
                            unidade_nome: unidade.nome,
                            responsavel: responsavelInput?.value || unidade.servidor_responsavel,
                            numero_portaria: portariaInput?.value || unidade.numero_portaria,
                            data_portaria: dataPortariaInput?.value || unidade.data_portaria,
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

            if (documento !== 'capa' && documento !== 'publicacoes_avisos_licitacao' && assinantes.length < 1) {
                showMessage('Você deve adicionar pelo menos um assinante antes de gerar o PDF.', 'error');
                return;
            }

            // Documentos que exigem 2 assinaturas obrigatórias
            const documentosComDoisAssinantes = ['estudo_tecnico'];
            if (documentosComDoisAssinantes.includes(documento) && assinantes.length < 2) {
                showMessage('Este documento requer duas assinaturas obrigatórias.', 'error');
                return;
            }
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
            const bgColor = type === 'success' ? 'bg-green-100 border-green-400' : 'bg-red-100 border-red-400';
            const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';
            const icon = type === 'success' ? '✅' : '❌';

            container.innerHTML = `
                <div class="p-4 mb-4 border-l-4 rounded-md ${bgColor} ${textColor}">
                    <div class="flex items-center">
                        <span class="mr-2 text-lg">${icon}</span>
                        <span class="font-semibold">${message}</span>
                    </div>
                </div>
            `;

            // Remove a mensagem automaticamente após 6 segundos
            setTimeout(() => {
                container.innerHTML = '';
            }, 6000);
        }

        // Alpine.js Component
        function formField(existing = {}) {
             // Parse da data_hora existente
            const dataHoraExistente = existing?.data_hora || '';
            let dataEvento = '';
            let horaEvento = '';

            if (dataHoraExistente) {
                try {
                    const dataHora = new Date(dataHoraExistente);
                    dataEvento = dataHora.toISOString().split('T')[0];
                    horaEvento = dataHora.toTimeString().split(' ')[0].substring(0, 5);
                } catch (e) {
                    console.error('Erro ao parse data_hora:', e);
                }
            }
            return {
                // Campos do formulário
                secretaria: existing?.secretaria ?? '',
                unidade_setor: existing?.unidade_setor ?? '',
                servidor_responsavel: existing?.servidor_responsavel ?? '',
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
                tratamento_diferenciado_MEs_eEPPs: existing?.tratamento_diferenciado_MEs_eEPPs ?? '',
                anexar_minuta: existing?.anexar_minuta ?? '',
                anexo_pdf_publicacoes: existing?.anexo_pdf_publicacoes ?? '',
                riscos_extra: existing?.riscos_extra ?? '',
                anexo_pdf_minuta_contrato: existing?.anexo_pdf_minuta_contrato ?? '',
                // Novos campos para data_hora
                data_evento: dataEvento,
                hora_evento: horaEvento,
                data_hora: existing?.data_hora ?? '',
                itens_especificaca_quantitativos_xml: existing?.itens_especificaca_quantitativos_xml ?? '',
                intervalo_lances: existing?.intervalo_lances ?? '',
                portal: existing?.portal ?? '',
                exigencia_garantia_proposta: existing?.exigencia_garantia_proposta ?? '',
                exigencia_garantia_contrato: existing?.exigencia_garantia_contrato ?? '',
                participacao_exclusiva_mei_epp: existing?.participacao_exclusiva_mei_epp ?? '',
                reserva_cotas_mei_epp: existing?.reserva_cotas_mei_epp ?? '',
                prioridade_contratacao_mei_epp: existing?.prioridade_contratacao_mei_epp ?? '',
                exigencias_tecnicas: existing?.exigencias_tecnicas ?? '',
                qualificacao_economica: existing?.qualificacao_economica ?? '',
                regularidade_fisica: existing?.regularidade_fisica ?? '',
                pregoeiro: existing?.pregoeiro ?? '',
                data_hora_edital: existing?.data_hora_edital ?? '',
                numero_items: existing?.numero_items ?? '',

                // Controle de confirmação
                confirmed: {
                    secretaria: !!existing?.secretaria,
                    unidade_setor: !!existing?.unidade_setor,
                    servidor_responsavel: !!existing?.servidor_responsavel,
                    tipo_procedimento: !!existing?.tipo_procedimento,
                    tipo_contratacao: !!existing?.tipo_contratacao,
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
                    tratamento_diferenciado_MEs_eEPPs: !!existing?.tratamento_diferenciado_MEs_eEPPs,
                    anexo_pdf_publicacoes: !!existing?.anexo_pdf_publicacoes,
                    riscos_extra: !!existing?.riscos_extra,
                    data_hora: !!existing?.data_hora,
                    itens_especificaca_quantitativos_xml: !!existing?.itens_especificaca_quantitativos_xml,
                    intervalo_lances: !!existing?.intervalo_lances,
                    portal: !!existing?.portal,
                    exigencia_garantia_proposta: !!existing?.exigencia_garantia_proposta,
                    exigencia_garantia_contrato: !!existing?.exigencia_garantia_contrato,
                    participacao_exclusiva_mei_epp: !!existing?.participacao_exclusiva_mei_epp,
                    reserva_cotas_mei_epp: !!existing?.reserva_cotas_mei_epp,
                    prioridade_contratacao_mei_epp: !!existing?.prioridade_contratacao_mei_epp,
                    exigencias_tecnicas: !!existing?.exigencias_tecnicas,
                    qualificacao_economica: !!existing?.qualificacao_economica,
                    regularidade_fisica: !!existing?.regularidade_fisica,
                    anexo_pdf_minuta_contrato: !!existing?.anexo_pdf_minuta_contrato,
                    pregoeiro: !!existing?.pregoeiro,
                    data_hora_edital: !!existing?.data_hora_edital,
                    numero_items: !!existing?.numero_items,
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

                // NOVO MÉTODO para salvar data_hora
                async saveDataHora() {
                    if (this.data_evento && this.hora_evento) {
                        // Combina data e hora
                        this.data_hora = `${this.data_evento} ${this.hora_evento}`;

                        // Usa o método saveField existente
                        await this.saveField('data_hora');
                    } else {
                        alert('Selecione a data e a hora antes de salvar.');
                    }
                },
                async saveDataHoraEdital() {
                if (this.data_edital_evento && this.hora_edital_evento) {
                    // Combina data e hora para o edital
                    this.data_hora_edital = `${this.data_edital_evento} ${this.hora_edital_evento}`;

                    // Usa o método saveField existente
                    await this.saveField('data_hora_edital');
                } else {
                    alert('Selecione a data e a hora do edital antes de salvar.');
                }
            },

                // Salva campo individual
                async saveField(field) {
                    const formData = new FormData();
                    formData.append('processo_id', {{ $processo->id }});
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                    // Quando salvar unidade_setor, também salva o servidor_responsavel
                    if (field === 'unidade_setor' && this.servidor_responsavel) {
                        formData.append('servidor_responsavel', this.servidor_responsavel);
                    }
                    // CASO ESPECIAL para data_hora
                    if (field === 'data_hora') {
                        formData.append('data_hora', this.data_hora);
                    }

                    // Campos do TinyMCE
                    const tinyMceFields = [
                        'justificativa', 'descricao_necessidade', 'descricao_necessidade_autorizacao',
                        'solucoes_disponivel_mercado', 'incluir_requisito_cada_caso_concreto',
                        'justificativa_solucao_escolhida', 'impacto_ambiental', 'resultado_pretendidos',
                        'dotacao_orcamentaria', 'tratamento_diferenciado_MEs_eEPPs', 'riscos_extra', 'exigencias_tecnicas', 'qualificacao_economica', 'regularidade_fisica'
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
                    } else if (field === 'anexo_pdf_publicacoes') {
                        const fileInput = document.getElementById('anexo_pdf_publicacoes');
                        if (fileInput && fileInput.files.length > 0) {
                            formData.append(field, fileInput.files[0]);
                        }
                    }else if (field === 'itens_especificaca_quantitativos_xml') {
                        const fileInput = document.getElementById('itens_especificaca_quantitativos_xml');
                        if (fileInput && fileInput.files.length > 0) {
                            formData.append(field, fileInput.files[0]);
                        }
                    }else if (field === 'anexo_pdf_minuta_contrato') {
                        const fileInput = document.getElementById('anexo_pdf_minuta_contrato');
                        if (fileInput && fileInput.files.length > 0) {
                            formData.append(field, fileInput.files[0]);
                        }
                    // Arrays
                    }else if (Array.isArray(this[field])) {
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
                            // Debug específico para data_hora
                            if (field === 'data_hora') {
                                console.log('Data/hora salva:', this.data_hora);
                            }
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
