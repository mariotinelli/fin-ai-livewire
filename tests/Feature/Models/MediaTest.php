<?php

declare(strict_types = 1);

use App\Models\Address;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

it('returns entity morph relation', function (): void {
    $media = Media::factory()->make();

    expect($media->entity()->getMorphType())->toBe('entity_type')
        ->and($media->entity()->getForeignKeyName())->toBe('entity_id');
});

it('returns full media path from collection and name', function (): void {
    $media = Media::factory()->make([
        'collection' => 'documents',
        'name'       => 'file.png',
    ]);

    expect($media->getPath())->toBe('documents/file.png');
});

it('returns temporary url from configured disk and path', function (): void {
    $media = Media::factory()->make([
        'disk'       => 'media-test',
        'collection' => 'documents',
        'name'       => 'file.png',
    ]);

    Storage::shouldReceive('disk')->once()->with('media-test')->andReturnSelf();
    Storage::shouldReceive('temporaryUrl')
        ->once()
        ->with('documents/file.png', Mockery::type(DateTimeInterface::class))
        ->andReturn('https://example.test/documents/file.png');

    expect($media->getUrl())->toBe('https://example.test/documents/file.png');
});

it('resolves entity relation to the polymorphic model', function (): void {
    $address = Address::factory()->create();
    $media   = Media::factory()->entity($address)->create();

    expect($media->entity?->is($address))->toBeTrue();
});

it('maps stored extensions to download mime types', function (string $extension, string $mimeType): void {
    $media = Media::factory()->make(['type' => $extension]);

    expect($media->getMimeType())->toBe($mimeType);
})->with([
    'pdf'     => ['pdf', 'application/pdf'],
    'jpg'     => ['jpg', 'image/jpeg'],
    'jpeg'    => ['jpeg', 'image/jpeg'],
    'png'     => ['png', 'image/png'],
    'gif'     => ['gif', 'image/gif'],
    'webp'    => ['webp', 'image/webp'],
    'unknown' => ['zip', 'application/octet-stream'],
]);
