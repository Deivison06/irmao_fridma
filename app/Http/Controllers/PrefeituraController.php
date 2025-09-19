<?php

namespace App\Http\Controllers;

use App\Models\Prefeitura;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrefeituraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prefeituras = Prefeitura::all();
        return view('Admin.Prefeituras.index', compact('prefeituras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Prefeituras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:prefeituras,cnpj',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'autoridade_competente' => 'required|string|max:255',
        ]);

        try {
            Prefeitura::create($request->all());
            return redirect()->route('admin.prefeituras.index')->with('success', 'Prefeitura cadastrada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar prefeitura: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $prefeitura = Prefeitura::with('unidades')->findOrFail($id);
        return view('Admin.Prefeituras.show', compact('prefeitura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $prefeitura = Prefeitura::with('unidades')->findOrFail($id);
        return view('Admin.Prefeituras.edit', compact('prefeitura'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:prefeituras,cnpj,' . $id,
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'autoridade_competente' => 'required|string|max:255',
        ]);

        try {
            $prefeitura = Prefeitura::findOrFail($id);

            // Atualiza dados da prefeitura
            $prefeitura->update($request->only([
                'nome', 'cnpj', 'endereco', 'telefone', 'email', 'autoridade_competente'
            ]));

            return redirect()->route('admin.prefeituras.index')->with('success', 'Prefeitura atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar prefeitura: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $prefeitura = Prefeitura::findOrFail($id);

            // Remove todas as unidades primeiro
            $prefeitura->unidades()->delete();

            // Remove a prefeitura
            $prefeitura->delete();

            DB::commit();

            return redirect()->route('admin.prefeituras.index')->with('success', 'Prefeitura excluída com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao excluir prefeitura: ' . $e->getMessage());
        }
    }


}
