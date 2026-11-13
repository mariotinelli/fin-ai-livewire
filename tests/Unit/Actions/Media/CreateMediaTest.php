<?php

declare(strict_types = 1);

use App\Actions\Media\CreateMedia;
use App\Models\Address;
use App\Models\Media;
use Illuminate\Database\QueryException;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function (): void {
    $this->disk = 'media-test';
});

it('creates media and stores uploaded file in configured disk', function (): void {
    config()->set('filesystems.default', $this->disk);
    Storage::fake($this->disk);

    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->image('profile.png', 200, 200);

    $media = app(CreateMedia::class)->handle($model, 'documents', $file);

    expect($media->entity_id)->toBe($model->id)
        ->and($media->entity_type)->toBe($model->getMorphClass())
        ->and($media->collection)->toBe('documents')
        ->and($media->original_name)->toBe('profile.png')
        ->and($media->type)->toBe('webp')
        ->and($media->disk)->toBe($this->disk)
        ->and($media->size)->toBe(Storage::disk($this->disk)->size($media->getPath()))
        ->and(pathinfo($media->name, PATHINFO_EXTENSION))->toBe('webp');

    expect(Storage::disk($this->disk)->exists("documents/{$media->name}"))->toBeTrue();

    assertDatabaseHas('media', [
        'id'            => $media->id,
        'entity_id'     => $model->id,
        'entity_type'   => $model->getMorphClass(),
        'name'          => $media->name,
        'collection'    => 'documents',
        'original_name' => 'profile.png',
        'type'          => 'webp',
        'disk'          => $this->disk,
        'size'          => (string) Storage::disk($this->disk)->size($media->getPath()),
    ]);
});

it('accepts real images exactly at the dimension limits', function (int $width, int $height): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->image('boundary.png', $width, $height);

    $media = app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file);

    expect(getimagesizefromstring($disk->get($media->getPath())))->toMatchArray([0 => $width, 1 => $height]);
    $this->assertDatabaseCount('media', 1);
})->with([
    'maximum width'  => [8192, 1],
    'maximum height' => [1, 8192],
    'maximum pixels' => [8192, 2048],
]);

it('returns a validation error for corrupt image headers or undecodable pixel data', function (string $contents): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->createWithContent('broken.gif', $contents);

    try {
        app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file);
        $this->fail('Corrupt image was accepted.');
    } catch (ValidationException $validationException) {
        expect($validationException->errors())->toHaveKey('file');
        expect($validationException->errors()['file'][0])->toContain('imagem');
    }

    $this->assertDatabaseCount('media', 0);
    expect($disk->allFiles())->toBeEmpty();
})->with([
    'missing dimensions' => ['GIF89a'],
    'zero dimensions'    => ['GIF89a' . pack('vv', 0, 1) . str_repeat("\0", 20)],
    'corrupt pixel data' => ['GIF89a' . pack('vv', 100, 100) . str_repeat("\0", 20)],
]);

it('creates media preserving original name and extension for non image files', function (): void {
    config()->set('filesystems.default', 'media-private');
    Storage::fake('media-private');

    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->createWithContent('contract.pdf', "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\n%%EOF");

    $media = app(CreateMedia::class)->handle($model, 'contracts', $file);

    expect($media->original_name)->toBe('contract.pdf')
        ->and($media->type)->toBe('pdf')
        ->and($media->disk)->toBe('media-private')
        ->and(pathinfo($media->name, PATHINFO_EXTENSION))->toBe('pdf')
        ->and($media->name)->not->toBe('contract.pdf');

    expect(Storage::disk('media-private')->exists("contracts/{$media->name}"))->toBeTrue();
    expect(Storage::disk('media-private')->get($media->getPath()))->toBe($file->get());

    assertDatabaseHas('media', [
        'id'          => $media->id,
        'collection'  => 'contracts',
        'type'        => 'pdf',
        'disk'        => 'media-private',
        'entity_id'   => $model->id,
        'entity_type' => $model->getMorphClass(),
    ]);
});

it('optimizes a real uncompressed image before storage and records its resulting size', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk   = Storage::fake($this->disk);
    $model  = Address::factory()->create();
    $stream = tmpfile();
    imagepng(imagecreatetruecolor(100, 100), $stream, 0);
    rewind($stream);
    $original = stream_get_contents($stream);
    fclose($stream);
    $file = UploadedFile::fake()->createWithContent('original.png', $original);

    $media = app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file);

    $stored = $disk->get($media->getPath());
    expect(strlen($stored))->toBeLessThan(strlen($original));
    expect(getimagesizefromstring($stored))->toMatchArray([0 => 100, 1 => 100, 'mime' => 'image/webp']);
    expect((int) $media->fresh()->size)->toBe(strlen($stored));
});

it('preserves video bytes and derives the stored extension from its content', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk     = Storage::fake($this->disk);
    $model    = Address::factory()->create();
    $contents = pack('N', 32) . 'ftypisom' . pack('N', 512) . 'isomiso2avc1mp41';
    $file     = UploadedFile::fake()->createWithContent('movie.MP4', $contents);

    $media = app(CreateMedia::class)->handle(model: $model, collection: 'videos', file: $file);

    expect($disk->get($media->getPath()))->toBe($contents);
    expect($media->type)->toBe('mp4');
    expect($media->original_name)->toBe('movie.MP4');
});

it('converts supported raster formats to readable WebP images', function (string $extension): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->image('original.' . $extension, 20, 30);

    $media = app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file);

    expect(getimagesizefromstring($disk->get($media->getPath())))
        ->toMatchArray([0 => 20, 1 => 30, 'mime' => 'image/webp']);
    expect($media->type)->toBe('webp');
    expect($media->getMimeType())->toBe('image/webp');
    expect(pathinfo($media->name, PATHINFO_EXTENSION))->toBe('webp');
    expect($media->original_name)->toBe('original.' . $extension);
})->with(['jpg', 'png', 'gif', 'webp', 'bmp']);

it('normalizes a JPEG alias from real content without changing the original name', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->createWithContent('photo.JPEG', UploadedFile::fake()->image('photo.jpg')->get());

    $media = app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file);

    expect($media->type)->toBe('webp');
    expect($media->original_name)->toBe('photo.JPEG');

    $disk->assertExists($media->getPath());
});

it('orients JPEG pixels from EXIF before encoding WebP', function (int $orientation, bool $redAtTop): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $image = imagecreatetruecolor(40, 20);
    imagefilledrectangle($image, 0, 0, 19, 19, imagecolorallocate($image, 255, 0, 0));
    imagefilledrectangle($image, 20, 0, 39, 19, imagecolorallocate($image, 0, 0, 255));
    $stream = tmpfile();
    imagejpeg($image, $stream, 100);
    rewind($stream);
    $jpeg = stream_get_contents($stream);
    fclose($stream);
    $exif     = "Exif\0\0II\x2a\0" . pack('Vv', 8, 1) . pack('vvVv', 0x0112, 3, 1, $orientation) . "\0\0" . pack('V', 0);
    $contents = substr($jpeg, 0, 2) . "\xff\xe1" . pack('n', strlen($exif) + 2) . $exif . substr($jpeg, 2);
    $file     = UploadedFile::fake()->createWithContent('camera.jpg', $contents);

    $media = app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file);

    $stored = $disk->get($media->getPath());
    expect(getimagesizefromstring($stored))->toMatchArray([0 => 20, 1 => 40, 'mime' => 'image/webp']);
    $decoded = imagecreatefromstring($stored);
    $top     = imagecolorsforindex($decoded, imagecolorat($decoded, 10, 5));
    expect($redAtTop ? $top['red'] : $top['blue'])->toBeGreaterThan(230);
    expect($media->original_name)->toBe('camera.jpg');
})->with([
    'clockwise'        => [6, true],
    'counterclockwise' => [8, false],
]);

it('preserves transparent pixels when converting PNG to WebP', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $image = imagecreatetruecolor(20, 20);
    imagealphablending($image, false);
    imagesavealpha($image, true);
    imagefill($image, 0, 0, imagecolorallocatealpha($image, 0, 0, 0, 127));
    $stream = tmpfile();
    imagepng($image, $stream);
    rewind($stream);
    $file = UploadedFile::fake()->createWithContent('transparent.png', stream_get_contents($stream));
    fclose($stream);

    $media = app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file);

    $decoded = imagecreatefromstring($disk->get($media->getPath()));
    expect(imagecolorsforindex($decoded, imagecolorat($decoded, 10, 10))['alpha'])->toBe(127);
    expect($media->getMimeType())->toBe('image/webp');
});

it('accepts a file exactly at the size limit', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->createWithContent('limit.pdf', "%PDF-1.4\n" . str_repeat('x', 10240 * 1024 - 9));

    $media = app(CreateMedia::class)->handle(model: $model, collection: 'documents', file: $file);

    expect($disk->size($media->getPath()))->toBe(10240 * 1024);
    $this->assertModelExists($media);
});

it('rejects disallowed content and mismatched extensions before writing', function (string $name, string $contents): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->createWithContent($name, $contents);

    expect(fn (): Media => app(CreateMedia::class)->handle(model: $model, collection: 'documents', file: $file))
        ->toThrow(ValidationException::class, 'O conteúdo e a extensão do arquivo devem corresponder a um formato permitido.');

    $this->assertDatabaseCount('media', 0);
    expect($disk->allFiles())->toBeEmpty();
})->with([
    'executable named PDF'                    => ['document.pdf', '<?php echo "executable";'],
    'PDF named image'                         => ['image.png', "%PDF-1.4\n%%EOF"],
    'valid content with executable extension' => ['document.php', "%PDF-1.4\n%%EOF"],
    'SVG'                                     => ['image.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'],
    'missing extension'                       => ['document', "%PDF-1.4\n%%EOF"],
]);

it('rejects oversized uploads before writing', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->create('large.pdf', 10241, 'application/pdf');

    expect(fn (): Media => app(CreateMedia::class)->handle(model: $model, collection: 'documents', file: $file))
        ->toThrow(ValidationException::class);

    $this->assertDatabaseCount('media', 0);
    expect($disk->allFiles())->toBeEmpty();
});

it('validates actual content length despite misleading upload metadata', function (string $contents): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->createWithContent('document.pdf', $contents)->size(1);

    expect(fn (): Media => app(CreateMedia::class)->handle(model: $model, collection: 'documents', file: $file))
        ->toThrow(ValidationException::class, 'O arquivo deve conter dados e ter no máximo 10 MB.');

    $this->assertDatabaseCount('media', 0);
    expect($disk->allFiles())->toBeEmpty();
})->with([
    'empty'     => '',
    'too large' => fn (): string => "%PDF-1.4\n" . str_repeat('x', 10240 * 1024),
]);

it('rejects unsafe collection paths before writing', function (string $collection): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->image('image.png');

    expect(fn (): Media => app(CreateMedia::class)->handle(model: $model, collection: $collection, file: $file))
        ->toThrow(ValidationException::class);

    $this->assertDatabaseCount('media', 0);
    expect($disk->allFiles())->toBeEmpty();
})->with(['../outside', '/absolute', 'documents/../outside', 'documents\\outside', '']);

it('does not persist metadata when image decoding fails', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->createWithContent('broken.gif', 'GIF89a' . str_repeat("\0", 20));

    expect(fn (): Media => app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file))
        ->toThrow(ValidationException::class);

    $this->assertDatabaseCount('media', 0);
    expect($disk->allFiles())->toBeEmpty();
});

it('rejects excessive image dimensions before invoking the decoder or persisting anything', function (int $width, int $height): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->createWithContent('large.gif', 'GIF89a' . pack('vv', $width, $height) . str_repeat("\0", 20));
    Image::shouldReceive('fromBytes')->never();

    try {
        app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file);
        $this->fail('Oversized image was accepted.');
    } catch (ValidationException $validationException) {
        expect($validationException->errors())->toHaveKey('file');
        expect($validationException->errors()['file'][0])->toContain('dimensões');
    }

    $this->assertDatabaseCount('media', 0);
    expect($disk->allFiles())->toBeEmpty();
})->with([
    'width'  => [8193, 1],
    'height' => [1, 8193],
    'pixels' => [4097, 4096],
]);

it('does not create metadata when storage fails', function (bool $throws): void {
    config()->set('filesystems.default', $this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->createWithContent('document.pdf', "%PDF-1.4\n%%EOF");
    $disk  = Mockery::mock(FilesystemAdapter::class);
    Storage::shouldReceive('disk')->with($this->disk)->andReturn($disk);
    $write = $disk->shouldReceive('put')->once();

    if ($throws) {
        $write->andThrow(new RuntimeException('Storage unavailable'));
    } else {
        $write->andReturnFalse();
    }

    $disk->shouldReceive('delete')->once()->andReturnTrue();

    expect(fn (): Media => app(CreateMedia::class)->handle(model: $model, collection: 'documents', file: $file))
        ->toThrow(RuntimeException::class);

    $this->assertDatabaseCount('media', 0);
})->with(['false result' => false, 'exception' => true]);

it('removes the stored file when the database insert fails', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->make();
    $file  = UploadedFile::fake()->image('image.png');

    expect(fn (): Media => app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file))
        ->toThrow(QueryException::class);

    $this->assertDatabaseCount('media', 0);
    expect($disk->allFiles())->toBeEmpty();
});

it('rolls back metadata and removes the file when a created listener fails', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->image('image.png');
    Event::listen('eloquent.created: ' . Media::class, function (): never {
        throw new RuntimeException('Metadata listener failed');
    });

    expect(fn (): Media => app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file))
        ->toThrow(RuntimeException::class, 'Metadata listener failed');

    $this->assertDatabaseCount('media', 0);
    expect($disk->allFiles())->toBeEmpty();
});

it('removes the stored file when a model event refuses creation', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk  = Storage::fake($this->disk);
    $model = Address::factory()->create();
    $file  = UploadedFile::fake()->image('image.png');
    Event::listen('eloquent.creating: ' . Media::class, fn (): bool => false);

    expect(fn (): Media => app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file))
        ->toThrow(RuntimeException::class, 'Não foi possível criar o registro da mídia.');

    $this->assertDatabaseCount('media', 0);
    expect($disk->allFiles())->toBeEmpty();
});

it('reports failed orphan cleanup with the path and original database error', function (bool $throws): void {
    config()->set('filesystems.default', $this->disk);
    $model = Address::factory()->make();
    $file  = UploadedFile::fake()->image('image.png');
    $disk  = Mockery::mock(FilesystemAdapter::class);
    Storage::shouldReceive('disk')->with($this->disk)->andReturn($disk);
    $disk->shouldReceive('put')->once()->andReturnTrue();
    $cleanup = $disk->shouldReceive('delete')->once();

    if ($throws) {
        $cleanup->andThrow(new RuntimeException('Cleanup unavailable'));
    } else {
        $cleanup->andReturnFalse();
    }

    try {
        app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $file);
        $this->fail('Expected orphan cleanup failure.');
    } catch (RuntimeException $runtimeException) {
        expect($runtimeException->getMessage())->toContain('Falha ao limpar o arquivo images/', $this->disk);
        expect($runtimeException->getPrevious())->toBeInstanceOf(QueryException::class);
    }

    $this->assertDatabaseCount('media', 0);
})->with(['false result' => false, 'exception' => true]);

it('stores Livewire temporary uploads without relying on their storeAs result', function (): void {
    config()->set('filesystems.default', $this->disk);
    $disk          = Storage::fake($this->disk);
    $temporaryDisk = Storage::fake('temporary-media');
    $model         = Address::factory()->create();
    $file          = UploadedFile::fake()->image('original.png');
    $name          = TemporaryUploadedFile::generateHashNameWithOriginalNameEmbedded($file);
    $temporaryDisk->put('livewire-tmp/' . $name, $file->get());
    $temporary = new TemporaryUploadedFile($name, 'temporary-media');

    $media = app(CreateMedia::class)->handle(model: $model, collection: 'images', file: $temporary);

    $disk->assertExists($media->getPath());
    expect($media->original_name)->toBe('original.png');
    $temporaryDisk->assertExists('livewire-tmp/' . $name);
});
