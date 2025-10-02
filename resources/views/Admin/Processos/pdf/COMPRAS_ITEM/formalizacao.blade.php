<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formalização e Autorização - Processo {{ $processo->numero_processo ?? $processo->id }}</title>
    <style>
        /* ---------------------------------- */
        /* ESTILOS GERAIS E QUEBRA DE PÁGINA */
        /* ---------------------------------- */
        @font-face {
            font-family: 'Aptos';
            src: url('{{ public_path('storage/fonts/Aptos.ttf') }}') format('truetype');
            font-style: normal;
        }

        @page {
            margin: 2cm;
            size: A4;
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 11pt;
            font-family: 'Aptos', sans-serif;
        }

        /* CLASSE PARA FORÇAR QUEBRA DE PÁGINA (ESSENCIAL PARA PDF) */
        .page-break {
            page-break-after: always;
        }

        /* ---------------------------------- */
        /* ESTILOS - CAPA DO DOCUMENTO (PÁGINA 0) */
        /* ---------------------------------- */
        #cover-page {
            /* Define a área de referência como a página inteira */
            height: 100vh;
            width: 100%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .cover-image {
            /* Tamanho da imagem */
            width: 300px;
            height: 300px;
            margin-bottom: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .cover-title {
            font-size: 18pt;
            font-weight: 900;
            border: 2px solid #000;
            display: inline-block;
            line-height: 0.9;
            padding: 10px 50px;
        }

        /* ---------------------------------- */
        /* ESTILOS - FORMALIZAÇÃO DE DEMANDA (PÁGINA 1) */
        /* ---------------------------------- */

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .form-table td,
        .form-table th,
        .inner-table td {
            border: 1px solid #000;
            padding: 0;
            vertical-align: top;
        }

        .section-header {
            background-color: #e7e7e7;
            text-align: center;
            padding: 15px;
            border: 1px solid #000;
        }

        .field-label {
            color: #000;
            padding: 5px 8px 0 8px;
            display: block;
        }

        .field-value {
            /* min-height: 25px; */
            padding: 0 8px 5px 8px;
            display: block;
            box-sizing: border-box;
            word-wrap: break-word;
        }

        .large-value-cell {
            min-height: 60px;
            padding: 0 8px 5px 8px;
            text-align: justify;
            word-wrap: break-word;
        }

        .checkbox-area {
            padding: 20px;
        }

        .checkbox-label {
            display: inline-block;
            margin-top: 10px;
            margin-right: 20px;
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
            font-weight: bold;
        }

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

        .footer-law {
            margin-top: 5px;
            border: 1px solid #000;
            text-align: left;
            padding: 8px;
            page-break-inside: avoid;
        }

        /* ---------------------------------- */
        /* ESTILOS - AUTORIZAÇÃO (PÁGINA 2) */
        /* ---------------------------------- */

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .section {
            margin-bottom: 20px;
        }

        .auth-table {
            /* Renomeado para evitar conflito com .form-table */
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .auth-table td {
            border: 1px solid #000;
            /* padding: 5px; */
            vertical-align: top;
        }

        .no-border {
            border: none;
        }

        .table-title {
            background-color: #ebebeb;
        }

        .footer-signature {
            margin-top: 60px;
            text-align: right;
        }

        .signature-block {
            margin-top: 60px;
            text-align: center;
        }
    </style>
</head>

<body>
    {{-- ====================================================================== --}}
    {{-- BLOCO 1: CAPA DO DOCUMENTO --}}
    {{-- ====================================================================== --}}
    <div id="cover-page">
        {{-- Substitua 'caminho/para/capa-documento.png' pelo caminho real da sua imagem no sistema --}}
        <img src="{{ public_path('icons/capa-documento.png') }}" alt="Martelo da Justiça" class="cover-image">

        <div class="cover-title">
            DOCUMENTO DE FORMALIZAÇÃO DE<br>DEMANDA
        </div>
    </div>
    {{-- QUEBRA DE PÁGINA AQUI --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 2: FORMALIZAÇÃO DE DEMANDA --}}
    {{-- ====================================================================== --}}
    <div id="formalizacao-demanda">

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
                        <span
                            class="field-value">{{ $detalhe->prazo_entrega ?? '02 (dois) dias, contados da Ordem de Serviço, em remessa parcelada de acordo com a necessidade da Administração.' }}</span>
                    </td>
                    <td style="width: 50%;">
                        <span class="field-label">Local(is) e horário(s) de entrega:</span>
                        <span
                            class="field-value">{{ $detalhe->local_entrega ?? 'Os bens deverão ser entregues na sede da Prefeitura Municipal.' }}</span>
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

            <table class="two-columns" style="border: 1px solid #000; ">
                <tr>
                    <td style="border-right: 1px solid #000; padding:20px;">
                        <table class="inner-table">
                            <tr>
                                <td class="checkbox-area">
                                    @php
                                        $vinculativo = is_array($detalhe->instrumento_vinculativo ?? null)
                                            ? $detalhe->instrumento_vinculativo
                                            : ['contrato'];
                                        $outro_vinculativo =
                                            $detalhe->instrumento_vinculativo_outro ?? '________________';
                                    @endphp

                                    <div>Instrumento Vinculativo</div>
                                    <div class="checkbox-label" style="display: block; ">
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
                                        <span
                                            class="checkbox-box">{{ in_array('outro', $vinculativo) ? 'X' : '' }}</span>
                                        Outro: <span
                                            style="font-weight: normal; text-decoration: underline;">{{ $outro_vinculativo }}</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="padding:20px;">
                        <table class="inner-table">
                            <tr>
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
                                    <div>Prazo de Vigência do Objeto</div>
                                    <div class="checkbox-label" style="display: block;">
                                        <span
                                            class="checkbox-box">{{ in_array('exercicio_financeiro', $vigencia) ? 'X' : '' }}</span>
                                        Exercício financeiro da contratação (até 31/12).
                                    </div>
                                    <div class="checkbox-label" style="display: block;">
                                        <span
                                            class="checkbox-box">{{ in_array('12_meses', $vigencia) ? 'X' : '' }}</span>
                                        Vigência de 12 meses.
                                    </div>
                                    <div class="checkbox-label" style="display: block;">
                                        <span class="checkbox-box">{{ in_array('outro', $vigencia) ? 'X' : '' }}</span>
                                        Outro: <span
                                            style="font-weight: normal; text-decoration: underline;">{{ $outro_vigencia }}</span>
                                    </div>

                                    <div style="margin-top: 10px; padding-top: 10px;">
                                        <span class="field-label" style="padding: 0; display: block;">Contratação de
                                            objeto continuado:</span>
                                        <div class="checkbox-label">
                                            <span
                                                class="checkbox-box">{{ $objeto_continuado == 'sim' ? 'X' : '' }}</span>
                                            Sim
                                        </div>
                                        <div class="checkbox-label">
                                            <span
                                                class="checkbox-box">{{ $objeto_continuado == 'nao' ? 'X' : '' }}</span>
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
            <div class="footer-law" style="margin-bottom: 10px; padding-bottom: 20px;">
                <span>Regime licitatório adotado:</span><br>
                Lei 14.133/2021 e legislação correlata.
            </div>

            {{-- USANDO .footer-law para garantir borda, fundo e page-break-inside: avoid, e alinhamento central --}}
            <div class="footer-law" style="text-align: center; margin-top: 5px;">
                Despacho a Solicitação à Autoridade Competente, para a devida autorização acerca da elaboração de
                Estudos Técnicos Preliminares.
            </div>

            @php
                \Carbon\Carbon::setLocale('pt_BR');
            @endphp

            {{-- Bloco de data e assinatura --}}
            <div class="footer-signature">
                {{ preg_replace('/Prefeitura (Municipal )?de /', '', $processo->prefeitura->nome) }},
                {{ \Carbon\Carbon::parse($dataSelecionada)->translatedFormat('d \d\e F \d\e Y') }}
            </div>


            <div class="signature-block">
                ___________________________________<br>
                {{ $detalhe->servidor_responsavel }} <br>
                {{ $detalhe->unidade_setor ?? 'SECRETARIA DE EDUCACAO' }}
            </div>
        @else
            <div style="text-align: center; color: #cc0000; font-style: italic; margin-top: 50px;">
                Nenhum detalhe de formalização de demanda encontrado para este processo.
            </div>
        @endif
    </div>

    {{-- QUEBRA DE PÁGINA AQUI --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 3: AUTORIZAÇÃO PARA ESTUDO TÉCNICO --}}
    {{-- ====================================================================== --}}
    <div id="autorizacao-estudo">

        <div style=" text-align: center; font-weight:bold; margin-bottom:20px;">AUTORIZAÇÃO PARA ELABORAÇÃO DE ESTUDO
            TÉCNICO</div>

        <p style="text-indent: 30px">
            Fica <strong>AUTORIZADO</strong> a equipe de planejamento a dar início aos trabalhos de estudo e
            planejamento
            da com vistas evidenciar o problema a ser resolvido e identificar a melhor solução, de modo a permitir a
            avaliação da viabilidade técnica e econômica da contratação, respeitando-se os critérios mínimos
            estabelecidos no § 1º
            do artigo 18 da Lei 14.133/2021, conforme quadro resumo abaixo:
        </p>

        <div class="section">
            <table class="auth-table">
                <tr>
                    <td class="table-title" style="text-align: center;">UNIDADE SOLICITANTE</td>
                </tr>
                <tr>
                    <td class="center">{{ $detalhe->unidade_setor}}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="bold" style="margin-bottom:5px; text-align: center;">NECESSIDADE OBJETO DO ESTUDO:</div>

            <p style="text-align: center;">
                {{ $processo->objeto }}
            </p>

        </div>

        <div class="section">
            <table class="auth-table">
                <tr>
                    <td class="table-title" style="text-align: center;">EQUIPE DE PLANEJAMENTO</td>
                </tr>
                <tr>
                    <td class="center">{{ $detalhe->nome_equipe_planejamento ?? 'XXXXXXXXXXXXXXXXXXXXXXXX' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table class="auth-table">
                <tr>
                    <td>
                        <p style="text-align: center;">Despacho a Solicitação, para a devida elaboração de Estudos
                            Técnicos Preliminares.</p>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Bloco de data e assinatura --}}
        <div class="footer-signature">
            {{ preg_replace('/Prefeitura (Municipal )?de /', '', $processo->prefeitura->nome) }},
            {{ \Carbon\Carbon::parse($dataSelecionada)->translatedFormat('d \d\e F \d\e Y') }}
        </div>

        <div class="signature-block">
            ___________________________________<br>
            {{ $processo->prefeitura->autoridade_competente }} <br>
            Prefeito Municipal
        </div>

    </div>

</body>

</html>
