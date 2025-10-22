<div class="p-3 mb-3 bg-white border border-gray-200 rounded-lg">
    {{-- Grupo: IDENTIFICAÇÃO DO ÓRGÃO REQUISITANTE --}}
    @if($campo === 'secretaria')
    <div class="mb-6">
        <div class="pb-2 mb-4 border-b-2 border-gray-300">
            <h3 class="text-lg font-bold text-gray-800">IDENTIFICAÇÃO DO ÓRGÃO REQUISITANTE</h3>
        </div>
        {{-- Campos do grupo --}}
        <x-form-field name="secretaria" label="Secretaria" />
        <div class="mb-6">
            <div class="flex items-start space-x-2">
                <div class="flex-1">
                    <label for="unidade_setor" class="block mb-1 text-sm font-medium text-gray-700">
                        Unidade / Setor / Departamento
                    </label>
                    <select id="unidade_setor" x-model="unidade_setor" @change="onUnidadeChange" :disabled="confirmed.unidade_setor" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                        <option value="">Selecione uma unidade</option>
                        @foreach ($processo->prefeitura->unidades as $unidade)
                        <option value="{{ $unidade->nome }}" data-responsavel="{{ $unidade->servidor_responsavel }}" {{ ($processo->detalhe->unidade_setor ?? '') == $unidade->nome ? 'selected' : '' }}>
                            {{ $unidade->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex pt-6 space-x-1">
                    <button type="button" @click="saveField('unidade_setor')" x-show="!confirmed.unidade_setor" :disabled="!unidade_setor" class="px-3 py-2 text-white transition rounded-lg" :class="!unidade_setor ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-600'">
                        ✔
                    </button>
                    <button type="button" @click="toggleConfirm('unidade_setor')" x-show="confirmed.unidade_setor" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                        ✖
                    </button>
                </div>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex items-start space-x-2">
                <div class="flex-1">
                    <label for="servidor_responsavel" class="block text-sm font-medium text-gray-700">
                        Servidor Responsável
                    </label>
                    <input type="text" id="servidor_responsavel" x-model="servidor_responsavel" value="{{ $processo->detalhe->servidor_responsavel ?? '' }}" readonly class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-lg shadow-sm sm:text-sm">
                </div>
            </div>
        </div>
    </div>
    @elseif($campo === 'justificativa')
    <x-form-field name="justificativa" label="Justificativa da Necessidade da Contratação" type="textarea" />
    @elseif($campo === 'descricao_necessidade')
    <x-form-field name="descricao_necessidade" label="DESCRIÇÃO DA NECESSIDADE" type="textarea" />
    @elseif($campo === 'descricao_necessidade_autorizacao')
    <x-form-field name="descricao_necessidade_autorizacao" label="DESCRIÇÃO DA NECESSIDADE DE AUTORIZAÇÃO" type="textarea" />
    @elseif($campo === 'incluir_requisito_cada_caso_concreto')
    <x-form-field name="incluir_requisito_cada_caso_concreto" label="REQUISITOS REFERENTES A CADA CASO CONCRETO" type="textarea" />
    @elseif($campo === 'solucoes_disponivel_mercado')
    <x-form-field name="solucoes_disponivel_mercado" label="SOLUÇÕES DISPONÍVEIS NO MERCADO" type="textarea" />
    @elseif($campo === 'solucao_escolhida')
    <x-form-field name="solucao_escolhida" label="SOLUÇÃO ESCOLHIDA" />
    @elseif($campo === 'justificativa_solucao_escolhida')
    <x-form-field name="justificativa_solucao_escolhida" label="JUSTIFICATIVA DA SOLUÇÃO ESCOLHIDA" type="textarea" />
    @elseif($campo === 'resultado_pretendidos')
    <x-form-field name="resultado_pretendidos" label="RESULTADOS PRETENDIDOS" type="textarea" />
    @elseif($campo === 'impacto_ambiental')
    <x-form-field name="impacto_ambiental" label="IMPACTOS AMBIENTAIS" type="textarea" />
    @elseif($campo === 'riscos_extra')
    <x-form-field name="riscos_extra" label="RISCOS EXTRAS" type="textarea" />
    @elseif($campo === 'tipo_srp')
    <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">Esse
                Processo é do tipo SRP?</span>
            <div class="flex mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="tipo_srp" value="sim" :disabled="confirmed.tipo_srp" :checked="tipo_srp === 'sim'">
                    <span class="ml-2">Sim</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="tipo_srp" value="nao" :disabled="confirmed.tipo_srp" :checked="tipo_srp === 'nao'">
                    <span class="ml-2">Não</span>
                </label>
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('tipo_srp')" x-show="!confirmed.tipo_srp" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('tipo_srp')" x-show="confirmed.tipo_srp" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'prevista_plano_anual')
    <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">
                A CONTRATAÇÃO ESTÁ PREVISTA NO PLANO
                DE CONTRATAÇÃO ANUAL?
            </span>
            <div class="flex mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="prevista_plano_anual" value="sim" :disabled="confirmed
                                                                                                    .prevista_plano_anual" :checked="prevista_plano_anual === 'sim'">
                    <span class="ml-2">Sim</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="prevista_plano_anual" value="nao" :disabled="confirmed
                                                                                                    .prevista_plano_anual" :checked="prevista_plano_anual === 'nao'">
                    <span class="ml-2">Não</span>
                </label>
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('prevista_plano_anual')" x-show="!confirmed.prevista_plano_anual" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('prevista_plano_anual')" x-show="confirmed.prevista_plano_anual" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'encaminhamento_pesquisa_preco')
    <div class="flex items-start space-x-2">
        <div class="flex-1">
            <label for="encaminhamento_pesquisa_preco" class="block mb-1 text-sm font-medium text-gray-700">
                Encaminhamento para pesquisa de
                Preços
            </label>
            <select id="encaminhamento_pesquisa_preco" x-model="encaminhamento_pesquisa_preco" @change="onUnidadeChange" :disabled="confirmed
                                                                                            .encaminhamento_pesquisa_preco" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                <option value="">Selecione
                    uma unidade</option>
                @foreach ($processo->prefeitura->unidades as $unidade)
                <option value="{{ $unidade->nome }}" data-responsavel="{{ $unidade->servidor_responsavel }}" {{ ($processo->detalhe->encaminhamento_pesquisa_preco ?? '') == $unidade->nome ? 'selected' : '' }}>
                    {{ $unidade->nome }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('encaminhamento_pesquisa_preco')" x-show="!confirmed.encaminhamento_pesquisa_preco" :disabled="!encaminhamento_pesquisa_preco" class="px-3 py-2 text-white transition rounded-lg" :class="!encaminhamento_pesquisa_preco ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('encaminhamento_pesquisa_preco')" x-show="confirmed.encaminhamento_pesquisa_preco" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'encaminhamento_doacao_orcamentaria')
    <div class="flex items-start space-x-2">
        <div class="flex-1">
            <label for="encaminhamento_doacao_orcamentaria" class="block mb-1 text-sm font-medium text-gray-700">
                Encaminhamento para doação
                orçamentária
            </label>
            <select id="encaminhamento_doacao_orcamentaria" x-model="encaminhamento_doacao_orcamentaria" :disabled="confirmed
                                                                                            .encaminhamento_doacao_orcamentaria" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                <option value="">Selecione
                    uma unidade</option>
                @foreach ($processo->prefeitura->unidades as $unidade)
                <option value="{{ $unidade->nome }}" {{ ($processo->detalhe->encaminhamento_doacao_orcamentaria ?? '') == $unidade->nome ? 'selected' : '' }}>
                    {{ $unidade->nome }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('encaminhamento_doacao_orcamentaria')" x-show="!confirmed.encaminhamento_doacao_orcamentaria" :disabled="!
                                                                                        encaminhamento_doacao_orcamentaria" class="px-3 py-2 text-white transition rounded-lg" :class="!
                                                                                        encaminhamento_doacao_orcamentaria
                                                                                            ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('encaminhamento_doacao_orcamentaria')" x-show="confirmed.encaminhamento_doacao_orcamentaria" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'problema_resolvido')
    <x-form-field name="problema_resolvido" label="Problema Resumido" />
    @elseif($campo === 'nome_equipe_planejamento')
    <x-form-field name="nome_equipe_planejamento" label="EQUIPE DE PLANEJAMENTO" />
    @elseif($campo === 'responsavel_equipe_planejamento')
    <x-form-field name="responsavel_equipe_planejamento" label="RESPONSAVEL EQUIPE DE PLANEJAMENTO" />
    @elseif($campo === 'prazo_entrega')
    <x-form-field name="prazo_entrega" label="Prazo de Entrega / Execução" />
    @elseif($campo === 'local_entrega')
    <x-form-field name="local_entrega" label="Local(is) e Horário(s) de Entrega" />
    @elseif($campo === 'fiscais')
    <x-form-field name="fiscais" label="Fiscal(is) Indicado(s)" />
    @elseif($campo === 'gestor')
    <x-form-field name="gestor" label="Gestor Indicado" />
    @elseif($campo === 'contratacoes_anteriores')
    <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">Houve
                contratações anteriores?</span>
            <div class="flex mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="contratacoes_anteriores" value="sim" :disabled="confirmed
                                                                                                    .contratacoes_anteriores" :checked="contratacoes_anteriores === 'sim'">
                    <span class="ml-2">Sim</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="contratacoes_anteriores" value="nao" :disabled="confirmed
                                                                                                    .contratacoes_anteriores" :checked="contratacoes_anteriores === 'nao'">
                    <span class="ml-2">Não</span>
                </label>
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('contratacoes_anteriores')" x-show="!confirmed.contratacoes_anteriores" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('contratacoes_anteriores')" x-show="confirmed.contratacoes_anteriores" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'objeto_continuado')
    <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">Objeto
                Continuado?</span>
            <div class="flex mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="objeto_continuado" value="sim" :disabled="confirmed
                                                                                                    .objeto_continuado" :checked="objeto_continuado === 'sim'">
                    <span class="ml-2">Sim</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="objeto_continuado" value="nao" :disabled="confirmed
                                                                                                    .objeto_continuado" :checked="objeto_continuado === 'nao'">
                    <span class="ml-2">Não</span>
                </label>
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('objeto_continuado')" x-show="!confirmed.objeto_continuado" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('objeto_continuado')" x-show="confirmed.objeto_continuado" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'inversao_fase')
    <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">Documento
                contém inversão de fase?</span>
            <div class="flex mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="inversao_fase" value="sim" :disabled="confirmed.inversao_fase" :checked="inversao_fase === 'sim'">
                    <span class="ml-2">Sim</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="inversao_fase" value="nao" :disabled="confirmed.inversao_fase" :checked="inversao_fase === 'nao'">
                    <span class="ml-2">Não</span>
                </label>
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('inversao_fase')" x-show="!confirmed.inversao_fase" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('inversao_fase')" x-show="confirmed.inversao_fase" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'instrumento_vinculativo')
    <div class="flex items-start space-x-2">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">Instrumento
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
                    <input type="checkbox" value="{{ $value }}" x-model="instrumento_vinculativo" :disabled="confirmed
                                                                                                        .instrumento_vinculativo" :checked="instrumento_vinculativo
                                                                                                        .includes(
                                                                                                            '{{ $value }}'
                                                                                                        )">
                    <span class="ml-2 text-sm">{{ $label }}</span>
                    @if ($value === 'outro')
                    <input type="text" x-show="instrumento_vinculativo.includes('outro')" x-model="instrumento_vinculativo_outro" :disabled="confirmed
                                                                                                            .instrumento_vinculativo" class="w-32 px-2 py-1 ml-2 text-sm border-gray-300 rounded-lg shadow-sm">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('instrumento_vinculativo')" x-show="!confirmed.instrumento_vinculativo" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('instrumento_vinculativo')" x-show="confirmed.instrumento_vinculativo" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'prazo_vigencia')
    <div class="flex items-start space-x-2">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">Prazo
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
                    <input type="checkbox" value="{{ $value }}" x-model="prazo_vigencia" :disabled="confirmed
                                                                                                        .prazo_vigencia" :checked="prazo_vigencia
                                                                                                        .includes(
                                                                                                            '{{ $value }}'
                                                                                                        )">
                    <span class="ml-2 text-sm">{{ $label }}</span>
                    @if ($value === 'outro')
                    <input type="text" x-show="prazo_vigencia.includes('outro')" x-model="prazo_vigencia_outro" :disabled="confirmed
                                                                                                            .prazo_vigencia" class="w-32 px-2 py-1 ml-2 text-sm border-gray-300 rounded-lg shadow-sm">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('prazo_vigencia')" x-show="!confirmed.prazo_vigencia" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('prazo_vigencia')" x-show="confirmed.prazo_vigencia" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'itens_e_seus_quantitativos_xml')
    <div class="relative p-5 mb-4 transition-all duration-300 bg-white border-2 border-purple-200 border-dashed shadow-sm group rounded-xl hover:border-purple-300 hover:shadow-md">
        <div class="flex items-start justify-between">
            {{-- Conteúdo principal --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center mb-2">
                    <div class="p-2 mr-3 transition-colors duration-300 rounded-lg bg-purple-50 group-hover:bg-purple-100">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <label for="itens_e_seus_quantitativos_xml" class="block text-sm font-semibold text-purple-700 cursor-pointer">
                        📦 Itens e Seus
                        Quantitativos
                    </label>
                </div>

                <div class="relative">
                    <input type="file" id="itens_e_seus_quantitativos_xml" name="itens_e_seus_quantitativos_xml" accept=".xml, .xlsx, .xls, .csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName('itens_e_seus_quantitativos_xml', this)">

                    <div class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                        <span id="itens_e_seus_quantitativos_xml_nome" class="text-sm font-medium text-gray-500">
                            Clique para selecionar
                            arquivo (XML/Excel)
                        </span>
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center space-x-1 text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span class="text-xs font-semibold">XML</span>
                            </div>
                            <div class="w-px h-4 bg-gray-300">
                            </div>
                            <div class="flex items-center space-x-1 text-cyan-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H3m12 2a4 4 0 014 4v2m-8-6h6m-6-4h6m2 5h4m-4-3h4M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m0 0h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V7z" />
                                </svg>
                                <span class="text-xs font-semibold">XLSX/CSV</span>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="flex items-center mt-2 text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Arquivo XML ou Excel contendo os
                    itens da tabela e seus
                    quantitativos
                </p>
            </div>

            {{-- Botões de ação --}}
            <div class="flex flex-col pt-6 pl-4 space-y-2">
                <button type="button" @click="saveField('itens_e_seus_quantitativos_xml')" x-show="!confirmed.itens_e_seus_quantitativos_xml" class="p-2 text-white transition-all duration-200 transform bg-purple-500 rounded-lg shadow-sm hover:bg-purple-600 hover:scale-105 hover:shadow-md" title="Confirmar arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <button type="button" @click="toggleConfirm('itens_e_seus_quantitativos_xml')" x-show="confirmed.itens_e_seus_quantitativos_xml" class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md" title="Remover arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Indicador de status --}}
        <div class="absolute top-3 right-3">
            <div x-show="confirmed.itens_e_seus_quantitativos_xml" class="w-2 h-2 bg-purple-500 rounded-full animate-pulse">
            </div>
        </div>
    </div>
    @elseif($campo === 'itens_especificaca_quantitativos_xml')
    <div class="relative p-5 mb-4 transition-all duration-300 bg-white border-2 border-purple-200 border-dashed shadow-sm group rounded-xl hover:border-purple-300 hover:shadow-md">
        <div class="flex items-start justify-between">
            {{-- Conteúdo principal --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center mb-2">
                    <div class="p-2 mr-3 transition-colors duration-300 rounded-lg bg-purple-50 group-hover:bg-purple-100">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <label for="itens_especificaca_quantitativos_xml" class="block text-sm font-semibold text-purple-700 cursor-pointer">
                        📦 Itens e Seus quantitativos e especificações
                    </label>
                </div>

                <div class="relative">
                    <input type="file" id="itens_especificaca_quantitativos_xml" name="itens_especificaca_quantitativos_xml" accept=".xml, .xlsx, .xls, .csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName('itens_especificaca_quantitativos_xml', this)">

                    <div class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                        <span id="itens_especificaca_quantitativos_xml_nome" class="text-sm font-medium text-gray-500">
                            Clique para selecionar
                            arquivo (XML/Excel)
                        </span>
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center space-x-1 text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span class="text-xs font-semibold">XML</span>
                            </div>
                            <div class="w-px h-4 bg-gray-300">
                            </div>
                            <div class="flex items-center space-x-1 text-cyan-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H3m12 2a4 4 0 014 4v2m-8-6h6m-6-4h6m2 5h4m-4-3h4M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m0 0h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V7z" />
                                </svg>
                                <span class="text-xs font-semibold">XLSX/CSV</span>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="flex items-center mt-2 text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Arquivo XML ou Excel contendo os
                    itens da tabela e seus
                    quantitativos
                </p>
            </div>

            {{-- Botões de ação --}}
            <div class="flex flex-col pt-6 pl-4 space-y-2">
                <button type="button" @click="saveField('itens_especificaca_quantitativos_xml')" x-show="!confirmed.itens_especificaca_quantitativos_xml" class="p-2 text-white transition-all duration-200 transform bg-purple-500 rounded-lg shadow-sm hover:bg-purple-600 hover:scale-105 hover:shadow-md" title="Confirmar arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <button type="button" @click="toggleConfirm('itens_especificaca_quantitativos_xml')" x-show="confirmed.itens_especificaca_quantitativos_xml" class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md" title="Remover arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Indicador de status --}}
        <div class="absolute top-3 right-3">
            <div x-show="confirmed.itens_especificaca_quantitativos_xml" class="w-2 h-2 bg-purple-500 rounded-full animate-pulse">
            </div>
        </div>
    </div>
    @elseif($campo === 'painel_preco_tce')
    <div class="relative p-5 mb-4 transition-all duration-300 bg-white border-2 border-dashed shadow-sm group rounded-xl border-cyan-200 hover:border-cyan-300 hover:shadow-md">
        <div class="flex items-start justify-between">
            {{-- Conteúdo principal --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center mb-2">
                    <div class="p-2 mr-3 transition-colors duration-300 rounded-lg bg-cyan-50 group-hover:bg-cyan-100">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 00-4-4H3m12 2a4 4 0 014 4v2m-8-6h6m-6-4h6m2 5h4m-4-3h4M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m0 0h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V7z" />
                        </svg>
                    </div>
                    <label for="painel_preco_tce" class="block text-sm font-semibold cursor-pointer text-cyan-700">
                        📊 Painel de Preço TCE
                    </label>
                </div>

                <div class="relative">
                    <input type="file" id="painel_preco_tce" name="painel_preco_tce" accept=".xlsx, .xls, .csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName('painel_preco_tce', this)">

                    <div class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                        <span id="painel_preco_tce_nome" class="text-sm font-medium text-gray-500">
                            Clique para selecionar
                            arquivo (Excel/CSV)
                        </span>
                        <div class="flex items-center space-x-2 text-cyan-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-xs font-semibold">XLSX/CSV</span>
                        </div>
                    </div>
                </div>

                <p class="flex items-center mt-2 text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Arquivo Excel ou CSV contendo os
                    dados do painel de preços TCE
                </p>
            </div>

            {{-- Botões de ação --}}
            <div class="flex flex-col pt-6 pl-4 space-y-2">
                <button type="button" @click="saveField('painel_preco_tce')" x-show="!confirmed.painel_preco_tce" class="p-2 text-white transition-all duration-200 transform rounded-lg shadow-sm bg-cyan-500 hover:bg-cyan-600 hover:scale-105 hover:shadow-md" title="Confirmar arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <button type="button" @click="toggleConfirm('painel_preco_tce')" x-show="confirmed.painel_preco_tce" class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md" title="Remover arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Indicador de status --}}
        <div class="absolute top-3 right-3">
            <div x-show="confirmed.painel_preco_tce" class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse">
            </div>
        </div>
    </div>

    <script>
        function updateFileName(fieldId, input) {
            const fileName = input.files[0] ? .name || 'Nenhum arquivo selecionado';
            document.getElementById(`${fieldId}_nome`).textContent = fileName;
        }

    </script>
    @elseif($campo === 'encaminhamento_elaborar_editais')
    <div class="flex items-start space-x-2">
        <div class="flex-1">
            <label for="encaminhamento_elaborar_editais" class="block mb-1 text-sm font-medium text-gray-700">
                Encaminhamento para ELABORAÇÃO DE EDITAL E MINUTA DE CONTRATO
            </label>
            <select id="encaminhamento_elaborar_editais" x-model="encaminhamento_elaborar_editais" @change="onUnidadeChange" :disabled="confirmed
                                                                                            .encaminhamento_elaborar_editais" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                <option value="">Selecione
                    uma unidade</option>
                @foreach ($processo->prefeitura->unidades as $unidade)
                <option value="{{ $unidade->nome }}" data-responsavel="{{ $unidade->servidor_responsavel }}" {{ ($processo->detalhe->encaminhamento_elaborar_editais ?? '') == $unidade->nome ? 'selected' : '' }}>
                    {{ $unidade->nome }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('encaminhamento_elaborar_editais')" x-show="!confirmed.encaminhamento_elaborar_editais" :disabled="!encaminhamento_elaborar_editais" class="px-3 py-2 text-white transition rounded-lg" :class="!encaminhamento_elaborar_editais
                                                                                            ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('encaminhamento_elaborar_editais')" x-show="confirmed.encaminhamento_elaborar_editais" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'encaminhamento_parecer_juridico')
    <div class="flex items-start space-x-2">
        <div class="flex-1">
            <label for="encaminhamento_parecer_juridico" class="block mb-1 text-sm font-medium text-gray-700">
                Encaminhamento para ELABORAÇÃO DE PARECER JURÍDICO
            </label>
            <select id="encaminhamento_parecer_juridico" x-model="encaminhamento_parecer_juridico" @change="onUnidadeChange" :disabled="confirmed
                                                                                            .encaminhamento_parecer_juridico" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                <option value="">Selecione
                    uma unidade</option>
                @foreach ($processo->prefeitura->unidades as $unidade)
                <option value="{{ $unidade->nome }}" data-responsavel="{{ $unidade->servidor_responsavel }}" {{ ($processo->detalhe->encaminhamento_parecer_juridico ?? '') == $unidade->nome ? 'selected' : '' }}>
                    {{ $unidade->nome }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('encaminhamento_parecer_juridico')" x-show="!confirmed.encaminhamento_parecer_juridico" :disabled="!encaminhamento_parecer_juridico" class="px-3 py-2 text-white transition rounded-lg" :class="!encaminhamento_parecer_juridico
                                                                                            ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('encaminhamento_parecer_juridico')" x-show="confirmed.encaminhamento_parecer_juridico" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'encaminhamento_autorizacao_abertura')
    <div class="flex items-start space-x-2">
        <div class="flex-1">
            <label for="encaminhamento_autorizacao_abertura" class="block mb-1 text-sm font-medium text-gray-700">
                Encaminhamento para AUTORIZAÇÃO DE ABERTURA DE PROCEDIMENTO PELA AUTORIDADE COMPETENTE
            </label>
            <select id="encaminhamento_autorizacao_abertura" x-model="encaminhamento_autorizacao_abertura" @change="onUnidadeChange" :disabled="confirmed
                                                                                            .encaminhamento_autorizacao_abertura" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                <option value="">Selecione
                    uma unidade</option>
                @foreach ($processo->prefeitura->unidades as $unidade)
                <option value="{{ $unidade->nome }}" data-responsavel="{{ $unidade->servidor_responsavel }}" {{ ($processo->detalhe->encaminhamento_autorizacao_abertura ?? '') == $unidade->nome ? 'selected' : '' }}>
                    {{ $unidade->nome }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('encaminhamento_autorizacao_abertura')" x-show="!confirmed.encaminhamento_autorizacao_abertura" :disabled="!
                                                                                        encaminhamento_autorizacao_abertura" class="px-3 py-2 text-white transition rounded-lg" :class="!
                                                                                        encaminhamento_autorizacao_abertura
                                                                                            ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('encaminhamento_autorizacao_abertura')" x-show="confirmed.encaminhamento_autorizacao_abertura" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'valor_estimado')
    <x-form-field name="valor_estimado" label="Valor Estimado" />
    @elseif($campo === 'anexo_pdf_analise_mercado')
    {{-- Campo de anexo PDF - Versão Melhorada --}}
    <div class="relative p-6 mb-4 transition-all duration-300 bg-white border-2 border-dashed shadow-sm group rounded-xl border-emerald-300 hover:border-emerald-400 hover:shadow-md">
        <div class="flex items-start space-x-4">
            {{-- Ícone --}}
            <div class="flex-shrink-0">
                <div class="p-3 transition-colors duration-300 rounded-lg bg-emerald-50 group-hover:bg-emerald-100">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>

            {{-- Conteúdo principal --}}
            <div class="flex-1 min-w-0">
                <label for="anexo_pdf_analise_mercado" class="block mb-2 text-sm font-semibold cursor-pointer text-emerald-700">
                    📎 Anexar PDF à Análise de
                    Mercado
                </label>

                <div class="relative">
                    <input type="file" id="anexo_pdf_analise_mercado" name="anexo_pdf_analise_mercado" accept="application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="document.getElementById('anexo_nome').textContent = this.files[0]?.name || 'Nenhum arquivo selecionado'">

                    <div class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                        <span id="anexo_nome" class="text-sm font-medium text-gray-500">Clique
                            para selecionar um
                            arquivo</span>
                        <div class="flex items-center space-x-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span class="text-xs font-medium">PDF</span>
                        </div>
                    </div>
                </div>

                <p class="flex items-center mt-2 text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    O arquivo será anexado
                    automaticamente ao documento
                    gerado
                </p>
            </div>

            {{-- Botões de ação --}}
            <div class="flex flex-col items-center pt-1 space-y-2">
                <button type="button" @click="saveField('anexo_pdf_analise_mercado')" x-show="!confirmed.anexo_pdf_analise_mercado" class="p-2 text-white transition-all duration-200 transform rounded-lg shadow-sm bg-emerald-500 hover:bg-emerald-600 hover:scale-105 hover:shadow-md" title="Confirmar arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <button type="button" @click="toggleConfirm('anexo_pdf_analise_mercado')" x-show="confirmed.anexo_pdf_analise_mercado" class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md" title="Remover arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Indicador de status --}}
        <div class="absolute top-3 right-3">
            <div x-show="confirmed.anexo_pdf_analise_mercado" class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse">
            </div>
        </div>
    </div>
    @elseif($campo === 'portaria_agente_equipe_pdf')
    {{-- Campo de anexo PDF - Versão Melhorada --}}
    <div class="relative p-6 mb-4 transition-all duration-300 bg-white border-2 border-dashed shadow-sm group rounded-xl border-emerald-300 hover:border-emerald-400 hover:shadow-md">
        <div class="flex items-start space-x-4">
            {{-- Ícone --}}
            <div class="flex-shrink-0">
                <div class="p-3 transition-colors duration-300 rounded-lg bg-emerald-50 group-hover:bg-emerald-100">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>

            {{-- Conteúdo principal --}}
            <div class="flex-1 min-w-0">
                <label for="portaria_agente_equipe_pdf" class="block mb-2 text-sm font-semibold cursor-pointer text-emerald-700">
                    📎 Anexar PDF à PORTARIA DE
                    AGENTE DE CONTRATAÇÃO E EQUIPE
                    DE APOIO

                </label>

                <div class="relative">
                    <input type="file" id="portaria_agente_equipe_pdf" name="portaria_agente_equipe_pdf" accept="application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="document.getElementById('anexo_pdf_portaria').textContent = this.files[0]?.name || 'Nenhum arquivo selecionado'">

                    <div class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                        <span id="anexo_pdf_portaria" class="text-sm font-medium text-gray-500">Clique
                            para selecionar um
                            arquivo</span>
                        <div class="flex items-center space-x-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span class="text-xs font-medium">PDF</span>
                        </div>
                    </div>
                </div>

                <p class="flex items-center mt-2 text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    O arquivo será anexado
                    automaticamente ao documento
                    gerado
                </p>
            </div>

            {{-- Botões de ação --}}
            <div class="flex flex-col items-center pt-1 space-y-2">
                <button type="button" @click="saveField('portaria_agente_equipe_pdf')" x-show="!confirmed.portaria_agente_equipe_pdf" class="p-2 text-white transition-all duration-200 transform rounded-lg shadow-sm bg-emerald-500 hover:bg-emerald-600 hover:scale-105 hover:shadow-md" title="Confirmar arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <button type="button" @click="toggleConfirm('portaria_agente_equipe_pdf')" x-show="confirmed.portaria_agente_equipe_pdf" class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md" title="Remover arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Indicador de status --}}
        <div class="absolute top-3 right-3">
            <div x-show="confirmed.portaria_agente_equipe_pdf" class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse">
            </div>
        </div>
    </div>
    @elseif($campo === 'tratamento_diferenciado_MEs_eEPPs')
    <x-form-field name="tratamento_diferenciado_MEs_eEPPs" label="TRATAMENTO DIFERENCIA A MEs e EPPs" type="textarea" />
    @elseif($campo === 'dotacao_orcamentaria')
    <x-form-field name="dotacao_orcamentaria" label="CASO A LICITAÇÃO NÃO SEJA DO TIPO SRP, DESCREVA ABAIXO A DOTAÇÃO ORÇAMENTÁRIA" type="textarea" />
    @elseif($campo === 'anexar_minuta')
    {{-- Campo de anexo PDF - Versão Melhorada --}}
    <div class="relative p-6 mb-4 transition-all duration-300 bg-white border-2 border-dashed shadow-sm group rounded-xl border-emerald-300 hover:border-emerald-400 hover:shadow-md">
        <div class="flex items-start space-x-4">
            {{-- Ícone --}}
            <div class="flex-shrink-0">
                <div class="p-3 transition-colors duration-300 rounded-lg bg-emerald-50 group-hover:bg-emerald-100">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>

            {{-- Conteúdo principal --}}
            <div class="flex-1 min-w-0">
                <label for="anexar_minuta" class="block mb-2 text-sm font-semibold cursor-pointer text-emerald-700">
                    📎 Anexar PDF à Minutas
                </label>

                <div class="relative">
                    <input type="file" id="anexar_minuta" name="anexar_minuta" accept="application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="document.getElementById('anexo_pdf_minuta').textContent = this.files[0]?.name || 'Nenhum arquivo selecionado'">

                    <div class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                        <span id="anexo_pdf_minuta" class="text-sm font-medium text-gray-500">Clique
                            para selecionar um
                            arquivo</span>
                        <div class="flex items-center space-x-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span class="text-xs font-medium">PDF</span>
                        </div>
                    </div>
                </div>

                <p class="flex items-center mt-2 text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    O arquivo será anexado
                    automaticamente ao documento
                    gerado
                </p>
            </div>

            {{-- Botões de ação --}}
            <div class="flex flex-col items-center pt-1 space-y-2">
                <button type="button" @click="saveField('anexar_minuta')" x-show="!confirmed.anexar_minuta" class="p-2 text-white transition-all duration-200 transform rounded-lg shadow-sm bg-emerald-500 hover:bg-emerald-600 hover:scale-105 hover:shadow-md" title="Confirmar arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <button type="button" @click="toggleConfirm('anexar_minuta')" x-show="confirmed.anexar_minuta" class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md" title="Remover arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Indicador de status --}}
        <div class="absolute top-3 right-3">
            <div x-show="confirmed.anexar_minuta" class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse">
            </div>
        </div>
    </div>

    @elseif($campo === 'anexo_pdf_publicacoes')
    {{-- Campo de anexo PDF - Versão Melhorada --}}
    <div class="relative p-6 mb-4 transition-all duration-300 bg-white border-2 border-dashed shadow-sm group rounded-xl border-emerald-300 hover:border-emerald-400 hover:shadow-md">
        <div class="flex items-start space-x-4">
            {{-- Ícone --}}
            <div class="flex-shrink-0">
                <div class="p-3 transition-colors duration-300 rounded-lg bg-emerald-50 group-hover:bg-emerald-100">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>

            {{-- Conteúdo principal --}}
            <div class="flex-1 min-w-0">
                <label for="anexo_pdf_publicacoes" class="block mb-2 text-sm font-semibold cursor-pointer text-emerald-700">
                    📎 Anexar PDF à Publicações
                </label>

                <div class="relative">
                    <input type="file" id="anexo_pdf_publicacoes" name="anexo_pdf_publicacoes" accept="application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="document.getElementById('pdf_publicacoes').textContent = this.files[0]?.name || 'Nenhum arquivo selecionado'">

                    <div class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                        <span id="pdf_publicacoes" class="text-sm font-medium text-gray-500">Clique para selecionar um arquivo</span>
                        <div class="flex items-center space-x-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span class="text-xs font-medium">PDF</span>
                        </div>
                    </div>
                </div>

                <p class="flex items-center mt-2 text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    O arquivo será anexado
                    automaticamente ao documento
                    gerado
                </p>
            </div>

            {{-- Botões de ação --}}
            <div class="flex flex-col items-center pt-1 space-y-2">
                <button type="button" @click="saveField('anexo_pdf_publicacoes')" x-show="!confirmed.anexo_pdf_publicacoes" class="p-2 text-white transition-all duration-200 transform rounded-lg shadow-sm bg-emerald-500 hover:bg-emerald-600 hover:scale-105 hover:shadow-md" title="Confirmar arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <button type="button" @click="toggleConfirm('anexo_pdf_publicacoes')" x-show="confirmed.anexo_pdf_publicacoes" class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md" title="Remover arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Indicador de status --}}
        <div class="absolute top-3 right-3">
            <div x-show="confirmed.anexar_minuta" class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse">
            </div>
        </div>
    </div>
    @elseif($campo === 'data_hora')
    <div class="p-5 mb-4 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h4 class="pb-2 mb-4 text-base font-semibold text-gray-700 border-b border-gray-200">
            📅 Data e Hora - ENTREGA E ABERTURA DAS PROPOSTAS
        </h4>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            {{-- Campo de Data --}}
            <div class="flex flex-col">
                <label for="data_evento" class="mb-1 text-sm font-medium text-gray-600">
                    DATA
                </label>
                <input type="date" id="data_evento" name="data_evento" x-model="data_evento" :disabled="confirmed.data_hora" class="w-full px-3 py-2 transition border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Campo de Hora --}}
            <div class="flex flex-col">
                <label for="hora_evento" class="mb-1 text-sm font-medium text-gray-600">
                    HORA
                </label>
                <input type="time" id="hora_evento" name="hora_evento" x-model="hora_evento" :disabled="confirmed.data_hora" class="w-full px-3 py-2 transition border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- Botões de ação --}}
        <div class="flex justify-end mt-5 space-x-3">
            <button type="button" @click="saveDataHora()" :disabled="!data_evento || !hora_evento" x-show="!confirmed.data_hora" class="flex items-center px-5 py-2 text-white transition bg-green-500 rounded-lg hover:bg-green-600 disabled:bg-gray-400 disabled:cursor-not-allowed">
                ✔ Salvar Data/Hora
            </button>

            <button type="button" @click="toggleConfirm('data_hora')" x-show="confirmed.data_hora" class="flex items-center px-5 py-2 text-white transition bg-red-500 rounded-lg hover:bg-red-600">
                ✖ Alterar Data/Hora
            </button>
        </div>

        {{-- Indicador de status --}}
        <div class="flex items-center mt-3 text-sm text-gray-600" x-show="confirmed.data_hora">
            <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">Data/Hora salva:</span>
            <span x-text="data_evento + ' ' + hora_evento" class="ml-2 font-semibold text-gray-700"></span>
        </div>
    </div>
    @elseif($campo === 'intervalo_lances')
    <x-form-field name="intervalo_lances" label="INTERVALO ENTRE OS LANCES" />
    @elseif($campo === 'portal')
    <x-form-field name="portal" label="PORTAL UTILIZADO" />
    @elseif($campo === 'exigencia_garantia_proposta')
    <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">EXIGÊNCIA DE GARANTIA DE PROPOSTA</span>
            <div class="flex mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="exigencia_garantia_proposta" value="sim" :disabled="confirmed.exigencia_garantia_proposta" :checked="exigencia_garantia_proposta === 'sim'">
                    <span class="ml-2">Sim</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="exigencia_garantia_proposta" value="nao" :disabled="confirmed.exigencia_garantia_proposta" :checked="exigencia_garantia_proposta === 'nao'">
                    <span class="ml-2">Não</span>
                </label>
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('exigencia_garantia_proposta')" x-show="!confirmed.exigencia_garantia_proposta" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('exigencia_garantia_proposta')" x-show="confirmed.exigencia_garantia_proposta" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'exigencia_garantia_contrato')
    <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">EXIGÊNCIA DE GARANTIA DE CONTRATO</span>
            <div class="flex mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="exigencia_garantia_contrato" value="sim" :disabled="confirmed.exigencia_garantia_contrato" :checked="exigencia_garantia_contrato === 'sim'">
                    <span class="ml-2">Sim</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="exigencia_garantia_contrato" value="nao" :disabled="confirmed.exigencia_garantia_contrato" :checked="exigencia_garantia_contrato === 'nao'">
                    <span class="ml-2">Não</span>
                </label>
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('exigencia_garantia_contrato')" x-show="!confirmed.exigencia_garantia_contrato" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('exigencia_garantia_contrato')" x-show="confirmed.exigencia_garantia_contrato" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'participacao_exclusiva_mei_epp')
    <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">Itens destinados à participação exclusiva para MEI/ME/EPP até R$ 80.000,00</span>
            <div class="flex mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="participacao_exclusiva_mei_epp" value="sim" :disabled="confirmed.participacao_exclusiva_mei_epp" :checked="participacao_exclusiva_mei_epp === 'sim'">
                    <span class="ml-2">Sim</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="participacao_exclusiva_mei_epp" value="nao" :disabled="confirmed.participacao_exclusiva_mei_epp" :checked="participacao_exclusiva_mei_epp === 'nao'">
                    <span class="ml-2">Não</span>
                </label>
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('participacao_exclusiva_mei_epp')" x-show="!confirmed.participacao_exclusiva_mei_epp" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('participacao_exclusiva_mei_epp')" x-show="confirmed.participacao_exclusiva_mei_epp" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'reserva_cotas_mei_epp')
    <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">Itens com reserva de cotas destinados à participação exclusiva para MEI/ME/EPP</span>
            <div class="flex mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="reserva_cotas_mei_epp" value="sim" :disabled="confirmed.reserva_cotas_mei_epp" :checked="reserva_cotas_mei_epp === 'sim'">
                    <span class="ml-2">Sim</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="reserva_cotas_mei_epp" value="nao" :disabled="confirmed.reserva_cotas_mei_epp" :checked="reserva_cotas_mei_epp === 'nao'">
                    <span class="ml-2">Não</span>
                </label>
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('reserva_cotas_mei_epp')" x-show="!confirmed.reserva_cotas_mei_epp" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('reserva_cotas_mei_epp')" x-show="confirmed.reserva_cotas_mei_epp" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'prioridade_contratacao_mei_epp')
    <div class="flex items-start pt-4 space-x-2 border-t border-gray-200">
        <div class="flex-1">
            <span class="block mb-1 text-sm font-medium text-gray-700">Prioridade de contratação para MEI/ME/EPP sediadas local ou regionalmente (até 10%)</span>
            <div class="flex mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="prioridade_contratacao_mei_epp" value="sim" :disabled="confirmed.prioridade_contratacao_mei_epp" :checked="prioridade_contratacao_mei_epp === 'sim'">
                    <span class="ml-2">Sim</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="prioridade_contratacao_mei_epp" value="nao" :disabled="confirmed.prioridade_contratacao_mei_epp" :checked="prioridade_contratacao_mei_epp === 'nao'">
                    <span class="ml-2">Não</span>
                </label>
            </div>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('prioridade_contratacao_mei_epp')" x-show="!confirmed.prioridade_contratacao_mei_epp" class="px-3 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('prioridade_contratacao_mei_epp')" x-show="confirmed.prioridade_contratacao_mei_epp" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'regularidade_fisica')
    <x-form-field name="regularidade_fisica" label="Regularidade Fiscal e Trabalhista:" type="textarea" />
    @elseif($campo === 'qualificacao_economica')
    <x-form-field name="qualificacao_economica" label="Qualificação Econômico-financeira:" type="textarea" />
    @elseif($campo === 'exigencias_tecnicas')
    <x-form-field name="exigencias_tecnicas" label="EXIGÊNCIAS TÉCNICAS" type="textarea" />
    @elseif($campo === 'anexo_pdf_minuta_contrato')
    {{-- Campo de anexo PDF - Versão Melhorada --}}
    <div class="relative p-6 mb-4 transition-all duration-300 bg-white border-2 border-dashed shadow-sm group rounded-xl border-emerald-300 hover:border-emerald-400 hover:shadow-md">
        <div class="flex items-start space-x-4">
            {{-- Ícone --}}
            <div class="flex-shrink-0">
                <div class="p-3 transition-colors duration-300 rounded-lg bg-emerald-50 group-hover:bg-emerald-100">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>

            {{-- Conteúdo principal --}}
            <div class="flex-1 min-w-0">
                <label for="anexo_pdf_minuta_contrato" class="block mb-2 text-sm font-semibold cursor-pointer text-emerald-700">
                    📎 Anexar PDF Minuta do Contrato
                </label>

                <div class="relative">
                    <input type="file" id="anexo_pdf_minuta_contrato" name="anexo_pdf_minuta_contrato" accept="application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="document.getElementById('minuta_contrato').textContent = this.files[0]?.name || 'Nenhum arquivo selecionado'">

                    <div class="flex items-center justify-between px-4 py-3 transition-colors duration-200 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                        <span id="minuta_contrato" class="text-sm font-medium text-gray-500">Clique para selecionar um arquivo</span>
                        <div class="flex items-center space-x-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span class="text-xs font-medium">PDF</span>
                        </div>
                    </div>
                </div>

                <p class="flex items-center mt-2 text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    O arquivo será anexado
                    automaticamente ao documento
                    gerado
                </p>
            </div>

            {{-- Botões de ação --}}
            <div class="flex flex-col items-center pt-1 space-y-2">
                <button type="button" @click="saveField('anexo_pdf_minuta_contrato')" x-show="!confirmed.anexo_pdf_minuta_contrato" class="p-2 text-white transition-all duration-200 transform rounded-lg shadow-sm bg-emerald-500 hover:bg-emerald-600 hover:scale-105 hover:shadow-md" title="Confirmar arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <button type="button" @click="toggleConfirm('anexo_pdf_minuta_contrato')" x-show="confirmed.anexo_pdf_minuta_contrato" class="p-2 text-white transition-all duration-200 transform bg-red-500 rounded-lg shadow-sm hover:bg-red-600 hover:scale-105 hover:shadow-md" title="Remover arquivo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @elseif($campo === 'pregoeiro')
    <div class="flex items-start space-x-2">
        <div class="flex-1">
            <label for="pregoeiro" class="block mb-1 text-sm font-medium text-gray-700">
                PREGOEIRO
            </label>
            <select id="pregoeiro" x-model="pregoeiro" :disabled="confirmed
                                                                                            .pregoeiro" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#009496] focus:border-[#009496] sm:text-sm">
                <option value="">Selecione
                    uma unidade</option>
                @foreach ($processo->prefeitura->unidades as $unidade)
                <option value="{{ $unidade->nome }}" {{ ($processo->detalhe->pregoeiro ?? '') == $unidade->nome ? 'selected' : '' }}>
                    {{ $unidade->nome }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex pt-6 space-x-1">
            <button type="button" @click="saveField('pregoeiro')" x-show="!confirmed.pregoeiro" :disabled="!
                                                                                        pregoeiro" class="px-3 py-2 text-white transition rounded-lg" :class="!
                                                                                        pregoeiro
                                                                                            ?
                                                                                            'bg-gray-400 cursor-not-allowed' :
                                                                                            'bg-green-500 hover:bg-green-600'">
                ✔
            </button>
            <button type="button" @click="toggleConfirm('pregoeiro')" x-show="confirmed.pregoeiro" class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                ✖
            </button>
        </div>
    </div>
    @elseif($campo === 'numero_items')
    <x-form-field name="numero_items" label="Numero Items" />

    @endif
</div>
