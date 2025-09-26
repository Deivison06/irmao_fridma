<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Estudo Técnico Preliminar - Processo {{ $processo->numero_processo ?? $processo->id }}</title>
    <style type="text/css">
        @page {
            margin: 0;
            padding: 0;
            size: A4;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            position: relative;
        }

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

        .conteudo {
            margin:0 90px ;
        }

        .title {
            font-weight: bold;
            font-size: 20px;
            background: #bebebe;
            border: 1px solid #7a7a7a;
            padding: 5px 10px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            margin-bottom: 3px;
        }

       .justify {
            text-align: justify;
            margin-top: 20px;
            text-indent: 20px; /* adiciona o recuo do parágrafo */
        }


        table {
            width: 100%;
            border-collapse: collapse;
        }

        td.icon {
            width: 50px;
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

    <div class="container">
        <div class="conteudo-all">
            <div style="margin: 30px 0 0;">
                <div class="title">ESTUDO TÉCNICO PRELIMINAR – ETP</div>
            </div>
            <div class="conteudo">
                <!-- Unidade Requisitante -->
                <div class="section">
                    <table>
                        <tr>
                            <td class="icon">
                                <img src="{{ public_path('icons/imagem1.png') }}" width="40">
                            </td>
                            <td class="content">
                                <div class="label">Unidade Requisitante</div>
                                <div>{{ $detalhe->secretaria ?? 'XXXXXXXXXXXXXXXXXXXXXXXXXXX' }}</div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Alinhamento com Planejamento Anual -->
                <div class="section">
                    <table>
                        <tr>
                            <td class="icon">
                                <img src="{{ public_path('icons/imagem2.png') }}" width="40">
                            </td>
                            <td class="content">
                                <div class="label">Alinhamento com o Planejamento Anual</div>
                                <div>XXXXXXXXXXXXXXXXXXXXXXXXXXX</div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Equipe de Planejamento -->
                <div class="section">
                    <table>
                        <tr>
                            <td class="icon">
                                <img src="{{ public_path('icons/imagem3.png') }}" width="40">
                            </td>
                            <td class="content">
                                <div class="label">Equipe de Planejamento</div>
                                <div>{{ $detalhe->servidor_responsavel ?? 'XXXXXXXXXXXXXXXXXXXXXXXXXXX' }}</div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Problema Resumido -->
                <div class="section">
                    <table>
                        <tr>
                            <td class="icon">
                                <img src="{{ public_path('icons/imagem4.png') }}" width="40">
                            </td>
                            <td class="content">
                                <div class="label">Problema Resumido</div>
                                <div>XXXXXXXXXXXXXXXXXXXXXXXXXXX</div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Texto final -->
                <p class="justify">
                        Em atendimento ao inciso I do art. 18 da Lei 14.133/2021, o presente instrumento
                    caracteriza a primeira etapa do planejamento do processo de contratação e busca
                    atender o interesse público envolvido e buscar a melhor solução para atendimento
                    da necessidade aqui descrita.
                </p>

            </div>
        </div>

    </div>

</body>

</html>
