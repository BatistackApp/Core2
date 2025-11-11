<?php

namespace App\Enums\Facturation;

enum StatusPayment: string
{
    case UNALLOCATED = 'unallocated';
    case PARTIALLY_ALLOCATED = 'partially_allocated';
    case ALLOCATED = 'allocated';

    public function label(): string
    {
        return match ($this) {
            self::UNALLOCATED => "Non Allouer",
            self::PARTIALLY_ALLOCATED => "Partiellement Allouer",
            self::ALLOCATED => "Allouer",
        };
    }
}
