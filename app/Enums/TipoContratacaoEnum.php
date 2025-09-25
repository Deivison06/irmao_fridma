<?php

namespace App\Enums;

enum TipoContratacaoEnum: int implements DisplayNameable
{
    case LOTE = 1;
    case ITEM = 2;

    public function getDisplayName(): string
    {
        return match ($this) {
            self::LOTE => 'LOTE',
            self::ITEM => 'ITEM',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
