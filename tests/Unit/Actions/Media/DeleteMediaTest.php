<?php

declare(strict_types = 1);

use App\Actions\Media\DeleteMedia;
use App\Models\Address;
use App\Models\Media;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function (): void {
    $this->disk = 'media-test';
});

it('deletes selected media from storage and database', function (): void {
    Storage::fake($this->disk);

    $model = Address::factory()->create();

    $firstMedia = Media::factory()->entity($model)->create([
        'name'       => 'file-one.png',
        'collection' => 'documents',
        'type'       => 'png',
        'disk'       => $this->disk,
    ]);

    $secondMedia = Media::factory()->entity($model)->create([
        'name'       => 'file-two.png',
        'collection' => 'documents',
        'type'       => 'png',
        'disk'       => $this->disk,
    ]);

    Storage::disk($this->disk)->put($firstMedia->getPath(), 'content 1');
    Storage::disk($this->disk)->put($secondMedia->getPath(), 'content 2');

    expect(Storage::disk($this->disk)->exists($firstMedia->getPath()))->toBeTrue()
        ->and(Storage::disk($this->disk)->exists($secondMedia->getPath()))->toBeTrue();

    new DeleteMedia()->handle($model, [$firstMedia->id, $secondMedia->id]);

    expect(Storage::disk($this->disk)->exists($firstMedia->getPath()))->toBeFalse()
        ->and(Storage::disk($this->disk)->exists($secondMedia->getPath()))->toBeFalse();

    assertDatabaseMissing('media', ['id' => $firstMedia->id]);
    assertDatabaseMissing('media', ['id' => $secondMedia->id]);
});

it('deletes only media that belongs to the given model', function (): void {
    Storage::fake($this->disk);

    $targetModel = Address::factory()->create();
    $otherModel  = Address::factory()->create();

    $targetMedia = Media::factory()->entity($targetModel)->create([
        'name'       => 'target-file.png',
        'collection' => 'documents',
        'type'       => 'png',
        'disk'       => $this->disk,
    ]);

    $otherMedia = Media::factory()->entity($otherModel)->create([
        'name'       => 'other-file.png',
        'collection' => 'documents',
        'type'       => 'png',
        'disk'       => $this->disk,
    ]);

    Storage::disk($this->disk)->put($targetMedia->getPath(), 'target content');
    Storage::disk($this->disk)->put($otherMedia->getPath(), 'other content');

    new DeleteMedia()->handle($targetModel, [$targetMedia->id, $otherMedia->id]);

    expect(Storage::disk($this->disk)->exists($targetMedia->getPath()))->toBeFalse()
        ->and(Storage::disk($this->disk)->exists($otherMedia->getPath()))->toBeTrue();

    assertDatabaseMissing('media', ['id' => $targetMedia->id]);
    assertDatabaseHas('media', ['id' => $otherMedia->id, 'entity_id' => $otherModel->id]);
});

it('preserves the reference when storage refuses deletion', function (bool $throws): void {
    $model = Address::factory()->create();
    $media = Media::factory()->entity($model)->create(['disk' => $this->disk]);
    $disk  = Mockery::mock(FilesystemAdapter::class);
    Storage::shouldReceive('disk')->with($this->disk)->andReturn($disk);
    $expectation = $disk->shouldReceive('delete')->once()->with($media->getPath());

    if ($throws) {
        $expectation->andThrow(new RuntimeException('Storage unavailable'));
    } else {
        $expectation->andReturnFalse();
    }

    expect(fn () => new DeleteMedia()->handle(model: $model, mediaIds: [$media->id]))
        ->toThrow(RuntimeException::class);

    $this->assertModelExists($media);
})->with(['false result' => false, 'exception' => true]);

it('keeps failed and unprocessed references after a partial batch deletion', function (): void {
    $model = Address::factory()->create();
    $media = Media::factory()->count(3)->entity($model)->create(['disk' => $this->disk]);
    $disk  = Mockery::mock(FilesystemAdapter::class);
    Storage::shouldReceive('disk')->with($this->disk)->andReturn($disk);
    $disk->shouldReceive('delete')->once()->with($media[0]->getPath())->andReturnTrue();
    $disk->shouldReceive('delete')->once()->with($media[1]->getPath())->andReturnFalse();

    expect(fn () => new DeleteMedia()->handle(model: $model, mediaIds: $media->modelKeys()))
        ->toThrow(RuntimeException::class);

    $this->assertModelMissing($media[0]);
    $this->assertModelExists($media[1]);
    $this->assertModelExists($media[2]);
});

it('reports a metadata deletion refused by a model event', function (): void {
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $media = Media::factory()->entity($model)->create(['disk' => $this->disk]);
    $disk->put($media->getPath(), 'content');
    Event::listen('eloquent.deleting: ' . Media::class, fn (): bool => false);

    expect(fn () => new DeleteMedia()->handle(model: $model, mediaIds: [$media->id]))
        ->toThrow(RuntimeException::class, 'Não foi possível excluir o registro');

    $this->assertModelExists($media);
    $disk->assertMissing($media->getPath());
});
