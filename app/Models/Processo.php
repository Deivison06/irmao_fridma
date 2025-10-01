<?php

namespace App\Models;

use App\Enums\ModalidadeEnum;
use App\Enums\TipoContratacaoEnum;
use App\Enums\TipoProcedimentoEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Processo extends Model
{
    use HasFactory;

    protected $table = 'processos';

    protected $fillable = [
        'prefeitura_id',
        'modalidade',
        'numero_processo',
        'numero_procedimento',
        'objeto',
        'tipo_procedimento', // Novo campo
        'tipo_contratacao',  // Novo campo
    ];

    // Cast para trabalhar com enum diretamente
    protected $casts = [
        'modalidade' => ModalidadeEnum::class,
        'tipo_procedimento' => TipoProcedimentoEnum::class,
        'tipo_contratacao' => TipoContratacaoEnum::class,
    ];

    // Relacionamento com Prefeitura
    public function prefeitura()
    {
        return $this->belongsTo(Prefeitura::class);
    }

    public function detalhe()
    {
        return $this->hasOne(ProcessoDetalhe::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }
}
