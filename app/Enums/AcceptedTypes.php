<?php

declare(strict_types = 1);

namespace App\Enums;

enum AcceptedTypes: string
{
    case Image = 'image';
    case Doc   = 'doc';
    case Pdf   = 'pdf';
    case Video = 'video';

    public function label(): string
    {
        return match ($this) {
            self::Image => 'Imagem',
            self::Doc   => 'DOC',
            self::Pdf   => 'PDF',
            self::Video => 'Vídeo',
        };
    }

    public static function default(): string
    {
        return collect([
            AcceptedTypes::Image,
            AcceptedTypes::Pdf,
        ])
            ->map(fn (AcceptedTypes $type): array => $type->mimes())
            ->flatten()
            ->unique()
            ->implode(',');
    }

    /** @return list<string> */
    public function mimes(): array
    {
        return match ($this) {
            self::Image => ['image/*'],
            self::Doc   => [
                'application/msword',
                'application/vnd.ms-word',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
            self::Pdf   => ['application/pdf'],
            self::Video => ['video/*'],
        };
    }
}
