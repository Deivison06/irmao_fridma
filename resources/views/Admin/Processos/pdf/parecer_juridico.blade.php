<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>PARECER JURÍDICO - Processo {{ $processo->numero_processo ?? $processo->id }}</title>
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
            PARECER JURÍDICO
        </div>
    </div>

    {{-- QUEBRA DE PÁGINA --}}
    <div class="page-break"></div>

    <div id="parecer_juridico">
        <p style="text-align: center; font-weight: bold; font-family: Arial, sans-serif;">
            PARECER JURÍDICO
        </p>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <!-- Coluna vazia ocupa 70% -->
                <td style="width: 50%;"></td>

                <!-- Coluna do texto ocupa 30% (lado direito) -->
                <td
                    style="width: 50%; text-align: justify; vertical-align: top; padding-top: 20px; font-family: Arial, sans-serif; line-height: 1.5;">
                    EMENTA: DIREITO ADMINISTRATIVO.<br>
                    PARECER INICIAL. PROCESSO<br>
                    ADMINISTRATIVO Nº XXX/2025.<br>
                    PREGÃO ELETRÔNICO Nº XXX/2025.<br>
                    PREFEITURA MUNICIPAL.<br>
                    OBSERVÂNCIA DA LEI 14.133/2021.<br>
                    OPINATIVO PELA APROVAÇÃO DA<br>
                    FASE INTERNA.
                </td>
            </tr>
        </table>

        <p style="font-weight: bold;">RELATÓRIO</p>

        <p style="text-indent: 30px; text-align: justify;">
            Submeteu-se ao crivo dessa assessoria a análise dos aspectos jurídicos relativos à abertura do PROCESSO
            ADMINISTRATIVO N° XXX/2025, PREGÃO ELETRÔNICO N° XXX/2025 cujo objeto é a:
            “XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX”
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            Seguindo a liturgia de praxe, os autos foram submetidos à análise desta assessoria jurídica,
            a fim de que fosse verificada a legalidade dos atos da fase interna do procedimento licitatório.
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            É, em abrupta síntese, o que importa relatar.
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            Passo a fundamentar, para, ao final, opinar.
        </p>

        <p style="font-weight: bold;">FUNDAMENTAÇÃO</p>

        <p style="text-indent: 30px; text-align: justify;">
            Registre-se, de pórtico, que o presente parecer tem por objeto analisar a fase preparatória
            do procedimento licitatório, visando verificar os aspectos jurídicos da minuta elaborada, em
            conformidade com o que preceitua o art. 53 da Lei 14.133/21.
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            Ademais, cumpre salientar que essa Assessoria emite parecer sob o prisma estritamente
            jurídico, não lhe competindo adentrar na conveniência/oportunidade dos atos praticados no âmbito
            da Administração Pública, nem analisar aspectos de natureza eminentemente administrativas, além
            disso, este parecer é de caráter meramente opinativo, não vinculando, portanto, à decisão do gestor
            municipal.
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            A obrigatoriedade de licitar consta na Constituição Federal de 1988, em seu artigo 37,
            inciso XXI. O procedimento licitatório visa garantir não apenas a seleção da proposta mais
            vantajosa para a Administração, mas sim, visa assegurar o princípio constitucional da isonomia
            entre os potenciais prestadores do serviço, ou fornecedores do objeto pretendido.
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            Em face do regramento constitucional, em 2021, foi editada a Lei Nacional nº 14.133/2021,
            que instituiu normas gerais para licitações e contratos da Administração Pública, em substituição a
            antiga Lei nº 8.666/93. De acordo com o art. 17 da nova legislação de regência da matéria, o
            processo de licitação observará as seguintes fases, em sequência: (I) preparatória; (II) de divulgação
            do edital de licitação; (III) de apresentação de propostas e lances, quando for o caso; (IV) de
            julgamento; (IV) de habilitação; (VI) recursal; (VII) de homologação.
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            No caso dos autos, em razão do andamento dos atos praticados até o presente momento,
            somente é possível realizar uma análise dos elementos registrados na fase inicial do procedimento
            licitatório. Por consequência, torna se fundamental atentar para o teor do art. 18 da Lei nº
            14.133/2021, que inaugura o capítulo referente à fase preparatória da licitação, in verbis:
        </p>

        <table style="width: 100%; border-collapse: collapse; page-break-inside: auto;">
            <tr style="page-break-after: auto;">
                <!-- Coluna vazia ocupa 50% -->
                <td style="width: 50%;"></td>

                <!-- Coluna do texto ocupa 50% -->
                <td
                    style="width: 50%; text-align: justify; vertical-align: top; padding-top: 20px; font-family: Arial, sans-serif; line-height: 1.5;">
                    Art. 18. A fase preparatória do processo licitatório é caracterizada pelo planejamento e deve
                    compatibilizar-se com o plano de contratações anual de que trata o inciso VII do caput do art. 12
                    desta Lei, sempre que elaborado, e com as leis orçamentárias, bem como abordar todas as
                    considerações técnicas, mercadológicas e de gestão que podem interferir na contratação,
                    compreendidos: <br><br>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>I - a descrição da necessidade da contratação fundamentada em estudo técnico preliminar que
                    caracterize o interesse público envolvido;<br><br></td>
            </tr>
            <tr>
                <td></td>
                <td>II - a definição do objeto para o atendimento da necessidade, por meio de termo de referência,
                    anteprojeto, projeto básico executivo, conforme o caso; ou projeto<br><br></td>
            </tr>
            <tr>
                <td></td>
                <td>III - a definição das condições de execução e pagamento, das garantias exigidas e ofertadas e das
                    condições de recebimento;<br><br></td>
            </tr>
            <tr>
                <td></td>
                <td>IV - o orçamento estimado, com as composições dos preços utilizados para sua formação;<br><br></td>
            </tr>
            <tr>
                <td></td>
                <td>V - a elaboração do edital de licitação;<br><br></td>
            </tr>
            <tr>
                <td></td>
                <td>VI - a elaboração de minuta de contrato, quando necessária, que constará obrigatoriamente como anexo
                    do edital de licitação;<br><br></td>
            </tr>
            <tr>
                <td></td>
                <td>VII - o regime de fornecimento de bens, de prestação de serviços ou de execução de obras e serviços
                    de engenharia, observados os potenciais de economia de escala;<br><br></td>
            </tr>
            <tr>
                <td></td>
                <td>VIII - a modalidade de licitação, o critério de julgamento, o modo de disputa e a adequação e
                    eficiência da forma de combinação desses parâmetros, para os fins de seleção da proposta apta a
                    gerar o resultado de contratação mais vantajoso para a Administração Pública, considerado todo o
                    ciclo de vida do objeto;<br><br></td>
            </tr>
            <tr>
                <td></td>
                <td>IX - a motivação circunstanciada das condições do edital, tais como justificativa de exigências de
                    qualificação técnica, mediante indicação das parcelas de maior relevância técnica ou valor
                    significativo do objeto, e de qualificação econômico-financeira, justificativa dos critérios de
                    pontuação e julgamento das propostas técnicas, nas licitações com julgamento por melhor técnica ou
                    técnica e preço, e justificativa das regras pertinentes à participação de empresas em consórcio;
                    <br><br>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>X - a análise dos riscos que possam comprometer o sucesso da licitação e a boa execução contratual;
                    <br><br>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>XI - a motivação sobre o momento da divulgação do orçamento da licitação, observado o art. 24 desta
                    Lei.<br><br></td>
            </tr>
        </table>
        <p style="text-indent: 30px; text-align: justify;">
            Compulsando os documentos que instruem os autos do processo de contratação, constata
            se o atendimento ao disposto no dispositivo transcrito alhures, haja vista que estão presentes, dentre
            outros, o Estudo Técnico Preliminar com a descrição da necessidade e estimativa e Termo de
            Referência com a definição do objeto, a fundamentação da contratação, os requisitos da
            contratação, o modelo de execução do objeto, o modelo de gestão do contrato, os critérios de
            medição e pagamento, a forma e critérios de seleção do fornecedor e do fornecimento, da proposta
            e estimativa do valor da contratação, da descrição detalhada dos itens, do contrato e vigência, da
            garantia dos produtos, das responsabilidades do contratante e da contratada.
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            Ademais, verifica-se a minuta de edital, conta com dois anexos (Termo de Referência e
            Minuta de Contrato), e contempla as exigências de participação, os critérios de apresentação da
            proposta inicial, preenchimento e classificação das propostas, da fase de julgamento, da fase de
            habilitação, dos recursos, das infrações administrativas e sanções, da impugnação ao edital e do
            pedido de esclarecimento, da ata de registro de preços, da formação do cadastro de reserva, dos
            recursos, das infrações administrativas e sanções, da impugnação ao edital e do pedido de
            esclarecimento, em conformidade com o art. 25 da lei disciplinadora do tema.
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            Ainda quanto ao art. 18 da Lei nº 14.133/2021, cumpre consignar que resta prejudicada a
            análise de compatibilidade da licitação com o plano anual de contratação, uma vez que ainda não
            existe tal plano no âmbito do município. No entanto, a sua ausência não impede o prosseguimento
            do certame, porquanto não é um item obrigatório, mas facultativo, nos termos do art. 12, VII, da
            nova Lei de Licitações:
        </p>

        <table style="width: 100%; border-collapse: collapse; page-break-inside: auto;">
            <tr style="page-break-after: auto;">
                <!-- Coluna vazia ocupa 50% -->
                <td style="width: 50%;"></td>

                <!-- Coluna do texto ocupa 50% -->
                <td style="width: 50%; text-align: justify; vertical-align: top;">
                    Art. 12. No processo licitatório, observar-se-á
                    o seguinte: <br><br>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>VII - a partir de documentos de formalização
                    de demandas, <strong> os órgãos responsáveis pelo
                        planejamento de cada ente federativo
                        poderão, na forma de regulamento, elaborar
                        plano de contratações anual</strong>, com o objetivo
                    de racionalizar as contratações dos órgãos e
                    entidades sob sua competência, garantir o
                    alinhamento com o seu planejamento
                    estratégico e subsidiar a elaboração das
                    respectivas leis orçamentárias. (grifos nossos) <br><br></td>
            </tr>
        </table>

        <p style="text-indent: 30px; text-align: justify;">
            Em relação à modalidade de licitação, entende-se ser correta a escolha do Pregão
            Eletrônico, tendo em vista ser a modalidade obrigatória para aquisição de bens e serviços comuns,
            conforme previsto no art. 6º, XLI, da Lei nº 14.133/2021. Além disso, é a mais vantajosa para a
            Administração Pública em razão da ampla competitividade de preços dela decorrentes.
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            Outrossim, é acertado o critério de julgamento por menor preço por XXXX, pois se coaduna o objeto do
            presente certame o XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX, bem como atende ao disposto no mesmo art.
            6º,
            XLI, da Lei nº 14.133/2021:
        </p>

        <table style="width: 100%; border-collapse: collapse; page-break-inside: auto;">
            <tr style="page-break-after: auto;">
                <!-- Coluna vazia ocupa 50% -->
                <td style="width: 50%;"></td>

                <!-- Coluna do texto ocupa 50% -->
                <td style="width: 50%; text-align: justify; vertical-align: top;">
                    Art. 6º Para os fins desta Lei, consideram-se: <br><br>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>XLI - pregão: modalidade de licitação
                    obrigatória para aquisição de bens e serviços
                    comuns, cujo critério de julgamento poderá ser
                    o de menor preço ou o de maior desconto; <br><br></td>
            </tr>
        </table>

        <p style="text-indent: 30px; text-align: justify;">
            No tocante ao dispêndio econômico que se depreende da contratação, esta assessoria
            jurídica destaca que não detém expertise para examinar e aquilatar a correspondência dos valores
            estimados no certame frente ao usualmente praticado pelo mercado. Nada obstante, percebe-se que
            há no processo pesquisa realizada no Painel de Preços do TCE-PI.
        </p>

        <p style="font-weight: bold;">CONCLUSÃO</p>

        <p style="text-indent: 30px; text-align: justify;">
            Ante o exposto, estando configurada a regularidade do procedimento adotado, com esteio
            na legislação vigente, <strong>OPINO PELA APROVAÇÃO DA FASE INTERNA</strong>, a fim de que seja
            autorizado o início da fase externa do referido certame.
        </p>
        <p style="text-indent: 30px;">
            É, S,M.J., o Parecer, que submeto à análise superior.
        </p>

        {{-- Bloco de data e assinatura --}}
        <div class="footer-signature">
            {{ $processo->prefeitura->nome }},
            {{ \Carbon\Carbon::parse($dataSelecionada)->translatedFormat('d \d\e F \d\e Y') }}
        </div>

        <div class="signature-block">
            ___________________________________<br>
            PARECER JURÍDICO 
        </div>

    </div>




</body>

</html>
