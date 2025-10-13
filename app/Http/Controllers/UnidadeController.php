<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;
use App\Http\Requests\UnidadeRequest;

class UnidadeController extends Controller
{
        /**
     * Store a new unidade.
     */
    public function storeUnidade(Request $request, $prefeituraId)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'servidor_responsavel' => 'required|string|max:255',
            'numero_portaria' => 'nullable|string|max:20',
            'data_portaria' => 'nullable|date',
        ]);

        try {
            Unidade::create([
                'prefeitura_id' => $prefeituraId,
                'nome' => $request->nome,
                'servidor_responsavel' => $request->servidor_responsavel,
                'numero_portaria' => $request->numero_portaria,
                'data_portaria' => $request->data_portaria,
            ]);

            return response()->json(['success' => 'Unidade cadastrada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao cadastrar unidade: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update a unidade.
     */
    public function updateUnidade(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'servidor_responsavel' => 'required|string|max:255',
            'numero_portaria' => 'nullable|string|max:20',
            'data_portaria' => 'nullable|date',
        ]);

        try {
            $unidade = Unidade::findOrFail($id);
            $unidade->update([
                'nome' => $request->nome,
                'servidor_responsavel' => $request->servidor_responsavel,
                'numero_portaria' => $request->numero_portaria,
                'data_portaria' => $request->data_portaria,
            ]);

            return response()->json(['success' => 'Unidade atualizada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar unidade: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove a specific unidade.
     */
    public function destroyUnidade($id)
    {
        try {
            $unidade = Unidade::findOrFail($id);
            $unidade->delete();

            return response()->json(['success' => 'Unidade removida com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover unidade: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get unidade data for editing.
     */
    public function getUnidade($id)
    {
        try {
            $unidade = Unidade::findOrFail($id);
            return response()->json($unidade);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unidade não encontrada'], 404);
        }
    }
}
