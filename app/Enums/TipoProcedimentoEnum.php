<?php

namespace App\Enums;

enum TipoProcedimentoEnum: int implements DisplayNameable
{
    case SERVIÇOS = 1;
    case COMPRAS = 2;

    public function getDisplayName(): string
    {
        return match ($this) {
            self::SERVIÇOS => 'SERVIÇOS',
            self::COMPRAS => 'COMPRAS',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
