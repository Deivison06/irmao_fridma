<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unidade extends Model
{
    use HasFactory;

    protected $table = 'unidades';

    protected $fillable = [
        'prefeitura_id',
        'nome',
        'servidor_responsavel'
    ];

    public function prefeitura(): BelongsTo
    {
        return $this->belongsTo(Prefeitura::class);
    }

    // Método para buscar o servidor responsável pelo nome da unidade
    public static function getServidorByNome($nomeUnidade)
    {
        return static::where('nome', $nomeUnidade)->value('servidor_responsavel');
    }
}
