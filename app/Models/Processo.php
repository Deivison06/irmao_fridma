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
        'tipo_procedimento',
        'tipo_contratacao',
        'unidade_numeracao',
        'responsavel_numeracao',
        'portaria_numeracao',
    ];

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

    public function getTipoContratacaoNomeAttribute(): string
    {
        return $this->tipo_contratacao?->getDisplayName() ?? '—';
    }

    public function getTipoProcedimentoNomeAttribute(): string
    {
        return $this->tipo_procedimento?->getDisplayName() ?? '—';
    }

    // Accessor para garantir que campos nullable retornem null quando vazios
    public function setResponsavelNumeracaoAttribute($value)
    {
        $this->attributes['responsavel_numeracao'] = $value ?: null;
    }

    public function setPortariaNumeracaoAttribute($value)
    {
        $this->attributes['portaria_numeracao'] = $value ?: null;
    }

    public function setUnidadeNumeracaoAttribute($value)
    {
        $this->attributes['unidade_numeracao'] = $value ?: null;
    }
}
