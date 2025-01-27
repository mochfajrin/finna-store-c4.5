<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PelamarGender: string implements HasLabel
{
    case MALE = 'l';
    case FEMALE = 'p';

    public function getLabel(): string|null
    {
        return match ($this) {
            self::MALE => "Laki-laki",
            self::FEMALE => "Perempuan",
        };
    }
}
