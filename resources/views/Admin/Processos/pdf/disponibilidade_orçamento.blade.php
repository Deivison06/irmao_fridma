<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Estudo Técnico Preliminar - Processo {{ $processo->numero_processo ?? $processo->id }}</title>
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
            DISPONIBILIDADE <br>
            ORÇAMENTÁRIA
        </div>
    </div>

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 2: RESUMO DOS DADOS DO PROCESSO --}}
    {{-- ====================================================================== --}}
    <div>
        <p style="text-align: center; font-wfont-weight: bold;">DECLARAÇÃO DE COMPATIBILIDADE DA PREVISÃO DE RECURSOS
            ORÇAMENTÁRIOS</p>
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

        <p style="text-indent: 30px;">
            <strong>DECLARO</strong> para os fins de demonstração da compatibilidade da
            previsão de recursos orçamentários, com base no
            art. 72, IV da Lei 14.133/21, que a despesa da respectiva contratação estimada em R$ XXXXXXXXXXXXX
            (XXXXXXXXXXXXXXXXX)
            possui previsão de saldo orçamentário e financeiro compatível com a Lei Orçamentária Anual (LOA) e é
            compatível com o
            Plano Plurianual (PPA) e com a Lei de Diretrizes Orçamentárias (LDO) vigentes.
        </p>

        <p style="text-indent: 30px;">
            As despesas para atender a presente solicitação da demanda, encontram-se amparadas pelo seguinte
            detalhamento:
        </p>

        <div style="border: 1px solid black; display: flex; width: 600px; height: 300px;">
            <div
                style="flex: 1; padding: 10px; border-right: 1px solid black; font-family: sans-serif; font-size: 14px;">
                <p style="margin-top: 0; margin-bottom: 10px;">
                    <strong>Gestão/Unidade:</strong> [...]
                </p>
                <p style="margin-bottom: 10px;">
                    <strong>Fonte de Recursos:</strong> [...]
                </p>
                <p style="margin-bottom: 10px;">
                    <strong>Programa de Trabalho:</strong> [...]
                </p>
                <p style="margin-bottom: 10px;">
                    <strong>Elemento de Despesa:</strong> [...]
                </p>
                <p style="margin-bottom: 0;">
                    <strong>Plano Interno:</strong> [...]
                </p>
            </div>

            <div style="flex: 1;">
            </div>
        </div>

        <p>OU</p>

        <p style="color: red">
            Declaro, para os devidos fins, que a presente licitação será realizada sob a forma de <strong>Sistema de
                Registro de Preços (SRP)</strong>,
            nos termos do art. 82 e seguintes da Lei nº 14.133/2021.<br>
            Por se tratar de procedimento que visa apenas ao registro formal de preços, <strong>não há necessidade de
                indicação de dotação
                orçamentária nesta fase</strong>, ficando a alocação de recursos vinculada e obrigatória somente no
            momento da contratação
            efetiva, mediante emissão da Nota de Empenho correspondente, conforme as demandas das Secretarias/Órgãos
            requisitantes.<br>
            Tal medida encontra respaldo legal e visa garantir o adequado planejamento das contratações, respeitando os
            princípios da
            eficiência, economicidade e responsabilidade fiscal.
        </p>

        <p>Encaminhe-se ao DEMANDANTE para a elaboração do TERMO DE REFERÊNCIA</p>

        {{-- Bloco de data e assinatura --}}
        <div class="footer-signature">
            {{ \Carbon\Carbon::parse($dataSelecionada)->translatedFormat('d \d\e F \d\e Y') }}
        </div>

        <div class="signature-block">
            ___________________________________<br>
            <strong>
                {{ $processo->prefeitura->autoridade_competente }} <br>
                {{ $detalhe->secretaria ?? 'SECRETARIA DE EDUCACAO' }}
            </strong>
        </div>
    </div>


</body>

</html>
