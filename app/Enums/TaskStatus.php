<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Čaká na spracovanie',
            self::InProgress => 'V riešení',
            self::Completed => 'Dokončená',
            self::Cancelled => 'Zrušená',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'amber',
            self::InProgress => 'blue',
            self::Completed => 'emerald',
            self::Cancelled => 'rose',
        };
    }
}
