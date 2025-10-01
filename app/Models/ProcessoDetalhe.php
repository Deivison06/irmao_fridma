<?php

namespace App\Models;

use App\Enums\TipoContratacaoEnum;
use App\Enums\TipoProcedimentoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessoDetalhe extends Model
{
    use HasFactory;

    protected $table = 'processo_detalhes';

    protected $fillable = [
        'processo_id',
        'secretaria',
        'unidade_setor',
        'servidor_responsavel',
        'demanda',
        'justificativa',
        'prazo_entrega',
        'local_entrega',
        'contratacoes_anteriores',
        'fiscais',
        'gestor',
        'instrumento_vinculativo',
        'instrumento_vinculativo_outro',
        'prazo_vigencia',
        'prazo_vigencia_outro',
        'objeto_continuado',
        'itens_e_seus_quantitativos_xml',
    ];

    protected $casts = [
        'instrumento_vinculativo' => 'array',
        'prazo_vigencia' => 'array',
        'itens_e_seus_quantitativos_xml' => 'array',
    ];

    /**
     * Relação com Processo
     */
    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }
}
