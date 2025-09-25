<?php

namespace App\Http\Controllers;

use App\Models\Prefeitura;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrefeituraController extends Controller
{
    public function index()
    {
        $prefeituras = Prefeitura::all();
        return view('Admin.Prefeituras.index', compact('prefeituras'));
    }

    public function create()
    {
        return view('Admin.Prefeituras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:prefeituras,cnpj',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'autoridade_competente' => 'required|string|max:255',
            'capa' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'timbre' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'nome', 'cnpj', 'endereco', 'telefone', 'email', 'autoridade_competente'
        ]);

        // Upload da capa
        if ($request->hasFile('capa')) {
            $capaName = time() . '_capa.' . $request->file('capa')->getClientOriginalExtension();
            $request->file('capa')->move(public_path('uploads/prefeituras'), $capaName);
            $data['capa'] = 'uploads/prefeituras/' . $capaName;
        }

        // Upload do timbre
        if ($request->hasFile('timbre')) {
            $timbreName = time() . '_timbre.' . $request->file('timbre')->getClientOriginalExtension();
            $request->file('timbre')->move(public_path('uploads/prefeituras'), $timbreName);
            $data['timbre'] = 'uploads/prefeituras/' . $timbreName;
        }

        try {
            Prefeitura::create($data);
            return redirect()->route('admin.prefeituras.index')->with('success', 'Prefeitura cadastrada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar prefeitura: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $prefeitura = Prefeitura::with('unidades')->findOrFail($id);
        return view('Admin.Prefeituras.show', compact('prefeitura'));
    }

    public function edit($id)
    {
        $prefeitura = Prefeitura::with('unidades')->findOrFail($id);
        return view('Admin.Prefeituras.edit', compact('prefeitura'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:prefeituras,cnpj,' . $id,
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'autoridade_competente' => 'required|string|max:255',
            'capa' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'timbre' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $prefeitura = Prefeitura::findOrFail($id);

        $data = $request->only([
            'nome', 'cnpj', 'endereco', 'telefone', 'email', 'autoridade_competente'
        ]);

        // Upload da capa (se houver)
        if ($request->hasFile('capa')) {
            $capaName = time() . '_capa.' . $request->file('capa')->getClientOriginalExtension();
            $request->file('capa')->move(public_path('uploads/prefeituras'), $capaName);
            $data['capa'] = 'uploads/prefeituras/' . $capaName;
        }

        // Upload do timbre (se houver)
        if ($request->hasFile('timbre')) {
            $timbreName = time() . '_timbre.' . $request->file('timbre')->getClientOriginalExtension();
            $request->file('timbre')->move(public_path('uploads/prefeituras'), $timbreName);
            $data['timbre'] = 'uploads/prefeituras/' . $timbreName;
        }

        try {
            $prefeitura->update($data);
            return redirect()->route('admin.prefeituras.index')->with('success', 'Prefeitura atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar prefeitura: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $prefeitura = Prefeitura::findOrFail($id);

            // Remove unidades
            $prefeitura->unidades()->delete();

            // Remove prefeitura
            $prefeitura->delete();

            DB::commit();

            return redirect()->route('admin.prefeituras.index')->with('success', 'Prefeitura excluída com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao excluir prefeitura: ' . $e->getMessage());
        }
    }
}
