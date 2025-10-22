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
                'campos' => ['portaria_agente_equipe_pdf', 'tratamento_diferenciado_MEs_eEPPs'],
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
        if ($request->hasFile('portaria_agente_equipe_pdf')) {
            $file = $request->file('portaria_agente_equipe_pdf');
            $filename = 'portaria_agente_equipe_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/anexos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            // Salva o caminho relativo para uso posterior
            $detalhe->portaria_agente_equipe_pdf = 'uploads/anexos/' . $filename;
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
        $dataToSave = $request->except(['_token', 'processo_id', 'itens_e_seus_quantitativos_xml', 'painel_preco_tce', 'anexo_pdf_analise_mercado', 'portaria_agente_equipe_pdf', 'anexar_minuta', 'anexo_pdf_publicacoes', 'itens_especificaca_quantitativos_xml', 'anexo_pdf_minuta_contrato']);
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
            // Definição de variáveis principais
            // =========================================================
            $procedimento = strtolower($processo->tipo_procedimento?->name ?? '');
            $contratacao = strtolower($processo->tipo_contratacao?->name ?? '');
            $documento = $request->query('documento', 'capa');
            $dataSelecionada = $request->query('data');
            $parecerSelecionado = $request->query('parecer');

            // =========================================================
            // Validação: data obrigatória
            // =========================================================
            if (empty($dataSelecionada)) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ É necessário selecionar uma data antes de gerar o PDF.'
                ], 422);
            }

            // =========================================================
            // Recebe e decodifica os assinantes
            // =========================================================
            $assinantesJson = $request->query('assinantes');
            $assinantes = [];

            if ($assinantesJson) {
                $assinantesDecoded = urldecode($assinantesJson);
                $assinantes = json_decode($assinantesDecoded, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error("Erro ao decodificar JSON de assinantes: " . json_last_error_msg());
                    return response()->json([
                        'success' => false,
                        'message' => '❌ Ocorreu um erro ao processar a lista de assinantes. Tente novamente.'
                    ], 422);
                }
            }

            // =========================================================
            // Validação de assinantes (exceto capa)
            // =========================================================
            if ($documento !== 'capa') {
                if (empty($assinantes)) {
                    return response()->json([
                        'success' => false,
                        'message' => '🖊️ É necessário adicionar pelo menos um assinante para este documento.'
                    ], 422);
                }

                // Exceção: documentos com 2 assinaturas obrigatórias
                if (in_array($documento, ['estudo_tecnico']) && count($assinantes) < 2) {
                    return response()->json([
                        'success' => false,
                        'message' => '🖋️ Este documento requer duas assinaturas obrigatórias (ex.: responsável técnico e jurídico).'
                    ], 422);
                }
            }

            // =========================================================
            // Carrega relações do processo
            // =========================================================
            $processo->load(['detalhe', 'prefeitura']);

            $data = [
                'processo' => $processo,
                'prefeitura' => $processo->prefeitura,
                'detalhe' => $processo->detalhe,
                'dataGeracao' => now()->format('d/m/Y H:i:s'),
                'dataSelecionada' => $dataSelecionada,
                'assinantes' => $assinantes,
                'parecer' => $parecerSelecionado,
            ];

            // =========================================================
            // Monta o caminho da view conforme variação do processo
            // =========================================================
            $viewBase = "Admin.Processos.pdf";
            $viewVaria = "{$viewBase}.{$procedimento}_{$contratacao}.{$documento}";
            $viewPadrao = "{$viewBase}.{$documento}";
            $view = view()->exists($viewVaria) ? $viewVaria : $viewPadrao;

            if (!view()->exists($view)) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ O modelo de PDF para este tipo de documento não foi encontrado. Entre em contato com o suporte.'
                ], 404);
            }

            // =========================================================
            // Geração e salvamento do PDF
            // =========================================================
            $pdf = Pdf::loadView($view, $data)->setPaper('a4', 'portrait');

            $numeroProcessoLimpo = str_replace(['/', '\\'], '_', $processo->numero_processo);
            $modalidade = strtolower(str_replace(' ', '_', $processo->modalidade?->name ?? 'sem_modalidade'));
            $subpasta = "{$modalidade}/{$procedimento}_{$contratacao}/{$documento}";

            $diretorio = public_path("uploads/documentos/{$subpasta}");
            if (!file_exists($diretorio)) mkdir($diretorio, 0777, true);

            $nomeArquivo = "processo_{$numeroProcessoLimpo}_{$documento}_" . now()->format('Ymd') . '.pdf';
            $caminhoRelativo = "uploads/documentos/{$subpasta}/{$nomeArquivo}";
            $caminhoCompleto = "{$diretorio}/{$nomeArquivo}";

            // =========================================================
            // Atualiza ou cria o registro do documento
            // =========================================================
            $documentoExistente = Documento::where('processo_id', $processo->id)
                ->where('tipo_documento', $documento)
                ->first();

            if ($documentoExistente) {
                $caminhoAntigo = public_path($documentoExistente->caminho);
                if (file_exists($caminhoAntigo)) unlink($caminhoAntigo);

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

            // =========================================================
            // Salva PDF principal
            // =========================================================
            $pdf->save($caminhoCompleto);

            // =========================================================
            // Junta o PDF principal com anexos (quando aplicável)
            // =========================================================
            $anexoPath = null;
            if ($documento === 'edital') {
                $termoReferencia = Documento::where('processo_id', $processo->id)
                    ->where('tipo_documento', 'termo_referencia')
                    ->first();

                if ($termoReferencia && file_exists(public_path($termoReferencia->caminho))) {
                    $termoPath = public_path($termoReferencia->caminho);

                    $fpdi = new Fpdi();

                    // Adiciona páginas do edital
                    $numPages = $fpdi->setSourceFile($caminhoCompleto);
                    for ($pageNo = 1; $pageNo <= $numPages; $pageNo++) {
                        $templateId = $fpdi->importPage($pageNo);
                        $fpdi->addPage();
                        $fpdi->useTemplate($templateId);
                    }

                    // Adiciona páginas do termo de referência
                    $numPagesTermo = $fpdi->setSourceFile($termoPath);
                    for ($pageNo = 1; $pageNo <= $numPagesTermo; $pageNo++) {
                        $templateId = $fpdi->importPage($pageNo);
                        $fpdi->addPage();
                        $fpdi->useTemplate($templateId);
                    }

                    // Sobrescreve o PDF final (edital + termo de referência)
                    $fpdi->Output('F', $caminhoCompleto);
                }
            }

            if ($documento === 'analise_mercado' && !empty($processo->detalhe->anexo_pdf_analise_mercado)) {
                $anexoPath = public_path($processo->detalhe->anexo_pdf_analise_mercado);
            } elseif ($documento === 'autorizacao_abertura_procedimento' && !empty($processo->detalhe->portaria_agente_equipe_pdf)) {
                $anexoPath = public_path($processo->detalhe->portaria_agente_equipe_pdf);
            } elseif ($documento === 'minutas' && !empty($processo->detalhe->anexar_minuta)) {
                $anexoPath = public_path($processo->detalhe->anexar_minuta);
            } elseif ($documento === 'publicacoes_avisos_licitacao' && !empty($processo->detalhe->anexo_pdf_publicacoes)) {
                $anexoPath = public_path($processo->detalhe->anexo_pdf_publicacoes);
            } elseif ($documento === 'edital' && !empty($processo->detalhe->anexo_pdf_minuta_contrato)) {
                $anexoPath = public_path($processo->detalhe->anexo_pdf_minuta_contrato);
            }

            if ($anexoPath && file_exists($anexoPath)) {
                $fpdi = new Fpdi();

                // Adiciona páginas do PDF principal
                $numPages = $fpdi->setSourceFile($caminhoCompleto);
                for ($pageNo = 1; $pageNo <= $numPages; $pageNo++) {
                    $templateId = $fpdi->importPage($pageNo);
                    $fpdi->addPage();
                    $fpdi->useTemplate($templateId);
                }

                // Adiciona páginas do anexo
                $numPagesAnexo = $fpdi->setSourceFile($anexoPath);
                for ($pageNo = 1; $pageNo <= $numPagesAnexo; $pageNo++) {
                    $templateId = $fpdi->importPage($pageNo);
                    $fpdi->addPage();
                    $fpdi->useTemplate($templateId);
                }

                // Salva o PDF final (sobrescreve o principal)
                $fpdi->Output('F', $caminhoCompleto);
            }
            // =========================================================
            // Caso especial: se o documento for "edital",
            // juntar com o termo de referência no final
            // =========================================================


            // =========================================================
            // Retorno de sucesso (sem recarregar a página)
            // =========================================================
            return response()->json([
                'success' => true,
                'message' => '✅ PDF gerado com sucesso! Clique em "Download" para visualizar o arquivo.',
                'documento' => $documento
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao gerar PDF', [
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile()
            ]);

            return response()->json([
                'success' => false,
                'message' => '❌ Ocorreu um erro inesperado ao gerar o PDF. Detalhes técnicos: ' . $e->getMessage(),
            ], 500);
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
