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
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
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
            font-size: 16px;
            font-weight: bold;
            padding: 10px;
            border: 2px solid #000;
            background-color: #fff;
            color: #000;
            display: inline-block;
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
            left: 38%;
            width: 100%;
            transform: translate(-50%, -50%);
            text-align: left;
        }

        .conteudo {
            margin: 0 90px;
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
            text-indent: 20px;
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

        /* ---------------------------------- */
        /* ESTILOS - PÁGINAS ADICIONAIS */
        /* ---------------------------------- */
        .page-content {
            margin: 0 90px;
            padding-top: 50px;
        }

        .section-title {
            font-weight: bold;
            font-size: 16px;
            background: #e0e0e0;
            border: 1px solid #7a7a7a;
            padding: 8px 15px;
            margin-bottom: 15px;
        }

        .content-block {
            margin-bottom: 20px;
        }

        .signature-area {
            margin-top: 100px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 300px;
            margin: 0 auto;
            padding-top: 5px;
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
            ESTUDO TÉCNICO PRELIMINAR - ETP
        </div>
    </div>

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 2: PÁGINA PRINCIPAL DO ESTUDO TÉCNICO --}}
    {{-- ====================================================================== --}}
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
                                <img src="{{ public_path('icons/Imagem1.png') }}" width="40">
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
                                <img src="{{ public_path('icons/Imagem2.png') }}" width="40">
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
                                <img src="{{ public_path('icons/Imagem3.png') }}" width="40">
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
                                <img src="{{ public_path('icons/Imagem4.png') }}" width="40">
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

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 3: DESCRIÇÃO DA NECESSIDADE --}}
    {{-- ====================================================================== --}}
    <div id="descricao-necessidade">

        <div style="font-weight: bold; font-size: 16px; margin-bottom: 20px;">
            DESCRIÇÃO DA NECESSIDADE
        </div>

        <p style="font-size: 14px; text-indent: 30px;">
            A Prefeitura Municipal de XXXXXXX enfrenta um problema significativo relacionado à
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX. A contínua demanda por
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX expõe a fragilidade atual dos recursos disponíveis.
        </p>

        <div style="text-align: center; font-size: 16px; margin-bottom: 20px; color: red;">
            JUSTIFICAR A IMPORTÂNCIA DA NECESSIDADE DA CONTRATAÇÃO
        </div>

        <p style="font-size: 14px; text-indent: 30px;">
            Atender a essa necessidade melhorará a eficiência administrativa. Assim, a formalização
            desta demanda é crucial para assegurar que a Prefeitura possa cumprir seu papel de zelar pelo
            bem-estar da população, reforçando o compromisso com a qualidade e a efetividade dos serviços
            prestados.
        </p>

        <div style="font-weight: bold; font-size: 16px; margin-bottom: 20px; color: red;">
            Recomendação sobre a Ordem das Fases da Licitação
        </div>

        <p style="color: red !important; line-height: 1.2; font-size: 14px;">
            Nos termos do art. 17, § 1º, da Lei nº 14.133/2021, a Administração tem a prerrogativa de optar pela
            inversão das fases do processo licitatório, começando com o julgamento das propostas e, posteriormente,
            analisando a habilitação do licitante melhor classificado.<br><br>

            No entanto, para a presente contratação, recomenda-se a manutenção da ordem tradicional das fases
            (habilitação antes do julgamento das propostas), com base nos seguintes fundamentos:<br><br>

            <strong>Justificativa:</strong>
        </p>

        <ol style="color: red; font-size: 14px; ">
            <li><p><strong>Complexidade da habilitação exigida:</strong> A contratação requer uma análise detalhada e
                criteriosa da documentação de habilitação, especialmente no que diz respeito à capacidade técnica,
                regularidade fiscal e qualificação econômico-financeira. A avaliação prévia proporciona maior segurança
                jurídica e evita o avanço na análise de propostas de licitantes que possam ser posteriormente
                inabilitados.</p></li>
            <li><p><strong>Mitigação de riscos:</strong> A habilitação prévia reduz o risco de retrabalho e eventuais
                nulidades no processo, garantindo que apenas licitantes que atendem plenamente aos requisitos legais e
                técnicos participem da etapa de propostas.</p></li>
            <li><p><strong>Transparência e confiabilidade:</strong> A ordem tradicional reforça a credibilidade do processo
                licitatório, pois permite que todos os participantes e órgãos de controle confirmem desde o início que
                apenas empresas habilitadas estão aptas a disputar a contratação.</p></li>
            <li><p><strong>Alinhamento com o interesse público:</strong> A opção contribui para maior lisura do certame,
                assegurando que a Administração se dedique exclusivamente à análise das propostas de
                licitantes plenamente habilitados, reduzindo riscos de impugnações e contestações
                posteriores.</p></li>
        </ol>

        <p style="font-size: 14px; color: red;">
            Nos certames conduzidos por esta Administração, tem-se verificado um alto índice de
            licitantes que participam da fase de lances/propostas sem, contudo, apresentar ou
            comprovar adequadamente a documentação de habilitação.
        </p>

        <strong style="font-size: 14px; color: red;">Essa prática ocasiona:</strong>
        <ul style="color: red; font-size: 14px;">
            <li><strong>Retrabalho</strong> para a equipe de apoio e para o pregoeiro, que precisam inabilitar
                sucessivamente os licitantes melhor classificados por falta de documentos;</li>
            <li><strong>Atrasos na conclusão do certame</strong>, em razão da necessidade de convocar repetidamente
                os classificados subsequentes;</li>
            <li><strong>Risco de frustração da licitação</strong>, caso não haja concorrentes habilitados ao final do
                procedimento.</li>
        </ul>

        <p style="font-size: 14px; color: red;">
            A habilitação prévia garante que <strong>apenas empresas com documentação válida e condições
                reais de contratar</strong> participem da fase competitiva, aumentando a segurança do processo e
            reduzindo a possibilidade de lances artificiais ou propostas inexequíveis apresentadas por
            licitantes que não têm intenção ou capacidade de assumir o contrato.
        </p>

    </div>


    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

</body>

</html>
