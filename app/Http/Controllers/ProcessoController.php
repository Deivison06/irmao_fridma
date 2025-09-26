<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Unidade;
use App\Models\Processo;
use App\Models\Documento;
use App\Models\Prefeitura;
use Illuminate\Http\Request;
use App\Models\ProcessoDetalhe;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ProcessoService;
use App\Http\Requests\ProcessoRequest;
use App\Http\Requests\ProcessoDetalheRequest;
use setasign\Fpdi\Fpdi;

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
        // 1. Pega ou cria o detalhe do processo
        $detalhe = $processo->detalhe ?? new ProcessoDetalhe();

        // 2. Prepara os dados
        $dataToSave = $request->except(['_token', 'processo_id']);

        // 3. O 'processo_id' é necessário para vincular
        $detalhe->processo_id = $processo->id;

        // 4. Se o campo sendo salvo for 'unidade_setor', buscar automaticamente o servidor_responsavel
        if ($request->has('unidade_setor') && !empty($request->unidade_setor)) {
            $servidorResponsavel = Unidade::getServidorByNome($request->unidade_setor);

            // Atualiza o campo servidor_responsavel no detalhe
            $detalhe->servidor_responsavel = $servidorResponsavel;
        }

        // 5. Pega o nome do campo que está sendo salvo
        $field = key($dataToSave);
        $value = reset($dataToSave);

        // 6. Processa os dados conforme o tipo
        if (is_array($value)) {
            $detalhe->{$field} = $value;

            // Trata os campos 'outro'
            if ($field === 'instrumento_vinculativo' && $request->has('instrumento_vinculativo_outro')) {
                $detalhe->instrumento_vinculativo_outro = $request->instrumento_vinculativo_outro;
            }
            if ($field === 'prazo_vigencia' && $request->has('prazo_vigencia_outro')) {
                $detalhe->prazo_vigencia_outro = $request->prazo_vigencia_outro;
            }
        } else {
            $detalhe->{$field} = $value;
        }

        // 7. Salva as alterações
        $detalhe->save();

        // 8. Retorna o servidor_responsavel na resposta se for o caso
        $responseData = ['success' => true, 'data' => $detalhe->toArray()];

        if ($request->has('unidade_setor')) {
            $responseData['servidor_responsavel'] = $servidorResponsavel ?? null;
        }

        return response()->json($responseData);
    }

    public function gerarPdf(Request $request, Processo $processo)
    {
        $documento = $request->query('documento', 'capa');
        $dataSelecionada = $request->query('data'); // 👈 pega a data do input

        $processo->load(['detalhe', 'prefeitura']);

        $data = [
            'processo' => $processo,
            'prefeitura' => $processo->prefeitura,
            'detalhe' => $processo->detalhe,
            'dataGeracao' => now()->format('d/m/Y H:i:s'),
            'dataSelecionada' => $dataSelecionada, // 👈 envia para a view do PDF
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
            $nomeArquivo = "processo_{$numeroProcessoLimpo}_{$documento}_" . now()->format('Ymd_His') . '.pdf';

            // Definir o caminho para salvar o arquivo
            $diretorio = public_path('uploads/documentos/');

            // Verificar se o diretório existe, caso contrário, criá-lo
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0777, true); // Cria o diretório com permissão total
            }

            // Verificar se o documento já existe
            $documentoExistente = Documento::where('processo_id', $processo->id)
                ->where('tipo_documento', $documento)
                ->first();

            // Se o documento existir, excluir o arquivo antigo
            if ($documentoExistente) {
                // Remover o arquivo antigo do sistema de arquivos
                $caminhoAntigo = public_path($documentoExistente->caminho);
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo); // Remove o arquivo antigo
                }

                // Atualizar os dados do documento no banco de dados
                $documentoExistente->update([
                    'data_selecionada' => $dataSelecionada,
                    'caminho' => 'uploads/documentos/' . $nomeArquivo,
                ]);
            } else {
                // Caso o documento não exista, criar um novo registro
                Documento::create([
                    'processo_id' => $processo->id,
                    'tipo_documento' => $documento,
                    'data_selecionada' => $dataSelecionada,
                    'caminho' => 'uploads/documentos/' . $nomeArquivo,
                ]);
            }

            // Salvar o novo arquivo PDF
            $caminhoArquivo = $diretorio . $nomeArquivo;
            $pdf->save($caminhoArquivo);

            // Retornar o PDF para o usuário
            return $request->query('download') == 1
                ? $pdf->download($nomeArquivo)
                : $pdf->stream($nomeArquivo);
        } catch (\Exception $e) {
            dd($e->getMessage());
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
