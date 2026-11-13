<?php

declare(strict_types = 1);

use App\Enums\AcceptedTypes;
use App\Traits\Components\WithFileUploads;

it('exposes upload defaults and accepts explicit limits and mime groups', function (): void {
    $uploads = new class () {
        use WithFileUploads;
    };

    expect($uploads->getAcceptedMimeTypes())->toBe('image/*,application/pdf')
        ->and($uploads->getMaxFiles())->toBe(10)
        ->and($uploads->getMaxFileSize())->toBe(5120);

    $uploads->setAcceptedMimeTypes([AcceptedTypes::Doc, AcceptedTypes::Pdf]);
    $uploads->setMaxFiles(3);
    $uploads->setMaxFileSize(8);

    expect($uploads->getAcceptedMimeTypes())->toContain('application/msword', 'application/pdf')
        ->and($uploads->getMaxFiles())->toBe(3)
        ->and($uploads->getMaxFileSize())->toBe(8192);
});
