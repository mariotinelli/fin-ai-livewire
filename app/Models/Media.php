<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $entity_type
 * @property int $entity_id
 * @property string $name
 * @property string $original_name
 * @property string $collection
 * @property string $type
 * @property string $disk
 * @property int|numeric-string $size
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Model $entity
 */
class Media extends BaseModel
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory;

    /** @return MorphTo<Model, $this> */
    public function entity(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrl(): string
    {
        return Storage::disk($this->disk)->temporaryUrl($this->getPath(), now()->addMinutes(10));
    }

    public function getPath(): string
    {
        return "{$this->collection}/{$this->name}";
    }

    public function getMimeType(): string
    {
        return match ($this->type) {
            'pdf'   => 'application/pdf',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'png'   => 'image/png',
            'gif'   => 'image/gif',
            'webp'  => 'image/webp',
            default => 'application/octet-stream',
        };
    }
}
