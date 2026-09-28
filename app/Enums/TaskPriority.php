<?php

namespace App\Enums;

enum TaskPriority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
    case Urgent = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Nízka',
            self::Medium => 'Stredná',
            self::High => 'Vysoká',
            self::Urgent => 'Urgentná',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Low => 'slate',
            self::Medium => 'sky',
            self::High => 'orange',
            self::Urgent => 'red',
        };
    }
}
