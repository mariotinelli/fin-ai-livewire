<?php

declare(strict_types = 1);

use App\Actions\Media\GetMedia;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

it('returns media payload with expected structure', function (): void {
    $model = User::factory()->create();

    $media = Media::factory()->entity($model)->create([
        'name'          => 'generated-name.png',
        'original_name' => 'avatar.png',
        'collection'    => 'documents',
        'type'          => 'png',
        'disk'          => 'local',
        'size'          => '512',
    ]);

    Storage::shouldReceive('disk')->once()->with('local')->andReturnSelf();
    Storage::shouldReceive('temporaryUrl')
        ->once()
        ->with('documents/generated-name.png', Mockery::type(DateTimeInterface::class))
        ->andReturn('https://example.test/temp/documents/generated-name.png');

    $payload = new GetMedia()->handle($media);

    expect($payload)
        ->toHaveKeys(['id', 'name', 'preview', 'type', 'size', 'updatedAt'])
        ->and($payload['id'])->toBe($media->id)
        ->and($payload['name'])->toBe('avatar.png')
        ->and($payload['preview'])->toBe('https://example.test/temp/documents/generated-name.png')
        ->and($payload['type'])->toBe('png')
        ->and($payload['size'])->toBe('512')
        ->and($payload['updatedAt'])->toEqual($media->updated_at);
});
