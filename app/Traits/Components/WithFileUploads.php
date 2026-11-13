<?php

declare(strict_types = 1);

namespace App\Traits\Components;

use App\Enums\AcceptedTypes;
use Livewire\Features\SupportFileUploads\WithFileUploads as BaseWithFileUploads;

trait WithFileUploads
{
    use BaseWithFileUploads;

    private int $maxFiles = 10;

    private int $maxFileSize = 5; // in MB

    /** @var array<AcceptedTypes> */
    private array $mimes = [
        AcceptedTypes::Image,
        AcceptedTypes::Pdf,
    ];

    public function getAcceptedMimeTypes(): string
    {
        return collect($this->mimes)
            ->map(fn (AcceptedTypes $type): array => $type->mimes())
            ->flatten()
            ->unique()
            ->implode(',');
    }

    /**
     * @param array<AcceptedTypes> $types
     */
    public function setAcceptedMimeTypes(array $types): void
    {
        $this->mimes = $types;
    }

    public function getMaxFiles(): int
    {
        return $this->maxFiles;
    }

    public function setMaxFiles(int $maxFiles): void
    {
        $this->maxFiles = $maxFiles;
    }

    public function getMaxFileSize(): int
    {
        return $this->maxFileSize * 1024; // Convert to KB
    }

    public function setMaxFileSize(int $maxFileSize): void
    {
        $this->maxFileSize = $maxFileSize;
    }
}
