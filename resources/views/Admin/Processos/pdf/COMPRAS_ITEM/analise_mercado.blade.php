<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>ANÁLISE DE MERCADO (PESQUISA DE PRECOS) - Processo {{ $processo->numero_processo ?? $processo->id }}</title>
    <style type="text/css">
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

        /* CLASSE PARA FORÇAR QUEBRA DE PÁGINA */
        .page-break {
            page-break-after: always;
        }

        /* ---------------------------------- */
        /* ESTILOS - CAPA DO DOCUMENTO (PÁGINA 0) */
        /* ---------------------------------- */
        #cover-page {
            height: 100vh;
            width: 100%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .cover-image {
            width: 350px;
            height: 350px;
            margin-bottom: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .cover-title {
            width: 80%;
            font-family: 'montserrat', sans-serif;
            font-size: 20pt;
            font-weight: 900;
            padding: 10px;
            border: 2px solid #000;
            background-color: #fff;
            color: #000;
            display: inline-block;
        }

        .footer-signature {
            margin-top: 60px;
            text-align: right;
        }

        .signature-block {
            margin-top: 60px;
            text-align: center;
        }

        /* Estilos opcionais para simular as linhas da imagem */
        .line {
            border-top: 2px solid black;
            margin: 10px 0;
            /* Espaçamento entre as linhas */
        }

        .content {
            text-align: center;
        }

        strong {
            font-size: 18x;
            font-weight: bold;
            line-height: 1.5;
            display: block;
        }
    </style>
</head>

<body>

    {{-- ====================================================================== --}}
    {{-- BLOCO 1: CAPA DO DOCUMENTO --}}
    {{-- ====================================================================== --}}
    <div id="cover-page">
        <img src="{{ public_path('icons/capa-documento.png') }}" alt="Martelo da Justiça" class="cover-image">
        <div class="cover-title">
            ANÁLISE DE MERCADO <br>
            (PESQUISA DE PRECOS)
        </div>
    </div>

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 2: RESUMO DOS DADOS DO PROCESSO --}}
    {{-- ====================================================================== --}}
    <div id="resumo-dados-processo">
        <table
            style="border-collapse: collapse; width: 100%; text-align: left; border: 1px solid black; margin-top: 100px;">
            <thead>
                <tr>
                    <td colspan="2"
                        style="border: 1px solid black; text-align: center; font-weight: bold; padding: 5px;">
                        RESUMO DOS DADOS DO PROCESSO
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold; width: 40%;">
                        Nº PROCESSO ADMINISTRATIVO:
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        {{ $processo->numero_processo }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        Nº PROCESSO DE CONTRATAÇÃO:
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        {{ $processo->numero_procedimento }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        OBJETO
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        {{ $processo->objeto }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        MODALIDADE:
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        {{ $processo->modalidade?->getDisplayName() }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        ÓRGÃO RESPONSÁVEL:
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        {{ $detalhe->unidade_setor }}
                    </td>
                </tr>
            </tbody>
        </table>

        <p style="text-indent: 30px">
            A Secretaria Municipal de XXXXXXXXX, encaminhou para esta unidade a necessidade
            de realização de Cotação referente a itens relacionados ao objeto
            <strong>“XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX”</strong>, ato
            seguido, foi realizado a cotação junto ao Painel de Preços do TCE-PI, conforme tabela abaixo:
        </p>

        <table style="border-collapse: collapse; width: 100%; font-size: 12px; text-align: center;">
            <thead>
                <tr>
                    <th colspan="6"
                        style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                        RESUMO
                    </th>
                </tr>
                <tr>
                    <th style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                        ITEM
                    </th>
                    <th style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                        VALOR TCE 1
                    </th>
                    <th style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                        VALOR TCE 2
                    </th>
                    <th style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                        VALOR TCE 3
                    </th>
                    <th style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                        FORNECEDOR LOCAL
                    </th>
                    <th style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                        MÉDIA
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; padding: 5px;">NOME DO ITEM</td>
                    <td style="border: 1px solid black; padding: 5px;">VALOR</td>
                    <td style="border: 1px solid black; padding: 5px;">VALOR</td>
                    <td style="border: 1px solid black; padding: 5px;">VALOR</td>
                    <td style="border: 1px solid black; padding: 5px;">VALOR</td>
                    <td style="border: 1px solid black; padding: 5px;">VALOR MÉDIO</td>
                </tr>
            </tbody>
        </table>
        <p>Segue em anexo arquivos referentes à cotação realizada.</p>
        <p>Encaminhe-se à XXXXXXX para a VERIFICAÇÃO DE DOTACÃO ORÇAMENTÁRIA EXISTENTE.</p>

        {{-- Bloco de data e assinatura --}}
        <div class="footer-signature">
            {{ $processo->prefeitura->nome }},
            {{ \Carbon\Carbon::parse($dataSelecionada)->translatedFormat('d \d\e F \d\e Y') }}
        </div>

        <div class="signature-block">
            ___________________________________<br>
            {{ $processo->prefeitura->autoridade_competente }} <br>
            {{ $detalhe->secretaria ?? 'SECRETARIA DE EDUCACAO' }}
        </div>
    </div>

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 3: ANEXOS PESQUISA OBTIDAS --}}
    {{-- ====================================================================== --}}
    <div id="anexos-pesquisa-obtidas">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>

        <div class="content">
            <strong>
                ANEXOS PESQUISA OBTIDAS EM OUTAS FONTES COMO<br>
                TCE, PAINEL DE PRECOS, PNCP, BANCO DE DADOS<br>
                SAÚDE<br>
                E PORTARIAS
            </strong>
        </div>

        <div class="line"></div>
    </div>


</body>

</html>
