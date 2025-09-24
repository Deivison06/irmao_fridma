<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use App\Models\Prefeitura;
use Illuminate\Http\Request;
use App\Models\ProcessoDetalhe;
use App\Services\ProcessoService;
use App\Http\Requests\ProcessoRequest;
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
    // 1. Pega ou cria o detalhe do processo
    $detalhe = $processo->detalhe ?? new ProcessoDetalhe();

    // 2. Prepara os dados (remover chaves não relacionadas às colunas)
    $dataToSave = $request->except(['_token', 'processo_id']);

    // 3. O 'processo_id' é necessário para vincular, principalmente se for um NOVO registro
    $detalhe->processo_id = $processo->id;

    // 4. Se for um campo de array (checkboxes), trate-o
    // O Laravel vai serializar campos de array (instrumento_vinculativo, prazo_vigencia)
    // para JSON se você usar 'casts' no seu Model ProcessoDetalhe.

    // 5. Atualiza APENAS o campo enviado (ex: 'secretaria' ou 'demanda')
    // Como você só envia 1 campo por vez (além dos arrays), podemos iterar sobre os dados restantes

    // Pega o nome do campo que está sendo salvo (é a chave que resta)
    $field = key($dataToSave);
    $value = reset($dataToSave);

    // Se for um array de chaves (como checkboxes), você deve ter um 'casts' no seu Model
    // (Ex: protected $casts = ['instrumento_vinculativo' => 'array'];)
    if (is_array($value)) {
        // Se for um array, salve o array.
        $detalhe->{$field} = $value;

        // Trata os campos 'outro'
        if ($field === 'instrumento_vinculativo' && $request->has('instrumento_vinculativo_outro')) {
            $detalhe->instrumento_vinculativo_outro = $request->instrumento_vinculativo_outro;
        }
        if ($field === 'prazo_vigencia' && $request->has('prazo_vigencia_outro')) {
            $detalhe->prazo_vigencia_outro = $request->prazo_vigencia_outro;
        }

    } else {
        // Se for um campo simples (texto, radio), salve-o.
        $detalhe->{$field} = $value;
    }


    // 6. Salva as alterações (fará INSERT se for novo ou UPDATE se for existente)
    $detalhe->save();

    return response()->json(['success' => true, 'data' => $detalhe->toArray()]);
}
}
