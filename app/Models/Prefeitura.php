<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prefeitura extends Model
{
    use HasFactory;

    protected $table = 'prefeituras';

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
        'telefone',
        'email',
        'autoridade_competente'
    ];

    public function unidades(): HasMany
    {
        return $this->hasMany(Unidade::class);
    }
}
