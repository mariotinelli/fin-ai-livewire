<?php

declare(strict_types = 1);

namespace App\Actions\Media;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

final readonly class DeleteMedia
{
    /** @param array<int, int> $mediaIds */
    public function handle(Model $model, array $mediaIds): void
    {
        $media = Media::query()
            ->where('entity_id', $model->getKey())
            ->where('entity_type', $model->getMorphClass())
            ->whereIn('id', $mediaIds);

        foreach ($media->get() as $item) {
            if (!Storage::disk($item->disk)->delete($item->getPath())) {
                throw new RuntimeException("Não foi possível excluir o arquivo {$item->getPath()} do disco {$item->disk}.");
            }

            if (!$item->delete()) {
                throw new RuntimeException("Não foi possível excluir o registro da mídia {$item->id}.");
            }
        }
    }
}
