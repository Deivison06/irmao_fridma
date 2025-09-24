<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessoDetalheRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'processo_id' => 'required|exists:processos,id',
            'secretaria' => 'required|string|max:255',
            'unidade_setor' => 'nullable|string|max:255',
            'servidor_responsavel' => 'nullable|string|max:255',
            'demanda' => 'nullable|string',
            'justificativa' => 'nullable|string',
            'prazo_entrega' => 'nullable|string|max:255',
            'local_entrega' => 'nullable|string|max:255',
            'contratacoes_anteriores' => 'nullable|in:sim,nao',
            'fiscais' => 'nullable|string|max:255',
            'gestor' => 'nullable|string|max:255',
            'instrumento_vinculativo' => 'nullable|array',
            'instrumento_vinculativo.*' => 'string',
            'instrumento_vinculativo_outro' => 'nullable|string|max:255',
            'prazo_vigencia' => 'nullable|array',
            'prazo_vigencia.*' => 'string',
            'prazo_vigencia_outro' => 'nullable|string|max:255',
            'objeto_continuado' => 'nullable|in:sim,nao',
        ];
    }
}
