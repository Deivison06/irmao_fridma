<?php

namespace App\Enums;

use App\Enums\DisplayNameable;

enum ModalidadeEnum: int implements DisplayNameable
{
    case CONCORRENCIA = 1;
    case DISPENSA = 2;
    case INEXIGIBILIDADE = 3;
    case PREGAO_ELETRONICO = 4;

    public function getDisplayName(): string
    {
        return match ($this) {
            self::CONCORRENCIA => 'CONCORRÊNCIA',
            self::DISPENSA => 'DISPENSA',
            self::INEXIGIBILIDADE => 'INEXIGIBILIDADE',
            self::PREGAO_ELETRONICO => 'PREGÃO ELETRÔNICO',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
