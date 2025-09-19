<?php

namespace App\Enums;

interface DisplayNameable
{
    public function getDisplayName(): string | int;
}
