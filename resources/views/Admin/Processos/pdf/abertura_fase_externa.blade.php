<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Minutas - Processo {{ $processo->numero_processo ?? $processo->id }}</title>
    <style type="text/css">
        @page {
            margin: 2cm;
            size: A4;
        }

        body {
            font-family: 'montserrat', sans-serif;
            color: #000;
            margin: 0;
            padding: 0;
            width: 100%;
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
            ABERTURA FASE EXTERNA
        </div>
    </div>

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 2: TERMO DE RECEBIMENTO --}}
    {{-- ====================================================================== --}}
    <div id="termo-recebimento">
        <p style="font-weight: bold; text-align: center;">TERMO DE RECEBIMENTO </p>
        <table style="border-collapse: collapse; width: 100%; font-size: 12px;">
            <thead>
                <tr>
                    <th colspan="2"
                        style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                        RESUMO DOS DADOS DO PROCESSO
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold; width: 40%;">N° PROCESSO
                        ADMINISTRATIVO:</td>
                    <td style="border: 1px solid black; padding: 5px;">XXX/2025</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">N° PROCESSO DE CONTRATAÇÃO:
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">XXX/2025</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">OBJETO</td>
                    <td style="border: 1px solid black; padding: 5px;">XXXXXXXXXX</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">MODALIDADE:</td>
                    <td style="border: 1px solid black; padding: 5px;">PREGÃO ELETRÔNICO</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">ÓRGÃO RESPONSÁVEL:</td>
                    <td style="border: 1px solid black; padding: 5px;">SECRETARIA MUNICIPAL DE XXXXXXXX</td>
                </tr>
            </tbody>
        </table>

        <p>
            <span style="font-weight: bold;">DECLARO</span> que recebi o processo de Pregão Eletrônico, e verificadas as condições de
            regularidade procedo com a devida publicação, nos termos legais.
        </p>

        {{-- Bloco de data e assinatura --}}
        <div class="footer-signature">
            ____________________, ____ de _____________ de 20___
        </div>

        <div class="signature-block">
            ___________________________________<br>
            Agente de contratação
        </div>
    </div>

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 3: CERTIDÃO DE ENCERRAMENTO DA FASE PREPARATÓRIA --}}
    {{-- ====================================================================== --}}
    <div id="certidao-encerramento-fase-preparatoria">
        <p style="font-weight: bold; text-align: center;">
            CERTIDÃO DE ENCERRAMENTO <br>
            DA FASE PREPARATÓRI
        </p>
        <table style="border-collapse: collapse; width: 100%; font-size: 12px;">
            <thead>
                <tr>
                    <th colspan="2"
                        style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                        RESUMO DOS DADOS DO PROCESSO
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold; width: 40%;">N° PROCESSO
                        ADMINISTRATIVO:</td>
                    <td style="border: 1px solid black; padding: 5px;">XXX/2025</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">N° PROCESSO DE CONTRATAÇÃO:
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">XXX/2025</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">OBJETO</td>
                    <td style="border: 1px solid black; padding: 5px;">XXXXXXXXXX</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">MODALIDADE:</td>
                    <td style="border: 1px solid black; padding: 5px;">PREGÃO ELETRÔNICO</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">ÓRGÃO RESPONSÁVEL:</td>
                    <td style="border: 1px solid black; padding: 5px;">SECRETARIA MUNICIPAL DE XXXXXXXX</td>
                </tr>
            </tbody>
        </table>

        <p>
           <span style="font-weight: bold;">CERTIFICO</span> O ENCERRAMENTO DA FASE PREPARATÓRIA DO PROCESSO
            LICITATÓRIO, ENCONTRANDO-SE O FEITO DISPONÍVEL PARA A PUBLICAÇÃO DO
            AVISO DE LICITAÇÃO E DEMAIS
        </p>
        <p>ENCAMINHE-SE PARA O AGENTE CONDUTOR DA FASE DE SELEÇÃO DO FORNECEDOR PARA OS ATOS SUBSEQUENTES. </p>

        {{-- Bloco de data e assinatura --}}
        <div class="footer-signature">
            ____________________,EM ____ DE _____ 2025
        </div>

        <div class="signature-block">
            ___________________________________<br>
            <strong>XXXXXXXXXXX</strong>
        </div>
    </div>

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 4: TERMO DE AUTUAÇÃO --}}
    {{-- ====================================================================== --}}
    <div id="termo_autuacao">
        <p style="font-weight: bold; text-align: center;">TERMO DE AUTUAÇÃO </p>
        <p style="text-indent: 30px">
            No uso de minhas atribuições, em <span style="font-weight: bold;">XX de XXXXXXXXXX de 2025</span>, autuo o
            presente Processo de Contratação na modalidade Pregão Eletrônico, sob o número XXX/,
            originário do Processo Administrativo nº XXX/2025, que tem por finalidade
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX, com valor total estimado em
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX, e para
            constar, lavro e assino o presente Termo de Autuação.
        </p>
        <table style="border-collapse: collapse; width: 100%; font-size: 12px;">
            <thead>
                <tr>
                    <th colspan="2"
                        style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                        RESUMO DOS DADOS DO PROCESSO
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold; width: 40%;">N° PROCESSO
                        ADMINISTRATIVO:</td>
                    <td style="border: 1px solid black; padding: 5px;">XXX/2025</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">N° PROCESSO DE CONTRATAÇÃO:
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">XXX/2025</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">MODALIDADE:</td>
                    <td style="border: 1px solid black; padding: 5px;">PREGÃO ELETRÔNICO</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">ÓRGÃO RESPONSÁVEL:</td>
                    <td style="border: 1px solid black; padding: 5px;">SECRETARIA MUNICIPAL DE XXXXXXXX</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">OBJETO</td>
                    <td style="border: 1px solid black; padding: 5px;">RXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                        XXXXXXXXXXXXXXXXXXXXX</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">VALOR ESTIMADO:</td>
                    <td style="border: 1px solid black; padding: 5px;">RXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                        XXXXXXXXXXXXXXXXXXXXX</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">FUNDAMENTAÇÃO:</td>
                    <td style="border: 1px solid black; padding: 5px;">Lei 14.133/2021, Art. 28, I - Pregão Eletrônico
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Bloco de data e assinatura --}}
        <div class="footer-signature">
            {{ $processo->prefeitura->nome }},
            {{ \Carbon\Carbon::parse($dataSelecionada)->translatedFormat('d \d\e F \d\e Y') }}
        </div>

        <div class="signature-block">
            ___________________________________<br>
            XXXXXXXXXXXXXXXXXXXXXX<br>
            Pregoeira/Agente de Contratação
        </div>
    </div>

</body>

</html>
