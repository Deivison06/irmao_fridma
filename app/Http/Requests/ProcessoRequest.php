<?php

namespace App\Http\Requests;

use App\Enums\ModalidadeEnum;
use Illuminate\Foundation\Http\FormRequest;

class ProcessoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ajuste conforme sua lógica de autorização
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'prefeitura_id' => 'required|exists:prefeituras,id',
            'modalidade' => 'required|integer|in:' . implode(',', ModalidadeEnum::values()),
            'numero_processo' => 'required|string|max:10',
            'numero_procedimento' => 'required|string|max:10',
            'objeto' => 'required|string',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'prefeitura_id.required' => 'A prefeitura é obrigatória.',
            'prefeitura_id.exists' => 'A prefeitura selecionada não existe.',
            'modalidade.required' => 'A modalidade é obrigatória.',
            'modalidade.in' => 'A modalidade selecionada é inválida.',
            'numero_processo.required' => 'O número do processo é obrigatório.',
            'numero_processo.max' => 'O número do processo deve ter no máximo 10 caracteres.',
            'numero_procedimento.required' => 'O número do procedimento é obrigatório.',
            'numero_procedimento.max' => 'O número do procedimento deve ter no máximo 10 caracteres.',
            'objeto.required' => 'O objeto é obrigatório.',
        ];
    }
}
