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

    public function gerarPdf(Request $request, Processo $processo)
    {
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

        $view = match ($documento) {
            'capa' => 'Admin.Processos.pdf.capa',
            'formalizacao' => 'Admin.Processos.pdf.formalizacao',
            'autorizacao' => 'Admin.Processos.pdf.autorizacao',
            'estudo_tecnico' => 'Admin.Processos.pdf.estudo_tecnico',
            default => 'Admin.Processos.pdf.capa'
        };

        try {
            $pdf = Pdf::loadView($view, $data)
                ->setPaper('a4', 'portrait');

            $numeroProcessoLimpo = str_replace(['/', '\\'], '_', $processo->numero_processo);
            $nomeArquivo = "processo_{$numeroProcessoLimpo}_{$documento}_" . now()->format('Ymd') . '.pdf';

            $diretorio = public_path('uploads/documentos/');

            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0777, true);
            }

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
                    'caminho' => 'uploads/documentos/' . $nomeArquivo,
                    'gerado_em' => now(),
                ]);
            } else {
                Documento::create([
                    'processo_id' => $processo->id,
                    'tipo_documento' => $documento,
                    'data_selecionada' => $dataSelecionada,
                    'caminho' => 'uploads/documentos/' . $nomeArquivo,
                    'gerado_em' => now(),
                ]);
            }

            $caminhoArquivo = $diretorio . $nomeArquivo;
            $pdf->save($caminhoArquivo);

            // 👇 MODIFICADO: Retornar JSON com mensagem de sucesso
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
        // Buscar todos os documentos gerados para este processo
        $documentos = Documento::where('processo_id', $processo->id)->get();

        // Inicializar o FPDI para mesclar os PDFs
        $pdf = new Fpdi();

        // Loop sobre os documentos e adicionar cada PDF
        foreach ($documentos as $documento) {
            $caminhoDocumento = public_path($documento->caminho);

            // Verificar se o arquivo PDF existe
            if (file_exists($caminhoDocumento)) {
                // Contar o número de páginas do PDF existente
                $numPages = $pdf->setSourceFile($caminhoDocumento);

                // Adicionar cada página do PDF ao PDF final
                for ($pageNo = 1; $pageNo <= $numPages; $pageNo++) {
                    // Importa a página e a adiciona ao PDF
                    $templateId = $pdf->importPage($pageNo);
                    $pdf->addPage();
                    $pdf->useTemplate($templateId);
                }
            }
        }

        // Gerar o nome do arquivo final
        $numeroProcessoLimpo = str_replace(['/', '\\'], '_', $processo->numero_processo);
        $nomeArquivo = "processo_{$numeroProcessoLimpo}_todos_documentos_" . now()->format('Ymd_His') . '.pdf';

        // Definir o caminho para salvar o PDF
        $diretorio = public_path('uploads/documentos/');

        // Verificar se o diretório existe, caso contrário, criá-lo
        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0777, true); // Cria o diretório com permissão total
        }

        // Salvar o PDF gerado
        $caminhoArquivo = $diretorio . $nomeArquivo;
        $pdf->Output('F', $caminhoArquivo); // Salva o arquivo no diretório

        // Retornar o PDF gerado para o usuário
        return response()->download($caminhoArquivo)->deleteFileAfterSend(true); // Remove após o envio
    }
}
