<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Unidade;
use setasign\Fpdi\Fpdi;
use App\Models\Processo;
use App\Models\Documento;
use App\Models\Prefeitura;
use Illuminate\Http\Request;
use App\Models\ProcessoDetalhe;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ProcessoService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProcessoRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Requests\ProcessoDetalheRequest;

class ProcessoController extends Controller
{
    protected $service;

    public function __construct(ProcessoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $prefeituras = Prefeitura::all();

        // Filtrar processos por prefeitura se o parâmetro estiver presente
        $query = Processo::with('prefeitura');

        if (request('prefeitura_id')) {
            $query->where('prefeitura_id', request('prefeitura_id'));
        }

        $processos = $query->paginate(10)->withQueryString(); // mantém o filtro na paginação

        return view('Admin.Processos.index', compact('processos', 'prefeituras'));
    }


    public function create()
    {
        $prefeituras = Prefeitura::all();
        return view('Admin.Processos.create', compact('prefeituras'));
    }

    public function store(ProcessoRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.processos.index')->with('success', 'Processo criado com sucesso.');
    }

    public function show(Processo $processo)
    {
        return view('Admin.Processos.show', compact('processo'));
    }

    public function edit(Processo $processo)
    {
        $prefeituras = Prefeitura::all();
        return view('Admin.Processos.edit', compact('processo', 'prefeituras'));
    }

    public function update(ProcessoRequest $request, Processo $processo)
    {
        $this->service->update($processo, $request->validated());
        return redirect()->route('admin.processos.index')->with('success', 'Processo atualizado com sucesso.');
    }

    public function destroy(Processo $processo)
    {
        $this->service->delete($processo);
        return redirect()->route('admin.processos.index')->with('success', 'Processo removido com sucesso.');
    }

    public function iniciar(Processo $processo)
    {
        // Carrega a prefeitura com as unidades
        $processo->load('prefeitura.unidades');
        $documentos = [
            'capa' => [
                'titulo' => 'Capa do documento',
                'cor' => 'bg-red-500',
                'data_id' => 'data_capa',
                'campos' => [''],
            ],
            'formalizacao' => [
                'titulo' => 'DOCUMENTO DE FORMALIZAÇÃO DE DEMANDA',
                'cor' => 'bg-blue-500',
                'data_id' => 'data_formalizacao',
                'campos' => [
                    'secretaria',
                    'justificativa',
                    'prazo_entrega',
                    'local_entrega',
                    'contratacoes_anteriores',
                    'instrumento_vinculativo',
                    'prazo_vigencia',
                    'objeto_continuado',
                    'descricao_necessidade_autorizacao',
                    'responsavel_equipe_planejamento',
                ],
            ],
            'estudo_tecnico' => [
                'titulo' => 'INSTRUMENTOS DE PLANEJAMENTO ETP E MAPA DE RISCOS',
                'cor' => 'bg-purple-500',
                'data_id' => 'data_estudo_tecnico',
                'campos' => [
                    'problema_resolvido',
                    'descricao_necessidade',
                    'inversao_fase',
                    'solucoes_disponivel_mercado',
                    'incluir_requisito_cada_caso_concreto',
                    'solucao_escolhida',
                    'justificativa_solucao_escolhida',
                    'resultado_pretendidos',
                    'impacto_ambiental',
                    'riscos_extra',
                    'tipo_srp',
                    'prevista_plano_anual',
                    'encaminhamento_pesquisa_preco',
                    'encaminhamento_doacao_orcamentaria',
                    'itens_e_seus_quantitativos_xml',
                ],
            ],
            'analise_mercado' => [
                'titulo' => 'ANÁLISE DE MERCADO (PESQUISA DE PRECOS)',
                'cor' => 'bg-green-500',
                'data_id' => 'data_analise_mercado',
                'campos' => ['painel_preco_tce', 'anexo_pdf_analise_mercado'],
            ],
            'disponibilidade_orçamento' => [
                'titulo' => 'DISPONIBILIDADE ORÇAMENTÁRIA',
                'cor' => 'bg-yellow-500',
                'data_id' => 'data_disponibilidade_orçamento',
                'campos' => [
                    'valor_estimado',
                    'dotacao_orcamentaria',
                ],
            ],
            'termo_referencia' => [
                'titulo' => 'TERMO DE REFERÊNCIA',
                'cor' => 'bg-orange-500',
                'data_id' => 'data_termo_referencia',
                'campos' => [
                    'encaminhamento_elaborar_editais',
                    'encaminhamento_parecer_juridico',
                    'encaminhamento_autorizacao_abertura',
                    'itens_especificaca_quantitativos_xml'
                ],
            ],
            'minutas' => [
                'titulo' => 'MINUTAS',
                'cor' => 'bg-pink-500',
                'data_id' => 'data_minutas',
                'campos' => ['anexar_minuta'],
            ],
            'parecer_juridico' => [
                'titulo' => 'PARECER JURÍDICO',
                'cor' => 'bg-emerald-500',
                'data_id' => 'data_parecer_juridico',
                'campos' => [''],
            ],
            'autorizacao_abertura_procedimento' => [
                'titulo' => 'AUTORIZAÇÃO ABERTURA PROCEDIMENTO LICITATÓRIO',
                'cor' => 'bg-teal-500',
                'data_id' => 'data_autorizacao_abertura_procedimento',
                'campos' => ['tratamento_diferenciado_MEs_eEPPs'],
            ],
            'abertura_fase_externa' => [
                'titulo' => 'ABERTURA FASE EXTERNA',
                'cor' => 'bg-cyan-500',
                'data_id' => 'data_abertura_fase_externa',
                'campos' => [''],
            ],
            'avisos_licitacao' => [
                'titulo' => 'AVISOS DE LICITAÇÃO',
                'cor' => 'bg-indigo-500',
                'data_id' => 'data_avisos_licitacao',
                'campos' => ['data_hora'],
            ],
            'edital' => [
                'titulo' => 'EDITAL',
                'cor' => 'bg-indigo-500',
                'data_id' => 'data_edital',
                'campos' => [
                    'data_hora_limite_edital',
                    'data_hora_fase_edital',
                    'pregoeiro',
                    'intervalo_lances',
                    'portal',
                    'exigencia_garantia_proposta',
                    'exigencia_garantia_contrato',
                    'participacao_exclusiva_mei_epp',
                    'reserva_cotas_mei_epp',
                    'prioridade_contratacao_mei_epp',
                    'regularidade_fisica',
                    'qualificacao_economica',
                    'exigencias_tecnicas',
                    'anexo_pdf_minuta_contrato',
                    'numero_items',
                ],
            ],
            'publicacoes_avisos_licitacao' => [
                'titulo' => 'PUBLICAÇÕES',
                'cor' => 'bg-indigo-500',
                'data_id' => 'data_publicacoes_avisos_licitacao',
                'campos' => ['anexo_pdf_publicacoes'],
            ],
        ];

        return view('Admin.Processos.iniciar', compact('processo', 'documentos'));
    }

    public function storeDetalhe(Request $request, Processo $processo)
    {
        $detalhe = $processo->detalhe ?? new ProcessoDetalhe();
        $detalhe->processo_id = $processo->id;

        // --- Tratamento do arquivo Excel/CSV/XML para itens_e_seus_quantitativos_xml ---
        if ($request->hasFile('itens_e_seus_quantitativos_xml')) {
            $file = $request->file('itens_e_seus_quantitativos_xml');

            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $itens = [];
            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // pula cabeçalho
                $itens[] = [
                    'numero'     => $row[0] ?? null,
                    'descricao'  => $row[1] ?? null,
                    'und'        => $row[2] ?? null,
                    'quantidade' => $row[3] ?? null,
                ];
            }

            // Salva JSON sem escapar acentos
            $detalhe->itens_e_seus_quantitativos_xml = json_encode($itens, JSON_UNESCAPED_UNICODE);
        }
        // --- Tratamento do arquivo Excel/CSV/XML para itens_especificaca_quantitativos_xml ---
        if ($request->hasFile('itens_especificaca_quantitativos_xml')) {
            $file = $request->file('itens_especificaca_quantitativos_xml');

            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $itens = [];
            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // pula o cabeçalho
                $itens[] = [
                    'item'              => $row[0] ?? null,
                    'especificacoes'    => $row[1] ?? null,
                    'unidade'           => $row[2] ?? null,
                    'quantidade'        => $row[3] ?? null,
                    'valor_unitario'    => $row[4] ?? null,
                    'valor_total'       => $row[5] ?? null,
                ];
            }

            // Salva JSON sem escapar acentos
            $detalhe->itens_especificaca_quantitativos_xml = json_encode($itens, JSON_UNESCAPED_UNICODE);
        }

        if ($request->hasFile('painel_preco_tce')) {
            $file = $request->file('painel_preco_tce');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $painelPrecos = [];
            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // pula cabeçalho
                $painelPrecos[] = [
                    'item' => $row[0] ?? null,
                    'valor_tce_1' => $row[1] ?? null,
                    'valor_tce_2' => $row[2] ?? null,
                    'valor_tce_3' => $row[3] ?? null,
                    'fornecedor_local' => $row[4] ?? null,
                    'media' => $row[5] ?? null,
                ];
            }

            $detalhe->painel_preco_tce = json_encode($painelPrecos, JSON_UNESCAPED_UNICODE);
        }
        // Anexo PDF usando move
        if ($request->hasFile('anexo_pdf_analise_mercado')) {
            $file = $request->file('anexo_pdf_analise_mercado');
            $filename = 'anexo_analise_mercado_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/anexos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            // Salva o caminho relativo para uso posterior
            $detalhe->anexo_pdf_analise_mercado = 'uploads/anexos/' . $filename;
        }
        // Anexo PDF usando move
        if ($request->hasFile('anexar_minuta')) {
            $file = $request->file('anexar_minuta');
            $filename = 'minuta_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/anexos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            // Salva o caminho relativo para uso posterior
            $detalhe->anexar_minuta = 'uploads/anexos/' . $filename;
        }
        // Anexo PDF usando move
        if ($request->hasFile('anexo_pdf_publicacoes')) {
            $file = $request->file('anexo_pdf_publicacoes');
            $filename = 'publicacoes_avisos_licitacao_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/anexos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            // Salva o caminho relativo para uso posterior
            $detalhe->anexo_pdf_publicacoes = 'uploads/anexos/' . $filename;
        }
        if ($request->hasFile('anexo_pdf_minuta_contrato')) {
            $file = $request->file('anexo_pdf_minuta_contrato');
            $filename = 'minuta_contrato_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/anexos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            // Salva o caminho relativo para uso posterior
            $detalhe->anexo_pdf_minuta_contrato = 'uploads/anexos/' . $filename;
        }

        // --- Salva outros campos normais ---
        $dataToSave = $request->except(['_token', 'processo_id', 'itens_e_seus_quantitativos_xml', 'painel_preco_tce', 'anexo_pdf_analise_mercado', 'anexar_minuta', 'anexo_pdf_publicacoes', 'itens_especificaca_quantitativos_xml', 'anexo_pdf_minuta_contrato']);
        foreach ($dataToSave as $field => $value) {
            $detalhe->{$field} = $value;
        }

        $detalhe->save();

        return response()->json([
            'success' => true,
            'data' => $detalhe->toArray()
        ]);
    }

    public function gerarPdf(Request $request, Processo $processo)
    {
        try {
            // =========================================================
            // 1. INICIALIZAÇÃO E VALIDAÇÕES
            // =========================================================
            $validatedData = $this->validarRequisicaoPdf($request, $processo);

            // =========================================================
            // 2. PREPARAÇÃO DOS DADOS
            // =========================================================
            $data = $this->prepararDadosPdf($processo, $validatedData);

            // =========================================================
            // 3. DETERMINAÇÃO DA VIEW
            // =========================================================
            $view = $this->determinarViewPdf($processo, $validatedData['documento']);

            // =========================================================
            // 4. GERAÇÃO DO PDF PRINCIPAL
            // =========================================================
            $pdf = Pdf::loadView($view, $data)->setPaper('a4', 'portrait');

            // =========================================================
            // 5. SALVAMENTO DO DOCUMENTO
            // =========================================================
            $caminhoCompleto = $this->salvarDocumento($processo, $pdf, $validatedData);

            // =========================================================
            // 6. JUNÇÃO COM ANEXOS (QUANDO APLICÁVEL)
            // =========================================================
            $this->processarAnexos($processo, $validatedData['documento'], $caminhoCompleto);

            // =========================================================
            // 7. RETORNO DE SUCESSO
            // =========================================================
            return response()->json([
                'success' => true,
                'message' => '✅ PDF gerado com sucesso! Clique em "Download" para visualizar o arquivo.',
                'documento' => $validatedData['documento']
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao gerar PDF', [
                'processo_id' => $processo->id,
                'documento' => $request->query('documento'),
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => '❌ Ocorreu um erro inesperado ao gerar o PDF. Entre em contato com o suporte.',
            ], 500);
        }
    }

    // =========================================================
    // MÉTODOS PRIVADOS AUXILIARES
    // =========================================================

    /**
     * Valida a requisição e retorna dados validados
     */
    private function validarRequisicaoPdf(Request $request, Processo $processo): array
    {
        $documento = $request->query('documento', 'capa');
        $dataSelecionada = $request->query('data');
        $parecerSelecionado = $request->query('parecer');

        // Validação da data
        if (empty($dataSelecionada)) {
            throw new \Exception('É necessário selecionar uma data antes de gerar o PDF.');
        }

        // Processamento dos assinantes
        $assinantes = $this->processarAssinantes($request);

        // Validação de assinantes
        $this->validarAssinantes($documento, $assinantes);

        return [
            'documento' => $documento,
            'dataSelecionada' => $dataSelecionada,
            'parecerSelecionado' => $parecerSelecionado,
            'assinantes' => $assinantes
        ];
    }

    /**
     * Processa e valida os assinantes da requisição
     */
    private function processarAssinantes(Request $request): array
    {
        $assinantesJson = $request->query('assinantes');

        if (!$assinantesJson) {
            return [];
        }

        $assinantesDecoded = urldecode($assinantesJson);
        $assinantes = json_decode($assinantesDecoded, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("Erro ao decodificar JSON de assinantes: " . json_last_error_msg());
            throw new \Exception('Ocorreu um erro ao processar a lista de assinantes. Tente novamente.');
        }

        return $assinantes;
    }

    /**
     * Valida os assinantes conforme regras de negócio
     */
    private function validarAssinantes(string $documento, array $assinantes): void
    {
        if ($documento === 'capa') {
            return;
        }

        if (empty($assinantes)) {
            throw new \Exception('É necessário adicionar pelo menos um assinante para este documento.');
        }

        // Documentos que exigem 2 assinaturas obrigatórias
        $documentosComDoisAssinantes = ['estudo_tecnico'];

        if (in_array($documento, $documentosComDoisAssinantes) && count($assinantes) < 2) {
            throw new \Exception('Este documento requer duas assinaturas obrigatórias (ex.: responsável técnico e jurídico).');
        }
    }

    /**
     * Prepara os dados para a view do PDF
     */
    private function prepararDadosPdf(Processo $processo, array $validatedData): array
    {
        $processo->load(['detalhe', 'prefeitura']);

        return [
            'processo' => $processo,
            'prefeitura' => $processo->prefeitura,
            'detalhe' => $processo->detalhe,
            'dataGeracao' => now()->format('d/m/Y H:i:s'),
            'dataSelecionada' => $validatedData['dataSelecionada'],
            'assinantes' => $validatedData['assinantes'],
            'parecer' => $validatedData['parecerSelecionado'],
        ];
    }

    /**
     * Determina qual view usar baseado no tipo de processo e documento
     */
    private function determinarViewPdf(Processo $processo, string $documento): string
    {
        $procedimento = strtolower($processo->tipo_procedimento?->name ?? '');
        $contratacao = strtolower($processo->tipo_contratacao?->name ?? '');

        $viewBase = "Admin.Processos.pdf";
        $viewVaria = "{$viewBase}.{$procedimento}_{$contratacao}.{$documento}";
        $viewPadrao = "{$viewBase}.{$documento}";

        $view = view()->exists($viewVaria) ? $viewVaria : $viewPadrao;

        if (!view()->exists($view)) {
            throw new \Exception("O modelo de PDF para o documento '{$documento}' não foi encontrado.");
        }

        return $view;
    }

    /**
     * Salva o documento no sistema de arquivos e no banco de dados
     */
    private function salvarDocumento(Processo $processo, $pdf, array $validatedData): string
    {
        $numeroProcessoLimpo = str_replace(['/', '\\'], '_', $processo->numero_processo);
        $modalidade = strtolower(str_replace(' ', '_', $processo->modalidade?->name ?? 'sem_modalidade'));
        $procedimento = strtolower($processo->tipo_procedimento?->name ?? '');
        $contratacao = strtolower($processo->tipo_contratacao?->name ?? '');

        $subpasta = "{$modalidade}/{$procedimento}_{$contratacao}/{$validatedData['documento']}";
        $diretorio = public_path("uploads/documentos/{$subpasta}");

        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $nomeArquivo = "processo_{$numeroProcessoLimpo}_{$validatedData['documento']}_" . now()->format('Ymd_His') . '.pdf';
        $caminhoRelativo = "uploads/documentos/{$subpasta}/{$nomeArquivo}";
        $caminhoCompleto = "{$diretorio}/{$nomeArquivo}";

        // Salva o PDF
        $pdf->save($caminhoCompleto);

        // Atualiza ou cria o registro no banco
        $this->atualizarRegistroDocumento($processo, $validatedData['documento'], $validatedData['dataSelecionada'], $caminhoRelativo);

        return $caminhoCompleto;
    }

    /**
     * Atualiza ou cria o registro do documento no banco de dados
     */
    private function atualizarRegistroDocumento(Processo $processo, string $documento, string $dataSelecionada, string $caminhoRelativo): void
    {
        $documentoExistente = Documento::where('processo_id', $processo->id)
            ->where('tipo_documento', $documento)
            ->first();

        if ($documentoExistente) {
            // Remove arquivo antigo se existir
            $caminhoAntigo = public_path($documentoExistente->caminho);
            if (file_exists($caminhoAntigo)) {
                unlink($caminhoAntigo);
            }

            $documentoExistente->update([
                'data_selecionada' => $dataSelecionada,
                'caminho' => $caminhoRelativo,
                'gerado_em' => now(),
            ]);
        } else {
            Documento::create([
                'processo_id' => $processo->id,
                'tipo_documento' => $documento,
                'data_selecionada' => $dataSelecionada,
                'caminho' => $caminhoRelativo,
                'gerado_em' => now(),
            ]);
        }
    }

    /**
     * Processa anexos e junta com o PDF principal quando necessário
     */
    private function processarAnexos(Processo $processo, string $documento, string $caminhoPrincipal): void
{
    // =========================================================
    // CASO ESPECIAL: Edital deve ser processado primeiro com Termo de Referência
    // =========================================================
    if ($documento === 'edital') {
        $this->juntarTermoReferencia($processo, $caminhoPrincipal);
    }

    // =========================================================
    // PROCESSAMENTO DOS ANEXOS NORMAIS
    // =========================================================
    $anexos = $this->obterAnexos($processo, $documento);

    foreach ($anexos as $anexoPath) {
        if ($anexoPath && file_exists($anexoPath)) {
            $this->juntarPdfs($caminhoPrincipal, $anexoPath);
        }
    }

    // =========================================================
    // CASO ESPECIAL: Se for SRP, juntar a ATA DE REGISTRO DE PREÇO
    // =========================================================
    if ($documento === 'edital' && $processo->detalhe->tipo_srp === 'sim') {
        // Gera o PDF da ata_registro_preco
        $viewAta = $this->determinarViewPdf($processo, 'ata_registro_preco');
        $data = $this->prepararDadosPdf($processo, [
            'dataSelecionada' => now()->format('Y-m-d'),
            'assinantes' => [],
            'parecerSelecionado' => null,
        ]);

        $pdfAta = Pdf::loadView($viewAta, $data)->setPaper('a4', 'portrait');

        $arquivoAta = storage_path('app/temp_ata_' . $processo->id . '.pdf');
        $pdfAta->save($arquivoAta);

        if (file_exists($arquivoAta)) {
            $this->juntarPdfs($caminhoPrincipal, $arquivoAta);
            unlink($arquivoAta); // limpa arquivo temporário
        }
    }
}


    /**
     * Obtém os caminhos dos anexos baseado no documento
     */
    private function obterAnexos(Processo $processo, string $documento): array
    {
        $anexos = [];

        $mapeamentoAnexos = [
            'analise_mercado' => 'anexo_pdf_analise_mercado',
            'minutas' => 'anexar_minuta',
            'publicacoes_avisos_licitacao' => 'anexo_pdf_publicacoes',
            'edital' => ['anexo_pdf_minuta_contrato'],
        ];

        $camposAnexo = $mapeamentoAnexos[$documento] ?? null;

        if (!$camposAnexo) {
            return $anexos;
        }

        if (is_array($camposAnexo)) {
            foreach ($camposAnexo as $campo) {
                if (!empty($processo->detalhe->$campo)) {
                    $anexos[] = public_path($processo->detalhe->$campo);
                }
            }
        } else {
            if (!empty($processo->detalhe->$camposAnexo)) {
                $anexos[] = public_path($processo->detalhe->$camposAnexo);
            }
        }

        return $anexos;
    }

    /**
     * Junta o termo de referência ao edital
     */
    private function juntarTermoReferencia(Processo $processo, string $caminhoEdital): void
    {
        $termoReferencia = Documento::where('processo_id', $processo->id)
            ->where('tipo_documento', 'termo_referencia')
            ->first();

        if ($termoReferencia && file_exists(public_path($termoReferencia->caminho))) {
            $termoPath = public_path($termoReferencia->caminho);
            $this->juntarPdfs($caminhoEdital, $termoPath);
        }
    }

    /**
     * Junta dois PDFs usando FPDI
     */
    private function juntarPdfs(string $pdfPrincipal, string $pdfAnexo): void
    {
        try {
            $fpdi = new Fpdi();

            // Adiciona páginas do PDF principal
            $numPagesPrincipal = $fpdi->setSourceFile($pdfPrincipal);
            for ($pageNo = 1; $pageNo <= $numPagesPrincipal; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo);
                $fpdi->addPage();
                $fpdi->useTemplate($templateId);
            }

            // Adiciona páginas do anexo
            $numPagesAnexo = $fpdi->setSourceFile($pdfAnexo);
            for ($pageNo = 1; $pageNo <= $numPagesAnexo; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo);
                $fpdi->addPage();
                $fpdi->useTemplate($templateId);
            }

            // Salva o PDF final (sobrescreve o principal)
            $fpdi->Output('F', $pdfPrincipal);
        } catch (\Throwable $e) {
            Log::error('Erro ao juntar PDFs', [
                'pdf_principal' => $pdfPrincipal,
                'pdf_anexo' => $pdfAnexo,
                'erro' => $e->getMessage()
            ]);

            throw new \Exception('Erro ao processar anexos do PDF: ' . $e->getMessage());
        }
    }

    public function baixarDocumento(Processo $processo, $tipo)
    {
        // Buscar o caminho do documento
        $documento = Documento::where('processo_id', $processo->id)
            ->where('tipo_documento', $tipo)
            ->firstOrFail();

        // Baixar o PDF
        return response()->download(public_path($documento->caminho));
    }

    public function baixarTodosDocumentos(Processo $processo)
    {
        // Defina a ordem desejada dos documentos
        $ordem = [
            'capa',
            'formalizacao',
            'autorizacao',
            'estudo_tecnico',
            'analise_mercado',
            'disponibilidade_orçamento',
            'termo_referencia',
            'minutas',
            'parecer_juridico',
            'autorizacao_abertura_procedimento',
            'abertura_fase_externa',
            'avisos_licitacao',
            'publicacoes_avisos_licitacao',
            'edital'
        ];

        // Buscar os documentos do processo
        $documentos = Documento::where('processo_id', $processo->id)->get()->keyBy('tipo_documento');

        // Inicializar o FPDI para mesclar os PDFs
        $pdf = new Fpdi();

        // Seguir a ordem definida
        foreach ($ordem as $tipo) {
            if (!isset($documentos[$tipo])) {
                continue; // pula se o documento não existe
            }

            $caminhoDocumento = public_path($documentos[$tipo]->caminho);

            if (file_exists($caminhoDocumento)) {
                $numPages = $pdf->setSourceFile($caminhoDocumento);

                for ($pageNo = 1; $pageNo <= $numPages; $pageNo++) {
                    $templateId = $pdf->importPage($pageNo);
                    $pdf->addPage();
                    $pdf->useTemplate($templateId);
                }
            }
        }

        // Gerar nome do arquivo final
        $numeroProcessoLimpo = str_replace(['/', '\\'], '_', $processo->numero_processo);
        $nomeArquivo = "processo_{$numeroProcessoLimpo}_todos_documentos_" . now()->format('Ymd_His') . '.pdf';

        $diretorio = public_path('uploads/documentos/');

        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $caminhoArquivo = $diretorio . $nomeArquivo;
        $pdf->Output('F', $caminhoArquivo);

        return response()->download($caminhoArquivo)->deleteFileAfterSend(true);
    }
}
