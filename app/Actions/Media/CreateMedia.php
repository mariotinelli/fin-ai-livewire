<?php

declare(strict_types = 1);

namespace App\Actions\Media;

use App\Models\Media;
use finfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Image\ImageException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use RuntimeException;
use Throwable;

final readonly class CreateMedia
{
    private const int MAX_IMAGE_WIDTH = 8192;

    private const int MAX_IMAGE_HEIGHT = 8192;

    private const int MAX_IMAGE_PIXELS = 16_777_216;

    /** @var array<string, list<string>> */
    private const array MIME_EXTENSIONS = [
        'image/jpeg'                                                              => ['jpg', 'jpeg'],
        'image/png'                                                               => ['png'],
        'image/gif'                                                               => ['gif'],
        'image/webp'                                                              => ['webp'],
        'image/bmp'                                                               => ['bmp'],
        'image/avif'                                                              => ['avif'],
        'application/pdf'                                                         => ['pdf'],
        'application/msword'                                                      => ['doc'],
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => ['docx'],
        'video/mp4'                                                               => ['mp4', 'm4v'],
        'video/webm'                                                              => ['webm'],
        'video/quicktime'                                                         => ['mov'],
        'video/x-msvideo'                                                         => ['avi'],
        'video/mpeg'                                                              => ['mpeg', 'mpg'],
        'video/ogg'                                                               => ['ogv'],
    ];

    public function __construct(private finfo $fileInfo)
    {
    }

    public function handle(Model $model, string $collection, TemporaryUploadedFile | UploadedFile $file): Media
    {
        Validator::make([
            'file'          => $file,
            'collection'    => $collection,
            'original_name' => $file->getClientOriginalName(),
        ], [
            'file'          => ['required', 'file', 'max:10240'],
            'collection'    => ['required', 'string', 'max:255', 'regex:~^[a-zA-Z0-9_-]+(?:/[a-zA-Z0-9_-]+)*$~D'],
            'original_name' => ['required', 'string', 'max:255'],
        ])->validate();

        $contents = $file->get();

        if (!is_string($contents) || $contents === '' || strlen($contents) > 10240 * 1024) {
            throw ValidationException::withMessages(['file' => 'O arquivo deve conter dados e ter no máximo 10 MB.']);
        }

        $mimeType   = $this->fileInfo->buffer($contents, FILEINFO_MIME_TYPE);
        $extensions = is_string($mimeType) ? (self::MIME_EXTENSIONS[$mimeType] ?? []) : [];

        if (!in_array(strtolower($file->getClientOriginalExtension()), $extensions, true)) {
            throw ValidationException::withMessages(['file' => 'O conteúdo e a extensão do arquivo devem corresponder a um formato permitido.']);
        }

        $extension = $extensions[0];

        if (str_starts_with($mimeType, 'image/')) {
            $this->validateImageDimensions($contents);

            try {
                $contents  = Image::fromBytes($contents)->orient()->optimize(format: 'webp', quality: 80)->toBytes();
                $extension = 'webp';
            } catch (ImageException) {
                throw ValidationException::withMessages(['file' => 'Não foi possível processar a imagem. O arquivo pode estar corrompido.']);
            }
        }

        $diskName = config()->string('filesystems.default');
        $disk     = Storage::disk($diskName);
        $fileName = Str::uuid()->toString() . '.' . $extension;
        $path     = "{$collection}/{$fileName}";

        try {
            if (!$disk->put($path, $contents)) {
                throw new RuntimeException("Não foi possível gravar o arquivo {$path} no disco {$diskName}.");
            }

            return DB::transaction(function () use ($model, $collection, $file, $fileName, $extension, $diskName, $contents): Media {
                $media = Media::query()->create([
                    'entity_id'     => $model->getKey(),
                    'entity_type'   => $model->getMorphClass(),
                    'name'          => $fileName,
                    'collection'    => $collection,
                    'original_name' => $file->getClientOriginalName(),
                    'type'          => $extension,
                    'disk'          => $diskName,
                    'size'          => strlen($contents),
                ]);

                if (!$media->exists) {
                    throw new RuntimeException('Não foi possível criar o registro da mídia.');
                }

                return $media;
            });
        } catch (Throwable $throwable) {
            try {
                if (!$disk->delete($path)) {
                    throw new RuntimeException('O storage recusou a limpeza.');
                }
            } catch (Throwable $cleanupException) {
                throw new RuntimeException(
                    "Falha ao limpar o arquivo {$path} no disco {$diskName}: {$cleanupException->getMessage()}",
                    previous: $throwable,
                );
            }

            throw $throwable;
        }
    }

    private function validateImageDimensions(string $contents): void
    {
        $metadata = @getimagesizefromstring($contents);
        $width    = $metadata[0] ?? 0;
        $height   = $metadata[1] ?? 0;

        if ($width < 1 || $height < 1) {
            throw ValidationException::withMessages(['file' => 'Não foi possível identificar as dimensões da imagem.']);
        }

        if (
            $width > self::MAX_IMAGE_WIDTH
            || $height > self::MAX_IMAGE_HEIGHT
            || $width > intdiv(self::MAX_IMAGE_PIXELS, $height)
        ) {
            throw ValidationException::withMessages(['file' => 'As dimensões da imagem excedem o limite permitido.']);
        }
    }
}
