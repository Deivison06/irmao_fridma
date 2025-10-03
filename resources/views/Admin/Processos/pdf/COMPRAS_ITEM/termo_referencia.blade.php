<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>TERMO DE REFERÊNCIA - Processo {{ $processo->numero_processo ?? $processo->id }}</title>
    <style type="text/css">
        @font-face {
            font-family: 'Aptos';
            src: url('{{ public_path('storage/fonts/Aptos.ttf') }}') format('truetype');
            font-style: normal;
        }

        @page {
            margin: 0;
            size: A4;
        }

        body {
            margin: 0;
            padding: 3cm 2cm;
            font-size: 11pt;
            font-family: 'Aptos', sans-serif;
            /* Adiciona o timbre como background */
            background-image: url('{{ public_path($prefeitura->timbre) }}');
            background-repeat: no-repeat;
            background-position: top left;
            background-size: cover;
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
            padding: 10 30px;
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
            /* Centraliza o texto como na imagem */
            margin: 40px 0;
            /* Espaçamento acima e abaixo do conteúdo principal */
        }

        strong {
            line-height: 1.5;
            /* Melhora a leitura do texto em várias linhas */
            display: block;
            /* Garante que o strong ocupe a largura total */
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
            TERMO DE REFERÊNCIA
        </div>
    </div>

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    <div id="termo_referencia">
        <p style="color: red; text-align: center;">SECRETARIA MUNICIPAL DE XXXXXX </p>
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

        <p style="text-indent: 30px; margin-top: 20px; text-align: justify;">
            Esta Secretaria solicitou a elaboração de ETP, Mapa de Riscos, Cotação de Mercado e emissão de Dotação
            Orçamentária acerca da XXXXXXXXXXXXXXXXXXXXXXXXXXXXX, após sanada as solicitações, foi elaborado o Termo de
            Referência, encaminha-se para:
        </p>

        <p style="text-indent: 30px; ">Encaminhe-se à XXXXXXX para a ELABORAÇÃO DE EDITAL E MINUTA DE CONTRATO.</p>
        <p style="text-indent: 30px; "> Encaminhe-se à XXXXXXX para a ELABORAÇÃO DE PARECER JURÍDICO</p>.</p>
        <p style="text-indent: 30px; ">Encaminhe-se à XXXXXXX para a AUTORIZAÇÃO DE ABERTURA DE PROCEDIMENTO PELA
            AUTORIDADE COMPETENTE </p>

        <table style="border-collapse: collapse; width: auto; border: 1px solid black;">
            <tr>
                <td style="border: 1px solid black; padding: 6px; font-weight: normal;">
                    Forma indicada da contratação:
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 8px;">
                    <div style="display: block; margin-bottom: 4px;">
                        <span
                            style="display:inline-block; width:12px; height:12px; border:1px solid #000; margin-right:5px; vertical-align:middle; text-align:center; line-height:10px; font-size:10px; font-weight:bold;"></span>
                        Dispensa de Licitação;
                    </div>
                    <div style="display: block; margin-bottom: 4px;">
                        <span
                            style="display:inline-block; width:12px; height:12px; border:1px solid #000; margin-right:5px; vertical-align:middle; text-align:center; line-height:10px; font-size:10px; font-weight:bold;">X</span>
                        Pregão Eletrônico;
                    </div>
                    <div style="display: block;">
                        <span
                            style="display:inline-block; width:12px; height:12px; border:1px solid #000; margin-right:5px; vertical-align:middle; text-align:center; line-height:10px; font-size:10px; font-weight:bold;"></span>
                        Concorrência.
                    </div>
                </td>
            </tr>
        </table>

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

</body>

</html>
