<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Minutas - Processo {{ $processo->numero_processo ?? $processo->id }}</title>
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
            padding: 10 30px;
            border: 2px solid #000;
            background-color: #fff;
            color: #000;
            display: inline-block;
        }

        .footer-signature {
            margin-top: 60px;
            text-align: center;
            color: red;
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
            AUTORIZAÇÃO ABERTURA PROCEDIMENTO LICITATÓRIO
        </div>
    </div>

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 2: AUTORIZAÇÃO DE ABERTURA DE PROCEDIMENTO DE LICITAÇÃO --}}
    {{-- ====================================================================== --}}
    <div id="autorizacao-abertura-procedimento">
        <p style="text-align: center; font-weight: bold">AUTORIZAÇÃO DE ABERTURA DE PROCEDIMENTO DE LICITAÇÃO <br> PROCESSO
            ADMINISTRATIVO N° XXX/2025</p>

        <p>
            Ao(À) Ilmo(a). Sr(a).<br>
            <span style="color: red">XXXXXXXXXXXXXXXXXXX</span>
            <br>
            Agente de Contratação / Pregoeiro
            <br>
            <span style="color: red">
                Prefeitura de XXXXXXXXXXX - PI
            </span>
        </p>

        <p><span style="background-color: yellow">Assunto: Autorização</span> para Abertura de Pregão Eletrônico </p>

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
            Senhor(a) Agente de Contratação / Pregoeiro
        </p>
        <p style="text-indent: 30px">
            Trata-se de demanda da Secretaria Municipal de XXXXXXXXXXXX, para contratação de
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX.
        </p>
        <p style="text-indent: 30px">
            O valor estimado para pretendida contratação é de R$ XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
            (XXXXXXXXXXXX),
            conforme Relatório de Pesquisa de Preços.
        </p>

        <p style="text-indent: 30px">
            O Setor de Contabilidade, através da DECLARAÇÃO DE COMPATIBILIDADE DA
            PREVISÃO DE RECURSOS ORÇAMENTÁRIOS, certifica a existência de dotação orçamentária
            para suportar a presente despesa, demonstrando a compatibilidade da previsão de recursos
            orçamentários com o compromisso a ser assumido.
        </p>
        <p style="text-indent: 30px">
            Por todo o exposto, considerando que a instrução do presente processo atende ao disposto
            na Lei nº 14.133, de 2021, aprovo os atos praticados e autorizo que seja promovida a abertura de
            Procedimento de Licitação, na modalidade Pregão, em sua forma Eletrônica, nos termos da Lei nº
            14.133, de 2021.
        </p>
        <p style="text-indent: 30px">
            Por fim, declaro, para os efeitos do art. 16, II da Lei Complementar nº 101, de 04 de maio
            de 2000 (Lei de Responsabilidade Fiscal), que a despesa da pretendida contratação, possui
            adequação orçamentária e financeira com a Lei Orçamentária Anual (LOA) e compatibilidade com
            o Plano Plurianual (PPA) e com a Lei de Diretrizes Orçamentária (LDO).
        </p>

        <p>
            CLASSIFICAÇÃO DO OBJETO: COMPRAS
        </p>
        <p>
            JUSTIFICATIVA DA CONTRATAÇÃO:
            <br><br>
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX XXXXXXXXXXXXXXXXXXXXXXX
        </p>
        <p>MODALIDADE: PREGÃO ELETRÔNICO</p>
        <p>MODO DE DISPUTA: ABERTO</p>
        <p>TRATAMENTO DIFERENCIA A MEs e EPPs</p>
        <p>
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX.
        </p>
        {{-- Bloco de data e assinatura --}}
        <div class="footer-signature">
            {{ $processo->prefeitura->nome }},
            {{ \Carbon\Carbon::parse($dataSelecionada)->translatedFormat('d \d\e F \d\e Y') }}
        </div>

        <div class="signature-block">
            ___________________________________<br>
            <span style="color: red;">XXXXXXXXXXXXXXXXX</span> <br>
            Prefeito Municipal
        </div>
    </div>
    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>
    {{-- ====================================================================== --}}
    {{-- BLOCO 3: PORTARIA DE AGENTE DE CONTRATAÇÃO E EQUIPE DE APOIO --}}
    {{-- ====================================================================== --}}
    <div id="anexos-pesquisa-obtidas">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>

        <div class="content">
            <strong>
                PORTARIA DE AGENTE DE CONTRATAÇÃO E <br>
                EQUIPE DE APOIO
            </strong>
        </div>

        <div class="line"></div>
    </div>
</body>

</html>
