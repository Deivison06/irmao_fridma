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

        @font-face {
            font-family: 'AptosExtraBold';
            src: url('{{ public_path('storage/fonts/Aptos-ExtraBold.ttf') }}') format('truetype');
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

            text-align: justify;
            text-justify: inter-word;
            line-height: 1;
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
            width: 60%;
            font-size: 18pt;
            font-weight: 900;
            border: 2px solid #000;
            display: inline-block;
            line-height: 0.9;
            padding: 10px 50px;
            font-family: 'AptosExtraBold', sans-serif;
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

        /* ---------------------------------- */
        /* ESTILOS - CONTEÚDO PRINCIPAL */
        /* ---------------------------------- */
        .container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .conteudo-all {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            transform: translate(-50%, -50%);
            text-align: left;
        }

        .title {
            margin-left: -85px;
            font-weight: bold;
            font-size: 20pt;
            background: #bebebe;
            border: 1px solid #7a7a7a;
            padding: 5px 50px;
            display: inline-block;
            margin-bottom: 20px;
            text-align: center;
        }

        .section {
            margin-bottom: 15px;
        }

        .justify {
            margin-top: 20px;
            text-indent: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td.icon {
            width: 80px;
            text-align: center;
            vertical-align: middle;
        }

        td.content {
            vertical-align: middle;
            padding-left: 10px;
        }

    </style>
</head>

<body>

    <div>
        <p style="font-weight: bold; text-align: center; font-size: 14pt;">
            PROCESSO ADMINISTRATIVO <br>
            {{ $processo->numero_processo }} <br>
            {{ $processo->modalidade->getDisplayName() }} <br>
            {{ $processo->numero_procedimento }}
        </p>
        <p style="text-align: center;">
            <span style="font-size: 14pt;">OBJETO:</span> <br>
            {!! strip_tags($processo->objeto) !!}
        </p>
        <p>
            <span style="font-weight: bold;">VALOR TOTAL DA CONTRATAÇÃO</span> <br>
            {{ $detalhe->valor_estimado }}<br>
            <span style="font-weight: bold;">DATA LIMITE PARA ENVIO DE PROPOSTAS</span> <br>
            DIA XX/XX/2025 às XX:00h (Horário de Brasília)<br>
            <span style="font-weight: bold;">DATA DA SESSÃO PÚBLICA E FASE DE LANCES</span> <br>
            DIA XX/XX/2025 às XX:01h (Horário de Brasília)<br>
            <span style="font-weight: bold;">PORTAL UTILIZADO:</span> XXXXXX <br>
            <span style="font-weight: bold;">HORÁRIO:</span> ____:____ (HORÁRIO DE BRASÍLIA/DF)<br>
            <span style="font-weight: bold;">E-MAIL:</span> {{ $processo->prefeitura->email }}<br><br>
            <span style="font-weight: bold;">PREGOEIRO</span><br>
            XXXXXXXXXXXXXXXXXXX<br>
            <span style="font-weight: bold;">AUTORIDADE COMPETENTE</span><br>
            {{ $processo->prefeitura->autoridade_competente }}
        </p>

    </div>
    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>
    <div>
        <table style="border-collapse: collapse; width: 100%; text-align: left; border: 1px solid black; margin-top: 20px;">
            <thead>
                <tr>
                    <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; padding: 5px; background-color:#e8e8e8;">
                        CRITÉRIOS ESPECÍFICOS DA CONTRATAÇÃO
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold; width: 40%;">
                        CRITÉRIO DE JULGAMENTO
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        MENOR PREÇO
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        FORMA DE ADJUDICAÇÃO
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        POR {{ $processo->tipo_contratacao }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        MODO DE DISPUTA
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        ABERTO
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        INTERVALO ENTRE OS LANCES
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        XXXXXX (CAMPO LIVRE)
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        REGIME DE EXECUÇÃO
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        EMPREITADA POR PREÇO GLOBAL
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        EXIGÊNCIA DE GARANTIA DE PROPOSTA
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        NÃO OU SIM CAMPO PARA MARCAR
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        EXIGÊNCIA DE GARANTIA DE CONTRATO
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        NÃO OU SIM CAMPO PARA MARCAR
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        PERMITE PARTICIPAÇÃO DE CONSÓRCIO
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        NÃO
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        HAVERÁ INVERSÃO A FASE DE HABILITAÇÃO?
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        SIM OU NÃO NÃO OU SIM CAMPO PARA MARCAR
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        PRAZO DE VALIDADE DA PROPOSTA
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        90 (noventa) DIAS
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="border-collapse: collapse; width: 100%; text-align: left; border: 1px solid black; margin-top: 20px;">
            <thead>
                <tr>
                    <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; padding: 5px; background-color:#e8e8e8;">
                        DOS BENEFÍCIOS ÀS MICROEMPRESAS E EMPRESAS DE PEQUENO PORTE
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold; width: 40%;">
                        Itens destinados a participação exclusivamente<br>
                        para MEI/ME/EPP, cujo valor seja de até R$<br>
                        80.000,00 (oitenta mil reais)?<br>
                        (Art. 48, I, Lei Complementar nº 123/2006)<br>
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        SIM ou NÃO NÃO OU SIM CAMPO PARA MARCAR
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        Itens com reserva de cotas destinados a<br>
                        participação exclusivamente para MEI/ME/EPP?<br>
                        (Art. 48, III, Lei Complementar nº 123/06)<br>
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        SIM (25%) ou NÃO NÃO OU SIM CAMPO PARA MARCAR
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-weight: bold;">
                        Prioridade de contratação para MEI/ME/EPP<br>
                        sediadas local ou regionalmente, até o limite de<br>
                        10% (dez por cento) do melhor preço válido?<br>
                        (Art. 48, §3º, Lei Complementar nº 123/06)<br>
                    </td>
                    <td style="border: 1px solid black; padding: 5px;">
                        SIM (LOCAL ou REGIONAL) ou NÃO NÃO OU CAMPO PARA MARCAR
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Bloco de data e assinatura --}}
    <div class="footer-signature">
        {{ preg_replace('/Prefeitura (Municipal )?de /', '', $processo->prefeitura->nome) }},
        {{ \Carbon\Carbon::parse($dataSelecionada)->translatedFormat('d \d\e F \d\e Y') }}
    </div>

    @php
    // Verifica se a variável $assinantes existe e tem itens
    $hasSelectedAssinantes = isset($assinantes) && count($assinantes) > 0;
    @endphp

    @if ($hasSelectedAssinantes)
    {{-- Renderiza APENAS O PRIMEIRO assinante da lista --}}
    @php
    $primeiroAssinante = $assinantes[0]; // Pega o segundo item
    @endphp

    <div style="margin-top: 40px; text-align: center;">
        <div class="signature-block" style="display: inline-block; margin: 0 40px;">
            ___________________________________<br>
            <p style="font-size: 10pt; line-height: 1.2;">
                {{ $primeiroAssinante['responsavel'] }} <br>
                <span style="color: #4b5563;">{{ $primeiroAssinante['unidade_nome'] }}</span>
            </p>
        </div>
    </div>
    @else
    {{-- Bloco Padrão (Fallback) --}}
    <div class="signature-block" style="margin-top: 40px; text-align: center;">
        ___________________________________<br>
        <p style="font-size: 10pt; line-height: 1.2;">
            {{ $processo->prefeitura->autoridade_competente }} <br>
            <span style="color: red;">[Pregoeira/Agente de Contratação]</span>
        </p>
    </div>
    @endif

</body>

</html>
