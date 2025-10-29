<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Unidade;
use setasign\Fpdi\Tcpdf\Fpdi;
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
use setasign\Fpdi\PdfReader\PdfReader;

class ProcessoController extends Controller
{
    protected $service;

    // Documentos configuration
    protected $documentos = [
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
        'projeto_basico' => [
            'titulo' => 'PROJETO BÁSICO',
            'cor' => 'bg-green-500',
            'data_id' => 'data_projeto_basico',
            'campos' => ['projeto_basico_pdf'],
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

    // Mapeamento de anexos
    protected $mapeamentoAnexos = [
        'analise_mercado' => 'anexo_pdf_analise_mercado',
        'minutas' => 'anexar_minuta',
        'publicacoes_avisos_licitacao' => 'anexo_pdf_publicacoes',
        'edital' => ['anexo_pdf_minuta_contrato'],
        'projeto_basico' => 'projeto_basico_pdf',
    ];

    public function __construct(ProcessoService $service)
    {
        $this->service = $service;
    }

    // =========================================================
    // MÉTODOS CRUD PRINCIPAIS
    // =========================================================

    public function index()
    {
        $prefeituras = Prefeitura::all();
        $query = Processo::with('prefeitura');

        if (request('prefeitura_id')) {
            $query->where('prefeitura_id', request('prefeitura_id'));
        }

        $processos = $query->paginate(10)->withQueryString();

        return view('Admin.Processos.index', compact('processos', 'prefeituras'));
    }

    public function create()
    {
        $prefeituras = Prefeitura::with('unidades')->get();
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
        $prefeituras = Prefeitura::with('unidades')->get();
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

    // =========================================================
    // MÉTODOS DE INICIALIZAÇÃO DO PROCESSO
    // =========================================================

    public function iniciar(Processo $processo)
    {
        $processo->load('prefeitura.unidades');
        $documentos = $this->documentos;
        return view('Admin.Processos.iniciar', compact('processo', 'documentos'));
    }

    public function storeDetalhe(Request $request, Processo $processo)
    {
        try {
            $detalhe = $processo->detalhe ?? new ProcessoDetalhe();
            $detalhe->processo_id = $processo->id;

            // Processa arquivos
            $this->processarArquivos($request, $detalhe);

            // Salva outros campos
            $dataToSave = $request->except($this->getExcludedFields());
            foreach ($dataToSave as $field => $value) {
                $detalhe->{$field} = $value;
            }

            $detalhe->save();

            return response()->json([
                'success' => true,
                'data' => $detalhe->toArray()
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao salvar detalhe do processo', [
                'processo_id' => $processo->id,
                'erro' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar os dados.'
            ], 500);
        }
    }

    // =========================================================
    // MÉTODOS DE GERAÇÃO E DOWNLOAD DE PDF
    // =========================================================

    public function gerarPdf(Request $request, Processo $processo)
    {
        try {
            Log::info('Iniciando geração de PDF', [
                'processo_id' => $processo->id,
                'documento' => $request->query('documento'),
                'request_data' => $request->all()
            ]);

            $validatedData = $this->validarRequisicaoPdf($request, $processo);
            $data = $this->prepararDadosPdf($processo, $validatedData);
            $view = $this->determinarViewPdf($processo, $validatedData['documento']);

            Log::info('View selecionada para PDF', ['view' => $view]);

            $pdf = Pdf::loadView($view, $data)->setPaper('a4', 'portrait');

            $caminhoCompleto = $this->salvarDocumento($processo, $pdf, $validatedData);

            $this->processarAnexos($processo, $validatedData['documento'], $caminhoCompleto);

            Log::info('PDF gerado com sucesso', [
                'processo_id' => $processo->id,
                'documento' => $validatedData['documento'],
                'caminho' => $caminhoCompleto
            ]);

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
                'message' => '❌ Ocorreu um erro inesperado ao gerar o PDF: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function baixarDocumento(Processo $processo, $tipo)
    {
        $documento = Documento::where('processo_id', $processo->id)
            ->where('tipo_documento', $tipo)
            ->firstOrFail();

        return response()->download(public_path($documento->caminho));
    }

    public function baixarTodosDocumentos(Processo $processo)
    {
        $ordem = $this->getOrdemDocumentos();
        $documentos = Documento::where('processo_id', $processo->id)->get()->keyBy('tipo_documento');

        $pdf = new Fpdi();
        $this->configurarFonte($pdf);

        list($pageCountTotal, $paginas) = $this->contarPaginas($pdf, $ordem, $documentos);
        $paginaAtual = 1;

        foreach ($ordem as $tipo) {
            if (!isset($documentos[$tipo])) continue;

            $caminho = public_path($documentos[$tipo]->caminho);
            if (!file_exists($caminho)) continue;

            $numPages = $pdf->setSourceFile($caminho);
            for ($i = 1; $i <= $numPages; $i++) {
                $tplId = $pdf->importPage($i);
                $pdf->AddPage();
                $pdf->useTemplate($tplId);

                if ($tipo !== 'capa') {
                    $this->adicionarCarimbo($pdf, $processo, $paginaAtual, $pageCountTotal);
                    $paginaAtual++;
                }
            }
        }

        $caminhoArquivo = $this->salvarPdfCompleto($pdf, $processo);
        return response()->download($caminhoArquivo)->deleteFileAfterSend(true);
    }

    // =========================================================
    // MÉTODOS PRIVADOS - ARMAZENAMENTO DE DETALHES
    // =========================================================

    private function processarArquivos(Request $request, ProcessoDetalhe $detalhe): void
    {
        $arquivos = [
            'itens_e_seus_quantitativos_xml' => 'processarArquivoItens',
            'itens_especificaca_quantitativos_xml' => 'processarArquivoEspecificacao',
            'painel_preco_tce' => 'processarPainelPrecos',
            'anexo_pdf_analise_mercado' => 'salvarAnexo',
            'anexar_minuta' => 'salvarAnexo',
            'anexo_pdf_publicacoes' => 'salvarAnexo',
            'anexo_pdf_minuta_contrato' => 'salvarAnexo',
            'projeto_basico_pdf' => 'salvarAnexo'
        ];

        foreach ($arquivos as $campo => $metodo) {
            if ($request->hasFile($campo)) {
                $this->{$metodo}($request->file($campo), $detalhe, $campo);
            }
        }
    }

    private function processarArquivoItens($file, ProcessoDetalhe $detalhe, string $campo): void
    {
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $itens = [];
        foreach ($rows as $index => $row) {
            if ($index === 0) continue;
            $itens[] = [
                'numero'     => $row[0] ?? null,
                'descricao'  => $row[1] ?? null,
                'und'        => $row[2] ?? null,
                'quantidade' => $row[3] ?? null,
            ];
        }

        $detalhe->{$campo} = json_encode($itens, JSON_UNESCAPED_UNICODE);
    }

    private function processarArquivoEspecificacao($file, ProcessoDetalhe $detalhe, string $campo): void
    {
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $itens = [];
        foreach ($rows as $index => $row) {
            if ($index === 0) continue;
            $itens[] = [
                'item'              => $row[0] ?? null,
                'especificacoes'    => $row[1] ?? null,
                'unidade'           => $row[2] ?? null,
                'quantidade'        => $row[3] ?? null,
                'valor_unitario'    => $row[4] ?? null,
                'valor_total'       => $row[5] ?? null,
            ];
        }

        $detalhe->{$campo} = json_encode($itens, JSON_UNESCAPED_UNICODE);
    }

    private function processarPainelPrecos($file, ProcessoDetalhe $detalhe, string $campo): void
    {
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $painelPrecos = [];
        foreach ($rows as $index => $row) {
            if ($index === 0) continue;
            $painelPrecos[] = [
                'item' => $row[0] ?? null,
                'valor_tce_1' => $row[1] ?? null,
                'valor_tce_2' => $row[2] ?? null,
                'valor_tce_3' => $row[3] ?? null,
                'fornecedor_local' => $row[4] ?? null,
                'media' => $row[5] ?? null,
            ];
        }

        $detalhe->{$campo} = json_encode($painelPrecos, JSON_UNESCAPED_UNICODE);
    }

    private function salvarAnexo($file, ProcessoDetalhe $detalhe, string $campo): void
    {
        $filename = $campo . '_' . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('uploads/anexos');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $file->move($destinationPath, $filename);
        $detalhe->{$campo} = 'uploads/anexos/' . $filename;
    }

    private function getExcludedFields(): array
    {
        return [
            '_token',
            'processo_id',
            'itens_e_seus_quantitativos_xml',
            'painel_preco_tce',
            'anexo_pdf_analise_mercado',
            'anexar_minuta',
            'anexo_pdf_publicacoes',
            'itens_especificaca_quantitativos_xml',
            'anexo_pdf_minuta_contrato',
            'projeto_basico_pdf'
        ];
    }

    // =========================================================
    // MÉTODOS PRIVADOS - GERAÇÃO DE PDF
    // =========================================================

    private function validarRequisicaoPdf(Request $request, Processo $processo): array
    {
        $documento = $request->query('documento', 'capa');
        $dataSelecionada = $request->query('data');
        $parecerSelecionado = $request->query('parecer');

        if (empty($dataSelecionada)) {
            throw new \Exception('É necessário selecionar uma data antes de gerar o PDF.');
        }

        $assinantes = $this->processarAssinantes($request);
        $this->validarAssinantes($documento, $assinantes);

        return [
            'documento' => $documento,
            'dataSelecionada' => $dataSelecionada,
            'parecerSelecionado' => $parecerSelecionado,
            'assinantes' => $assinantes
        ];
    }

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

    private function validarAssinantes(string $documento, array $assinantes): void
    {
        if ($documento === 'capa') {
            return;
        }

        if (empty($assinantes)) {
            throw new \Exception('É necessário adicionar pelo menos um assinante para este documento.');
        }

        $documentosComDoisAssinantes = ['estudo_tecnico'];

        if (in_array($documento, $documentosComDoisAssinantes) && count($assinantes) < 2) {
            throw new \Exception('Este documento requer duas assinaturas obrigatórias (ex.: responsável técnico e jurídico).');
        }
    }

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

    private function determinarViewPdf(Processo $processo, string $documento): string
    {
        $viewBase = "Admin.Processos.pdf";

        if ($this->isPregaoEletronico($processo)) {
            $procedimento = $this->formatarNomeArquivo($processo->tipo_procedimento?->name ?? '');
            $contratacao = $this->formatarNomeArquivo($processo->tipo_contratacao?->name ?? '');
            $view = "{$viewBase}.pregao_eletronico.{$procedimento}_{$contratacao}.{$documento}";
        } else {
            $modalidade = $this->formatarNomeArquivo($processo->modalidade?->name ?? '');
            $view = "{$viewBase}.{$modalidade}.{$documento}";
        }

        if (!view()->exists($view)) {
            throw new \Exception("O modelo de PDF para o documento '{$documento}' não foi encontrado. View: {$view}");
        }

        return $view;
    }

    private function salvarDocumento(Processo $processo, $pdf, array $validatedData): string
    {
        $numeroProcessoLimpo = str_replace(['/', '\\'], '_', $processo->numero_processo);
        $subpasta = $this->gerarSubpasta($processo, $validatedData['documento']);

        $diretorio = public_path("uploads/documentos/{$subpasta}");
        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $nomeArquivo = "processo_{$numeroProcessoLimpo}_{$validatedData['documento']}_" . now()->format('Ymd_His') . '.pdf';
        $caminhoRelativo = "uploads/documentos/{$subpasta}/{$nomeArquivo}";
        $caminhoCompleto = "{$diretorio}/{$nomeArquivo}";

        $pdf->save($caminhoCompleto);
        $this->atualizarRegistroDocumento($processo, $validatedData['documento'], $validatedData['dataSelecionada'], $caminhoRelativo);

        return $caminhoCompleto;
    }

    private function gerarSubpasta(Processo $processo, string $documento): string
    {
        if ($this->isPregaoEletronico($processo)) {
            $procedimento = $this->formatarNomeArquivo($processo->tipo_procedimento?->name ?? '');
            $contratacao = $this->formatarNomeArquivo($processo->tipo_contratacao?->name ?? '');
            return "pregao_eletronico/{$procedimento}_{$contratacao}/{$documento}";
        }

        $modalidade = $this->formatarNomeArquivo($processo->modalidade?->name ?? 'sem_modalidade');
        return "{$modalidade}/{$documento}";
    }

    private function atualizarRegistroDocumento(Processo $processo, string $documento, string $dataSelecionada, string $caminhoRelativo): void
    {
        $documentoExistente = Documento::where('processo_id', $processo->id)
            ->where('tipo_documento', $documento)
            ->first();

        if ($documentoExistente) {
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

    private function processarAnexos(Processo $processo, string $documento, string $caminhoPrincipal): void
    {
        if ($documento === 'edital') {
            $this->juntarTermoReferenciaOuProjetoBasico($processo, $caminhoPrincipal);
        }

        $anexos = $this->obterAnexos($processo, $documento);
        foreach ($anexos as $anexoPath) {
            if ($anexoPath && file_exists($anexoPath)) {
                $this->juntarPdfs($caminhoPrincipal, $anexoPath);
            }
        }

        if ($documento === 'edital' && $processo->detalhe->tipo_srp === 'sim') {
            $this->gerarEJuntarAtaRegistroPreco($processo, $caminhoPrincipal);
        }
    }

    private function juntarTermoReferenciaOuProjetoBasico(Processo $processo, string $caminhoEdital): void
    {
        $tipoDocumento = $processo->modalidade === \App\Enums\ModalidadeEnum::CONCORRENCIA
            ? 'projeto_basico'
            : 'termo_referencia';

        $documento = Documento::where('processo_id', $processo->id)
            ->where('tipo_documento', $tipoDocumento)
            ->first();

        if ($documento && file_exists(public_path($documento->caminho))) {
            $this->juntarPdfs($caminhoEdital, public_path($documento->caminho));
        }
    }

    private function obterAnexos(Processo $processo, string $documento): array
    {
        $anexos = [];
        $camposAnexo = $this->mapeamentoAnexos[$documento] ?? null;

        if (!$camposAnexo) {
            return $anexos;
        }

        if (is_array($camposAnexo)) {
            foreach ($camposAnexo as $campo) {
                if (!empty($processo->detalhe->$campo)) {
                    $caminho = public_path($processo->detalhe->$campo);
                    $anexos[] = $caminho;
                    Log::info("Anexo encontrado para $documento", ['campo' => $campo, 'caminho' => $caminho, 'existe' => file_exists($caminho)]);
                }
            }
        } else {
            if (!empty($processo->detalhe->$camposAnexo)) {
                $caminho = public_path($processo->detalhe->$camposAnexo);
                $anexos[] = $caminho;
                Log::info("Anexo encontrado para $documento", ['campo' => $camposAnexo, 'caminho' => $caminho, 'existe' => file_exists($caminho)]);
            }
        }

        return $anexos;
    }
    private function juntarPdfs(string $pdfPrincipal, string $pdfAnexo): void
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'merged_pdf_') . '.pdf';
        $fpdi = new Fpdi();

        try {
            Log::info("Iniciando junção de PDFs", [
                'pdf_principal' => $pdfPrincipal,
                'pdf_anexo' => $pdfAnexo,
                'temp_file' => $tempFile
            ]);

            // Adiciona páginas do PDF principal
            $numPagesPrincipal = $fpdi->setSourceFile($pdfPrincipal);
            Log::info("PDF principal tem {$numPagesPrincipal} páginas");

            for ($pageNo = 1; $pageNo <= $numPagesPrincipal; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo);
                $size = $fpdi->getTemplateSize($templateId);
                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
                $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);
            }

            // Adiciona páginas do anexo
            $numPagesAnexo = $fpdi->setSourceFile($pdfAnexo);
            Log::info("PDF anexo tem {$numPagesAnexo} páginas");

            for ($pageNo = 1; $pageNo <= $numPagesAnexo; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo);
                $size = $fpdi->getTemplateSize($templateId);
                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
                $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);
            }

            // Salva o PDF mesclado em um arquivo temporário
            $fpdi->Output($tempFile, 'F');

            // Substitui o PDF principal pelo mesclado
            if (!copy($tempFile, $pdfPrincipal)) {
                throw new \Exception("Falha ao substituir o PDF principal pelo mesclado.");
            }

            Log::info("PDFs juntados com sucesso");
        } catch (\Throwable $e) {
            Log::error('Erro ao juntar PDFs', [
                'pdf_principal' => $pdfPrincipal,
                'pdf_anexo' => $pdfAnexo,
                'erro' => $e->getMessage()
            ]);

            throw new \Exception('Erro ao processar anexos do PDF: ' . $e->getMessage());
        } finally {
            // Limpa o arquivo temporário
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    private function gerarEJuntarAtaRegistroPreco(Processo $processo, string $caminhoPrincipal): void
    {
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
            unlink($arquivoAta);
        }
    }

    // =========================================================
    // MÉTODOS PRIVADOS - DOWNLOAD DE TODOS OS DOCUMENTOS
    // =========================================================

    private function getOrdemDocumentos(): array
    {
        return [
            'capa',
            'formalizacao',
            'autorizacao',
            'estudo_tecnico',
            'projeto_basico',
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
    }

    private function configurarFonte(Fpdi $pdf): void
    {
        $fontPath = public_path('storage/app/public/fonts/Aptos.ttf');
        if (file_exists($fontPath)) {
            $pdf->AddFont('Aptos', '', 'Aptos.ttf', true);
            $pdf->SetFont('Aptos', '', 8);
        } else {
            $pdf->SetFont('helvetica', '', 6);
        }
    }

    private function contarPaginas(Fpdi $pdf, array $ordem, $documentos): array
    {
        $pageCountTotal = 0;
        $paginas = [];

        foreach ($ordem as $tipo) {
            if (!isset($documentos[$tipo])) continue;
            $caminho = public_path($documentos[$tipo]->caminho);
            if (file_exists($caminho)) {
                $numPages = $pdf->setSourceFile($caminho);
                $paginas[$tipo] = $numPages;
                $pageCountTotal += $numPages;
            }
        }

        if (isset($paginas['capa'])) {
            $pageCountTotal -= $paginas['capa'];
        }

        return [$pageCountTotal, $paginas];
    }

    private function adicionarCarimbo(Fpdi $pdf, Processo $processo, int $paginaAtual, int $pageCountTotal): void
    {
        $pageWidth = $pdf->GetPageWidth();
        $pageHeight = $pdf->GetPageHeight();

        $boxWidth = 8;
        $boxHeight = 150;

        $x = $pageWidth - $boxWidth - 1;
        $y = ($pageHeight - $boxHeight) / 2;

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Rect($x, $y, $boxWidth, $boxHeight, 'D');
        $pdf->SetTextColor(0, 0, 0);

        $codigoAutenticacao = $processo->prefeitura->id . now()->format('HisdmY');
        $textoCarimbo = "Processo numerado por: {$processo->responsavel_numeracao} " .
            "Cargo: {$processo->unidade_numeracao} " .
            "Portaria nº {$processo->portaria_numeracao} " .
            "Pág. {$paginaAtual} / {$pageCountTotal} - " .
            "Documento gerado na Plataforma SoftCon - Licenciado para Prefeitura de {$processo->prefeitura->cidade}. " .
            "Cod. de Autenticação: {$codigoAutenticacao} - Para autenticar acesse softcon.org/autenticacao";

        $pdf->StartTransform();
        $rotateX = $x + ($boxWidth / 2);
        $rotateY = $y + ($boxHeight / 2);
        $pdf->Rotate(90, $rotateX, $rotateY);

        $textX = $rotateX - ($boxHeight / 2);
        $textY = $rotateY - ($boxWidth / 2);
        $pdf->SetXY($textX, $textY);

        $pdf->MultiCell($boxHeight, $boxWidth, $textoCarimbo, 0, 'C', false, 1, '', '', true, 0, false, true, 0, 'T', false);
        $pdf->StopTransform();
    }

    private function salvarPdfCompleto(Fpdi $pdf, Processo $processo): string
    {
        $numeroProcessoLimpo = str_replace(['/', '\\'], '_', $processo->numero_processo);
        $nomeArquivo = "processo_{$numeroProcessoLimpo}_todos_documentos_" . now()->format('Ymd_His') . '.pdf';

        $diretorio = public_path('uploads/documentos/');
        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $caminhoArquivo = $diretorio . $nomeArquivo;
        $pdf->Output($caminhoArquivo, 'F');

        return $caminhoArquivo;
    }

    // =========================================================
    // MÉTODOS AUXILIARES
    // =========================================================

    private function isPregaoEletronico(Processo $processo): bool
    {
        return $processo->modalidade?->name == '4' ||
            strtoupper($processo->modalidade?->name ?? '') == 'PREGAO ELETRONICO' ||
            stripos($processo->modalidade?->name ?? '', 'pregao') !== false;
    }

    private function formatarNomeArquivo(string $nome): string
    {
        $nome = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $nome));
        return str_replace(' ', '_', $nome);
    }
}
