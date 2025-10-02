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

        return view('Admin.Processos.iniciar', compact('processo'));
    }

    public function storeDetalhe(Request $request, Processo $processo)
    {
        $detalhe = $processo->detalhe ?? new ProcessoDetalhe();
        $detalhe->processo_id = $processo->id;

        // --- Tratamento do arquivo Excel/CSV/XML ---
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


        // --- Salva outros campos normais ---
        $dataToSave = $request->except(['_token', 'processo_id', 'itens_e_seus_quantitativos_xml']);
        foreach ($dataToSave as $field => $value) {
            $detalhe->{$field} = $value;
        }

        $detalhe->save();

        return response()->json([
            'success' => true,
            'data' => $detalhe->toArray()
        ]);
    }

    // public function gerarPdf(Request $request, Processo $processo)
    // {
    //     $documento = $request->query('documento', 'capa');
    //     $dataSelecionada = $request->query('data');

    //     $processo->load(['detalhe', 'prefeitura']);

    //     $data = [
    //         'processo' => $processo,
    //         'prefeitura' => $processo->prefeitura,
    //         'detalhe' => $processo->detalhe,
    //         'dataGeracao' => now()->format('d/m/Y H:i:s'),
    //         'dataSelecionada' => $dataSelecionada,
    //     ];

    //     $view = match ($documento) {
    //         'capa' => 'Admin.Processos.pdf.capa',
    //         'formalizacao' => 'Admin.Processos.pdf.formalizacao',
    //         'autorizacao' => 'Admin.Processos.pdf.autorizacao',
    //         'estudo_tecnico' => 'Admin.Processos.pdf.estudo_tecnico',
    //         'analise_mercado' => 'Admin.Processos.pdf.analise_mercado',
    //         'disponibilidade_orçamento' => 'Admin.Processos.pdf.disponibilidade_orçamento',
    //         'termo_referencia' => 'Admin.Processos.pdf.termo_referencia',
    //         'minutas' => 'Admin.Processos.pdf.minutas',
    //         'parecer_juridico' => 'Admin.Processos.pdf.parecer_juridico',
    //         'autorizacao_abertura_procedimento' => 'Admin.Processos.pdf.autorizacao_abertura_procedimento',
    //         'abertura_fase_externa' => 'Admin.Processos.pdf.abertura_fase_externa',
    //         'publicacoes_avisos_licitacao' => 'Admin.Processos.pdf.publicacoes_avisos_licitacao',
    //         default => 'Admin.Processos.pdf.capa'
    //     };

    //     try {
    //         $pdf = Pdf::loadView($view, $data)
    //             ->setPaper('a4', 'portrait');

    //         $numeroProcessoLimpo = str_replace(['/', '\\'], '_', $processo->numero_processo);
    //         $nomeArquivo = "processo_{$numeroProcessoLimpo}_{$documento}_" . now()->format('Ymd') . '.pdf';

    //         $diretorio = public_path('uploads/documentos/');

    //         if (!file_exists($diretorio)) {
    //             mkdir($diretorio, 0777, true);
    //         }

    //         $documentoExistente = Documento::where('processo_id', $processo->id)
    //             ->where('tipo_documento', $documento)
    //             ->first();

    //         if ($documentoExistente) {
    //             $caminhoAntigo = public_path($documentoExistente->caminho);
    //             if (file_exists($caminhoAntigo)) {
    //                 unlink($caminhoAntigo);
    //             }

    //             $documentoExistente->update([
    //                 'data_selecionada' => $dataSelecionada,
    //                 'caminho' => 'uploads/documentos/' . $nomeArquivo,
    //                 'gerado_em' => now(),
    //             ]);
    //         } else {
    //             Documento::create([
    //                 'processo_id' => $processo->id,
    //                 'tipo_documento' => $documento,
    //                 'data_selecionada' => $dataSelecionada,
    //                 'caminho' => 'uploads/documentos/' . $nomeArquivo,
    //                 'gerado_em' => now(),
    //             ]);
    //         }

    //         $caminhoArquivo = $diretorio . $nomeArquivo;
    //         $pdf->save($caminhoArquivo);

    //         // 👇 MODIFICADO: Retornar JSON com mensagem de sucesso
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'PDF gerado com sucesso! Para baixar, clique no botão Download.',
    //             'documento' => $documento
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Erro ao gerar PDF: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function gerarPdf(Request $request, Processo $processo)
    {
        // Obtém os nomes dos enums em lowercase
        $procedimento = strtolower($processo->tipo_procedimento?->name ?? '');
        $contratacao = strtolower($processo->tipo_contratacao?->name ?? '');

        $documento = $request->query('documento', 'capa');
        $dataSelecionada = $request->query('data');

        $processo->load(['detalhe', 'prefeitura']);

        $data = [
            'processo' => $processo,
            'prefeitura' => $processo->prefeitura,
            'detalhe' => $processo->detalhe,
            'dataGeracao' => now()->format('d/m/Y H:i:s'),
            'dataSelecionada' => $dataSelecionada,
        ];

        // Monta o caminho da view conforme variação do processo
        $viewBase = "Admin.Processos.pdf";
        $viewVaria = "{$viewBase}.{$procedimento}_{$contratacao}.{$documento}";
        $viewPadrao = "{$viewBase}.{$documento}";

        $view = view()->exists($viewVaria) ? $viewVaria : $viewPadrao;

        try {
            $pdf = Pdf::loadView($view, $data)
                ->setPaper('a4', 'portrait');

            $numeroProcessoLimpo = str_replace(['/', '\\'], '_', $processo->numero_processo);

            // Diretório baseado na modalidade, procedimento e contratação
            $modalidade = strtolower(str_replace(' ', '_', $processo->modalidade?->name ?? 'sem_modalidade'));
            $subpasta = "{$modalidade}/{$procedimento}_{$contratacao}/{$documento}";

            $diretorio = public_path("uploads/documentos/{$subpasta}");

            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0777, true);
            }

            // Nome do arquivo sem procedimento/contratação
            $nomeArquivo = "processo_{$numeroProcessoLimpo}_{$documento}_"
                . now()->format('Ymd')
                . '.pdf';

            $caminhoRelativo = "uploads/documentos/{$subpasta}/{$nomeArquivo}";
            $caminhoCompleto = "{$diretorio}/{$nomeArquivo}";

            // Atualiza ou cria registro
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

            // Salva o PDF no caminho
            $pdf->save($caminhoCompleto);

            return response()->json([
                'success' => true,
                'message' => 'PDF gerado com sucesso! Para baixar, clique no botão Download.',
                'documento' => $documento
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar PDF: ' . $e->getMessage()
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
            'publicacoes_avisos_licitacao'
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
