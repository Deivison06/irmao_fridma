<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formalização de Demanda - Processo {{ $processo->numero_processo ?? $processo->id }}</title>
    <style>
        /* Estilos de Página e Fonte */
        @page {
            margin: 2cm;
            size: A4;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Título Principal */
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* Estrutura Principal da Tabela do Formulário */
        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        /* Estilo da Borda para Todas as Células */
        .form-table td,
        .form-table th,
        .inner-table td {
            border: 1px solid #000;
            padding: 0;
            vertical-align: top;
            font-size: 12px;
        }

        /* Célula de Cabeçalho da Seção (1, 2, 3) */
        .section-header {
            background-color: #dcdcdc;
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            padding: 8px;
            border: 1px solid #000;
        }

        /* Estilo para o Rótulo (Label) do Campo: Fica no topo da célula */
        .field-label {
            font-weight: bold;
            font-size: 11px;
            color: #000;
            padding: 5px 8px 0 8px;
            display: block;
        }

        /* Estilo para o Valor (Conteúdo) do Campo: Expande verticalmente */
        .field-value {
            min-height: 25px;
            padding: 0 8px 5px 8px;
            display: block;
            box-sizing: border-box;
            word-wrap: break-word;
        }

        /* Estilo para Células de Altura Maior (Demanda/Justificativa) */
        .large-value-cell {
            min-height: 60px;
            padding: 0 8px 5px 8px;
            text-align: justify;
            word-wrap: break-word;
        }

        /* Checkboxes */
        .checkbox-area {
            padding: 8px;
        }

        .checkbox-label {
            display: inline-block;
            margin-right: 20px;
            font-size: 12px;
        }

        .checkbox-box {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 5px;
            vertical-align: middle;
            text-align: center;
            line-height: 10px;
            font-size: 10px;
            font-weight: bold;
        }

        /* Layout de Duas Colunas para Instrumento e Vigência */
        .two-columns {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .two-columns td {
            width: 50%;
            vertical-align: top;
            padding: 0;
            border: none;
        }

        .inner-table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Rodapé de Lei e Blocos Informativos Finais (Contém borda e impede quebra) */
        .footer-law {
            margin-top: 5px;
            border: 1px solid #000;
            text-align: left;
            font-size: 12px;
            padding: 8px;
            background-color: #f9f9f9;
            page-break-inside: avoid;
        }

        .footer-law .field-label {
            background-color: transparent;
            padding: 0 5px 0 0;
            display: inline;
        }
    </style>
</head>

<body>

    <div class="title">
        DOCUMENTO FORMALIZAÇÃO DE DEMANDA
    </div>

    @if ($detalhe)
        <table class="form-table">
            <tr>
                <td colspan="1" class="section-header">1 – IDENTIFICAÇÃO DO ÓRGÃO REQUISITANTE</td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Secretaria:</span>
                    <span class="field-value">{{ $detalhe->secretaria ?? 'SECRETARIA DE EDUCACAO' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Unidade/Setor/Departamento:</span>
                    <span class="field-value">{{ $detalhe->unidade_setor ?? 'Unidade 1' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Servidor responsável pela demanda:</span>
                    <span class="field-value">{{ $detalhe->servidor_responsavel ?? 'Deivison' }}</span>
                </td>
            </tr>
        </table>

        <table class="form-table">
            <tr>
                <td class="section-header">2 – IDENTIFICAÇÃO DO OBJETO</td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Demanda:</span>
                    <div class="large-value-cell">
                        {{ $detalhe->demanda ?? 'CONTRATAÇÃO DE EMPRESA PARA PRESTAÇÃO DE SERVIÇOS DE COMUNICAÇÃO VISUAL, VISANDO ATENDER ÀS DEMANDAS DA PREFEITURA MUNICIPAL DE CURIMATÁ E SUAS SECRETARIAS.' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Justificativa da necessidade da contratação:</span>
                    <div class="large-value-cell">
                        {{ $detalhe->justificativa ?? 'Prestação de serviços de comunicação visual, visando atender às demandas da Prefeitura Municipal de Curimatá e suas Secretarias. A contratação de serviços de comunicação visual mostra-se essencial para atender às necessidades da Prefeitura Municipal de Curimatá e de suas diversas Secretarias. Tais serviços são fundamentais para garantir a divulgação adequada de ações institucionais, campanhas e equipamentos públicos.' }}
                    </div>
                </td>
            </tr>
        </table>

        <table class="form-table">
            <tr>
                <td colspan="2" class="section-header">3 – OBSERVAÇÕES GERAIS</td>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <span class="field-label">Prazo de entrega/execução:</span>
                    <span class="field-value">{{ $detalhe->prazo_entrega ?? '02 (dois) dias, contados da Ordem de Serviço, em remessa parcelada de acordo com a necessidade da Administração.' }}</span>
                </td>
                <td style="width: 50%;">
                    <span class="field-label">Local(is) e horário(s) de entrega:</span>
                    <span class="field-value">{{ $detalhe->local_entrega ?? 'Os bens deverão ser entregues na sede da Prefeitura Municipal.' }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="field-label" style="padding-bottom: 5px;">Houve contratações anteriores?</span>
                    <div class="checkbox-area">
                        @php
                            $contratacoes = strtolower($detalhe->contratacoes_anteriores ?? 'sim');
                        @endphp
                        <div class="checkbox-label">
                            <span class="checkbox-box">{{ $contratacoes == 'sim' ? 'X' : '' }}</span> Sim
                        </div>
                        <div class="checkbox-label">
                            <span class="checkbox-box">{{ $contratacoes == 'nao' ? 'X' : '' }}</span> Não
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="two-columns">
            <tr>
                <td>
                    <table class="inner-table">
                        <tr>
                            <td class="section-header">Instrumento Vinculativo</td>
                        </tr>
                        <tr>
                            <td class="checkbox-area">
                                @php
                                    $vinculativo = is_array($detalhe->instrumento_vinculativo ?? null)
                                        ? $detalhe->instrumento_vinculativo
                                        : ['contrato'];
                                    $outro_vinculativo = $detalhe->instrumento_vinculativo_outro ?? '________________';
                                @endphp
                                <div class="checkbox-label" style="display: block;">
                                    <span
                                        class="checkbox-box">{{ in_array('contrato', $vinculativo) ? 'X' : '' }}</span>
                                    Contrato
                                </div>
                                <div class="checkbox-label" style="display: block;">
                                    <span
                                        class="checkbox-box">{{ in_array('ata_registro_precos', $vinculativo) ? 'X' : '' }}</span>
                                    Ata de Registro de Preços
                                </div>
                                <div class="checkbox-label" style="display: block;">
                                    <span class="checkbox-box">{{ in_array('outro', $vinculativo) ? 'X' : '' }}</span>
                                    Outro: <span
                                        style="font-weight: normal; text-decoration: underline;">{{ $outro_vinculativo }}</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="inner-table">
                        <tr>
                            <td class="section-header">Prazo de Vigência do Objeto</td>
                        </tr>
                        <tr>
                            <td class="checkbox-area">
                                @php
                                    $vigencia = is_array($detalhe->prazo_vigencia ?? null)
                                        ? $detalhe->prazo_vigencia
                                        : ['12_meses'];
                                    $outro_vigencia = $detalhe->prazo_vigencia_outro ?? '________________';
                                    $objeto_continuado = strtolower($detalhe->objeto_continuado ?? 'nao');
                                @endphp
                                <div class="checkbox-label" style="display: block;">
                                    <span
                                        class="checkbox-box">{{ in_array('exercicio_financeiro', $vigencia) ? 'X' : '' }}</span>
                                    Exercício financeiro da contratação (até 31/12).
                                </div>
                                <div class="checkbox-label" style="display: block;">
                                    <span class="checkbox-box">{{ in_array('12_meses', $vigencia) ? 'X' : '' }}</span>
                                    Vigência de 12 meses.
                                </div>
                                <div class="checkbox-label" style="display: block;">
                                    <span class="checkbox-box">{{ in_array('outro', $vigencia) ? 'X' : '' }}</span>
                                    Outro: <span
                                        style="font-weight: normal; text-decoration: underline;">{{ $outro_vigencia }}</span>
                                </div>

                                <div style="border-top: 1px solid #000; margin-top: 10px; padding-top: 10px;">
                                    <span class="field-label" style="padding: 0; display: block;">Contratação de objeto
                                        continuado:</span>
                                    <div class="checkbox-label">
                                        <span class="checkbox-box">{{ $objeto_continuado == 'sim' ? 'X' : '' }}</span>
                                        Sim
                                    </div>
                                    <div class="checkbox-label">
                                        <span class="checkbox-box">{{ $objeto_continuado == 'nao' ? 'X' : '' }}</span>
                                        Não
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- USANDO SOMENTE .footer-law para garantir borda, fundo e page-break-inside: avoid --}}
        <div class="footer-law" style="margin-bottom: 5px;">
            <span class="field-label">Regime licitatório adotado:</span>
            Lei 14.133/2021 e legislação correlata.
        </div>

        {{-- USANDO .footer-law para garantir borda, fundo e page-break-inside: avoid, e alinhamento central --}}
        <div class="footer-law" style="text-align: center; margin-top: 5px;">
            Despacho a Solicitação à Autoridade Competente, para a devida autorização acerca da elaboração de Estudos
            Técnicos Preliminares.
        </div>

        @php
            \Carbon\Carbon::setLocale('pt_BR');
        @endphp

        {{-- Bloco de data e assinatura --}}
        <div style="margin-top: 60px; text-align: right; font-size: 12px;">
            {{ $processo->prefeitura->nome }},
            {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}
        </div>


        <div style="margin-top: 60px; text-align: center; font-size: 12px;">
            ___________________________________<br>
            {{ $processo->prefeitura->autoridade_competente }} <br>
            {{ $detalhe->secretaria ?? 'SECRETARIA DE EDUCACAO' }}
        </div>

    @else
        <div style="text-align: center; color: #cc0000; font-style: italic; margin-top: 50px;">
            Nenhum detalhe de formalização de demanda encontrado para este processo.
        </div>
    @endif

</body>

</html>
