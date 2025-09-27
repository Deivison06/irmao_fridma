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
            font-size: 20pt;
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
            font-size: 20pt;
            background: #bebebe;
            border: 1px solid #7a7a7a;
            padding: 5px 10px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 15px;
        }

        .justify {
            margin-top: 20px;
            text-indent: 20px;
            font-size: 12px;
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
            font-size: 14px;
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
            INSTRUMENTOS DE PLANEJAMENTO ETP E MAPA DE RISCOS
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
                                <div style="font-size: 14px; font-weight: bold; margin-bottom: 3px;">Unidade
                                    Requisitante</div>
                                <div style="font-size: 14px;">
                                    {{ $detalhe->secretaria ?? 'XXXXXXXXXXXXXXXXXXXXXXXXXXX' }}</div>
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
                                <div style="font-size: 14px; font-weight: bold; margin-bottom: 3px;">Alinhamento com o
                                    Planejamento Anual</div>
                                <div style="font-size: 14px">XXXXXXXXXXXXXXXXXXXXXXXXXXX</div>
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
                                <div style="font-size: 14px; font-weight: bold; margin-bottom: 3px;">Equipe de
                                    Planejamento</div>
                                <div style="font-size: 14px;">
                                    {{ $detalhe->servidor_responsavel ?? 'XXXXXXXXXXXXXXXXXXXXXXXXXXX' }}</div>
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
                                <div style="font-size: 14px; font-weight: bold; margin-bottom: 3px;">Problema Resumido
                                </div>
                                <div style="font-size: 14px;"">XXXXXXXXXXXXXXXXXXXXXXXXXXX</div>
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

        <div style="font-weight: 600; font-size: 14px; margin-top: 150px; margin-bottom: 20px;">
            <img src="{{ public_path('icons/descricao-necessidade.png') }}" width="30px"
                alt="DESCRIÇÃO DA NECESSIDADE">
            DESCRIÇÃO DA NECESSIDADE
        </div>

        <p style="font-size: 12px; text-indent: 30px;">
            A Prefeitura Municipal de XXXXXXX enfrenta um problema significativo relacionado à
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX. A contínua demanda por
            XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX expõe a fragilidade atual dos recursos disponíveis.
        </p>

        <div style="text-align: center; font-size: 14px; margin-bottom: 20px; color: red;">
            JUSTIFICAR A IMPORTÂNCIA DA NECESSIDADE DA CONTRATAÇÃO
        </div>

        <p style="font-size: 12px; text-indent: 30px;">
            Atender a essa necessidade melhorará a eficiência administrativa. Assim, a formalização
            desta demanda é crucial para assegurar que a Prefeitura possa cumprir seu papel de zelar pelo
            bem-estar da população, reforçando o compromisso com a qualidade e a efetividade dos serviços
            prestados.
        </p>

        <div style="font-weight: bold; font-size: 14px; margin-bottom: 20px; color: red;">
            Recomendação sobre a Ordem das Fases da Licitação
        </div>

        <p style="color: red !important; line-height: 1.2; font-size: 12px;">
            Nos termos do art. 17, § 1º, da Lei nº 14.133/2021, a Administração tem a prerrogativa de optar pela
            inversão das fases do processo licitatório, começando com o julgamento das propostas e, posteriormente,
            analisando a habilitação do licitante melhor classificado.<br><br>

            No entanto, para a presente contratação, recomenda-se <strong>manter a ordem tradicional das fases
                (habilitação antes do julgamento das propostas)</strong>, com fundamento nos seguintes aspectos<br><br>

            <strong style="font-size: 14px;">Justificativa:</strong>
        </p>

        <ol style="color: red; font-size: 12px; ">
            <li>
                <p><strong>Complexidade da habilitação exigida:</strong> Trata-se de contratação que demanda análise
                    detalhada e criteriosa da documentação de habilitação, especialmente quanto à capacidade
                    técnica, regularidade fiscal e requisitos de qualificação econômico-financeira. A avaliação
                    prévia garante maior segurança jurídica e evita que se avance no julgamento de propostas
                    de licitantes que possam ser inabilitados posteriormente. </p>
            </li>
            <li>
                <p><strong>Mitigação de riscos:</strong> A habilitação prévia reduz o risco de retrabalho e eventual
                    anulação
                    do procedimento, assegurando que apenas concorram na etapa de propostas os licitantes
                    que efetivamente atendam a todos os requisitos legais e técnicos. </p>
            </li>
            <li>
                <p><strong>Transparência e confiabilidade:</strong> A ordem tradicional favorece a credibilidade do
                    processo,
                    uma vez que os participantes e órgãos de controle verificam, desde o início, que apenas
                    empresas habilitadas estarão aptas a disputar.
                </p>
            </li>
            <li>
                <p><strong>Alinhamento com o interesse público:</strong> A opção contribui para maior lisura do certame,
                    assegurando que a Administração se dedique exclusivamente à análise das propostas de
                    licitantes plenamente habilitados, reduzindo riscos de impugnações e contestações
                    posteriores. </p>
            </li>
        </ol>

        <p style="font-size: 12px; color: red;">
            Nos certames conduzidos por esta Administração, tem-se verificado um <strong>alto índice de
                licitantes que participam da fase de lances/propostas sem, contudo, apresentar ou
                comprovar adequadamente a documentação de habilitação</strong>.
        </p>

        <span style="font-size: 14px; color: red;">Essa prática ocasiona:</span>
        <ul style="color: red; font-size: 12px;">
            <li><strong>Retrabalho</strong> para a equipe de apoio e para o pregoeiro, que precisam inabilitar
                sucessivamente os licitantes melhor classificados por falta de documentos;</li>
            <li><strong>Atrasos na conclusão do certame</strong>, em razão da necessidade de convocar repetidamente
                os classificados subsequentes;</li>
            <li><strong>Risco de frustração da licitação</strong>, caso não haja concorrentes habilitados ao final
                do
                procedimento.</li>
        </ul>

        <p style="font-size: 12px; color: red;">
            A habilitação prévia garante que <strong>apenas empresas com documentação válida e condições
                reais de contratar</strong> participem da fase competitiva, aumentando a segurança do processo e
            reduzindo a possibilidade de lances artificiais ou propostas inexequíveis apresentadas por
            licitantes que não têm intenção ou capacidade de assumir o contrato.
        </p>

    </div>

    {{-- ====================================================================== --}}
    {{-- BLOCO 4: REQUISITOS DA CONTRATAÇÃO --}}
    {{-- ====================================================================== --}}
    <div id="requisito-necessario" style="margin-top: 50px;">

        <div style="font-weight: 600; font-size: 14px; margin-bottom: 20px;">
            <img src="{{ public_path('icons/rquisitos-contratacao.png') }}" width="30px"
                alt="REQUISITOS DA CONTRATAÇÃO">
            REQUISITOS DA CONTRATAÇÃO
        </div>

        <div>
            <p style="font-size: 12px; font-style: italic;">
                Para uma contratação mais segura e eficaz, sugerimos como técnica de averiguação, e controle, as
                seguintes exigências mínimas:
            </p>

            <p style="font-size: 12px;">
                Os Produtos deverão ser executados de forma parcelada, de acordo com as solicitações da CONTRATANTE, por
                meio de suas respectivas OF.’s;
            </p>

            <p style="font-size: 12px;">
                Os Produtos deverão ser entregues em até 48 (quarenta e oito) horas contadas do envio do Pedido de
                Fornecimento/serviço Empenho, devendo a contratada manter estoques compatíveis com as quantidades
                solicitadas durante o prazo de vigência do contrato, evitando atrasos nas entregas/fornecimentos, sem a
                exigência de valor ou quantitativo mínimo e sem custos adicionais.
            </p>

            <p style="font-size: 12px;">
                Os produtos deverão ser executados/entregues nas respectivas Unidades e locais de indicação do
                CONTRATANTE,
                em horários e datas previamente estabelecidas na respectiva Ordem de Serviço;
            </p>

            <p style="font-size: 12px;">
                A nota fiscal deverá ser apresentada no ato da entrega informado o número do Contrato correspondente no
                campo “Dados Adicionais” e a ordem de fornecimento.
            </p>

            <p style="font-size: 12px;">
                A Contratada deverá arcar com as despesas referentes a entrega dos produtos.
            </p>

            <p style="font-size: 12px;">
                Serão exigidas comprovações de localização da sede da empresa, com apresentação de fotos da
                infraestrutura
                interna, com objetivo precípuo de averiguar a veracidade sobre a real existência da empresa, evitando a
                contratação de empresas fantasmas ou de caráter inidôneo.
            </p>

            <p style="font-size: 12px;">
                Serão exigidas composições de custos que reflitam a realidade econômica da empresa licitante, a ser
                definido
                no próprio edital, que estabelecem critérios de custos com despesas diretas e indiretas;
            </p>

            <p style="font-size: 12px;">
                Também será exigido garantia de proposta, nos termos do art. 96 e seguintes, visando estabelecer a
                segurança
                do preço ofertado pelo licitante, garantindo assim, o seguro do custeio realizado pela Administração no
                momento da abertura do certame;
            </p>
        </div>

        <div style="font-size: 14px; margin-bottom: 20px; color: red; text-align: center;">
            INCLUIR REQUISITOS REFERENTES A CADA CASO CONCRETO
        </div>

        <p style="font-size: 12px; text-indent: 30px;">
            Os requisitos acima foram elaborados buscando a equidade no processo licitatório,
            assegurando que apenas propostas que atendam plenamente às necessidades da Prefeitura
            Municipal de XXXXXXXXXXX sejam consideradas, respeitando assim os princípios da Lei
            14.133/21.
        </p>

        <div style="font-weight: 600; font-size: 14px; margin-bottom: 20px;">
            <img src="{{ public_path('icons/solucoes-diponivel.png') }}" width="30px"
                alt="SOLUÇÕES DISPONÍVEIS NO MERCADO">
            SOLUÇÕES DISPONÍVEIS NO MERCADO
        </div>
        <p style="font-size: 12px; text-indent: 30px;">Soluções disponíveis para o problema de XXXXXX da Prefeitura
            Municipal de XXXXXXXXX: </p>
        <p style="font-size: 12px;">Solução 1: XXXXXXXXXXXXXXXXX</p>
        <p style="font-size: 12px;">Solução 2: XXXXXXXXXXXXXXXXX</p>

        <div style=" font-size: 14px; margin-bottom: 20px; color: red; text-align: center;">
            INCLUIR SOLUÇÕES DISPONÍVEIS NO MERCADO, FAZER COMPARATIVO ENTRE AS SOLUÇÕES
        </div>
        <p style="font-size: 12px; text-indent: 30px;">
            Cada solução apresenta características diferentes em relação a custo, eficiência e
            adaptabilidade, e a escolha deve ser fundamentada nas necessidades específicas da Prefeitura
            Municipal de XXXXXXXXXXX, bem como na capacidade de cumprimento das metas estabelecidas
            para a melhoria dos serviços essenciais.
        </p>

        <div style="font-weight: 600; font-size: 14px; margin-bottom: 20px;">
            <img src="{{ public_path('icons/carrinho.png') }}" width="30px" alt="REQUISITOS DA CONTRATAÇÃO">
            DESCRIÇÃO DA SOLUÇÃO ESCOLHIDA COMO UM TODO
        </div>

        <p style="font-size: 12px; text-indent: 30px;">
            A escolha pela XXXXXXXXXXXXXXXXXXX é fundamentada em diversos aspectos técnicos
            e operacionais que atendem às necessidades específicas do município.
        </p>

        <div style=" font-size: 14px; margin-bottom: 20px; color: red; text-align: center;">
            INCREMENTAR E ELABORAR JUSTIFICATIVA PARA A SOLUÇÃO ESCOLHIDA
        </div>

        <div style="font-weight: 600; font-size: 14px; margin-bottom: 20px;">
            <img src="{{ public_path('icons/lista.png') }}" width="30px" alt="REQUISITOS DA CONTRATAÇÃO">
            ITENS E SEUS QUANTITATIVOS
        </div>

        <table border="1" cellspacing="0" cellpadding="4"
            style="border-collapse: collapse; width: 100%; text-align: center; font-size: 12px;">
            <thead>
                <tr>
                    <th style="width: 8%;">ITEM</th>
                    <th style="width: 70%;">DESCRIÇÃO/ESPECIFICAÇÃO</th>
                    <th style="width: 10%;">UND</th>
                    <th style="width: 12%;">QUANT.</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <p style="font-size: 12px;">Memória de Cálculo para Justificativa dos Quantitativos </p>
        <p style="font-size: 12px;">Metodologia de Definição dos Quantitativos </p>

        <div style="font-size: 12px;">O quantitativo de itens/serviços foi definido a partir da seguinte metodologia:
        </div>
        <ul style="font-size: 12px;">
            <li>Levantamento da demanda junto às Secretarias/Unidades requisitantes; </li>
            <li>Consideração do histórico de consumo/uso dos últimos [2] anos ou exercícios;</li>
            <li>Análise do estoque atual disponível e das condições de uso dos bens já existentes
                (quando aplicável); </li>
            <li>Adequação à vigência estimada do contrato e à previsão de utilização durante esse
                período. </li>
        </ul>

        <div style="font-size: 12px;">Dados Utilizados </div>
        <ul style="font-size: 12px;">
            <li>Unidades/Setores atendidos</li>
            <li>Quantidade de usuários/beneficiários</li>
            <li>Consumo médio histórico</li>
            <li>Estoque atual disponível:</li>
            <li>Déficit identificado: </li>
        </ul>

        <p style="font-size: 12px;">O quantitativo estimado encontra-se devidamente justificado com base em dados
            oficiais, históricos
            de consumo, análise de estoque e previsão de demanda, atendendo ao princípio da eficiência e
            assegurando o interesse público, nos termos da Lei nº 14.133/2021. </p>

        <div style="font-weight: 600; font-size: 14px; margin-bottom: 20px;">
            <img src="{{ public_path('icons/lista.png') }}" width="30px" alt="REQUISITOS DA CONTRATAÇÃO">
            PARCELAMENTO OU NÃO DA CONTRATAÇÃO
        </div>
        <p style="font-size: 14px; text-indent: 30px; color: red; ">
            LICITAÇÃO POR ITENS
        </p>
        <p style="font-size: 12px; text-indent: 30px; color: red;">
            O fracionamento do objeto da licitação em itens encontra amparo legal no art. 40, § 1º da
            Lei nº 14.133/2021, que incentiva o parcelamento sempre que viável, desde que não comprometa
            a execução do objeto. A medida visa permitir a ampla participação de fornecedores, principalmente
            de pequeno porte, bem como alcançar melhor resultado para a Administração.
        </p>
        <p style="font-size: 12px; text-indent: 30px; color: red;">
            O objeto da presente licitação abrange diversos produtos/serviços com características
            distintas, que podem ser adquiridos, entregues ou executados de forma independente, sem prejuízo
            à integridade da execução contratual.
        </p>
        <p style="font-size: 12px; text-indent: 30px; color: red;">
            A divisão por itens não compromete a obtenção de preços vantajosos, e ao contrário,
            estimula a competitividade, ao permitir que microempresas, empresas locais e fornecedores
            especializados possam concorrer apenas nos itens de sua capacidade técnica e logística.
        </p>
        <p style="font-size: 12px; text-indent: 30px; color: red;">
            Com isso, evita-se a concentração do fornecimento em um único fornecedor, promovendo
            maior eficiência, economicidade e mitigação de riscos contratuais.
        </p>
        <p style="font-size: 12px; text-indent: 30px; color: red;">
            A adoção do parcelamento por itens está alinhada ao planejamento da Administração
            Pública, favorecendo:
        </p>

        <p>
            <li style="font-size: 12px; text-indent: 30px; color: red;">Atendimento adequado às necessidades
                específicas de
                cada unidade administrativa; </li>
        </p>
        <p>
            <li style="font-size: 12px; text-indent: 30px; color: red;">Diversificação de fornecedores e redução do
                risco
                de desabastecimento; </li>
        </p>
        <p>
            <li style="font-size: 12px; text-indent: 30px; color: red;">Fortalecimento da economia local/regional;</li>
        </p>
        <p>
            <li style="font-size: 12px; text-indent: 30px; color: red;">Observância ao princípio da isonomia, conforme
                art.
                5º da Lei nº 14.133/2021.</li>
        </p>


        <p style="font-size: 12px; text-indent: 30px; color: red;">
            Além disso, o parcelamento da contratação em lotes favorece uma competição saudável
            entre fornecedores, o que pode resultar em custos mais baixos e condições mais vantajosas para a
            Administração Pública. Ao permitir que empresas ofereçam suas propostas para XXXXXXXXXX, a
            Prefeitura pode beneficiar-se da especialização dos fornecedores, garantindo aquisição de
            XXXXXXXXX de melhor qualidade. Essa dinâmica também contribui para minimizar riscos, uma vez
            que cada item pode ser ajustado conforme a resposta do mercado e as demandas emergentes,
            facilitando adaptações ao longo do fornecimento.
        </p>

        <p style="font-size: 14px; text-indent: 30px; color: red; margin-top: 50px; ">
            LICITAÇÃO POR LOTE
        </p>

        <p style="font-size: 12px; text-indent: 30px; color: red;">
            O fracionamento do objeto da licitação em itens encontra amparo legal no art. 40, § 1º da
            Lei nº 14.133/2021, que incentiva o parcelamento sempre que viável, desde que não comprometa
            a execução do objeto. A medida visa permitir a ampla participação de fornecedores, principalmente
            de pequeno porte, bem como alcançar melhor resultado para a Administração.</p>
        <p style="font-size: 12px; text-indent: 30px; color: red;">
            A presente justificativa tem por objetivo demonstrar a vantajosidade da contratação do
            objeto em LOTES, ao invés da aquisição ou contratação individualizada por itens, conforme os
            princípios e diretrizes estabelecidos pela Lei nº 14.133/2021, especialmente no art. 5º (princípios da
            eficiência e planejamento) e no art. 40, §1º, que dispõe:</p>
        <p style="font-size: 12px; text-indent: 30px; color: red;">
            “A administração pública poderá dividir o objeto da contratação em lotes, sempre que
            técnica e economicamente viável, visando à ampliação da competitividade e ao desenvolvimento do
            mercado local, regional ou nacional, conforme o caso.”
        </p>

        <p style="font-size: 14px; text-indent: 30px; color: red; margin-top: 50px; ">
            VANTAGENS OPERACIONAIS DA CONTRATAÇÃO POR LOTES
        </p>

        <p style="font-size: 12px; text-indent: 30px; color: red;">
            A contratação por lotes permite:
        </p>


    </div>


    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

</body>

</html>
