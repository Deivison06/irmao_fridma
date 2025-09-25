<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Autorização para Estudo Técnico - Processo {{ $processo->id }}</title>
    <style>
        @page {
            margin: 2cm;
            size: A4;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        .no-border {
            border: none;
        }

        .large {
            min-height: 80px;
            text-align: justify;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .table-title {
            background-color: #ddd;
        }

        .footer {
            margin-top: 50px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="center bold" style="margin-bottom:20px;">AUTORIZAÇÃO PARA ELABORAÇÃO DE ESTUDO TÉCNICO</div>

    <p>Fica <strong>AUTORIZADO</strong> a equipe de planejamento a dar início aos trabalhos de estudo e planejamento da
        com vistas evidenciar o problema a ser resolvido e identificar a melhor solução, de modo a permitir a avaliação
        da viabilidade técnica e econômica da contratação, respeitando-se os critérios mínimos estabelecidos no § 1º do
        artigo 18 da Lei 14.133/2021, conforme quadro resumo abaixo:</p>

    <div class="section">
        <table>
            <tr>
                <td class="bold center table-title">UNIDADE SOLICITANTE</td>
            </tr>
            <tr>
                <td class="center">{{ $detalhe->secretaria ?? 'SECRETARIA MUNICIPAL DE XXXXXXXXXXXXX' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="bold" style="margin-bottom:5px; text-align: center;">NECESSIDADE OBJETO DO ESTUDO:</div>

        <p style="text-align: center;">
            {{ $processo->objeto ?? 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX' }}
        </p>

    </div>

    <div class="section">
        <table>
            <tr>
                <td class="bold center table-title">EQUIPE DE PLANEJAMENTO</td>
            </tr>
            <tr>
                <td class="center">{{ $detalhe->servidor_responsavel ?? 'XXXXXXXXXXXXXXXXXXXXXXXX' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <table>
            <tr>
                <td>
                    <p style="text-align: center;">Despacho a Solicitação, para a devida elaboração de Estudos Técnicos Preliminares.</p>
                </td>
            </tr>
        </table>

    </div>

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

</body>

</html>
