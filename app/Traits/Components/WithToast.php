<?php

declare(strict_types = 1);

namespace App\Traits\Components;

use App\Enums\Toast;

trait WithToast
{
    /** Title and description are plain text, including when queued for the next page. */
    protected function toast(
        string $title,
        ?string $description = null,
        Toast $type = Toast::Success,
        int $time = 7,
        bool $nextPage = false,
        bool $persistent = false,
    ): void {
        if ($nextPage) {
            $toasts = session()->get('toast', []);
            $toasts = is_array($toasts) ? $toasts : [];

            $toasts[] = [
                'title'       => $title,
                'description' => $description,
                'type'        => $type->value,
                'time'        => $time,
                'persistent'  => $persistent,
            ];

            session()->put('toast', $toasts);

            return;
        }

        $this->dispatch(
            'toast',
            title: $title,
            description: $description,
            type: $type->value,
            time: $time,
            persistent: $persistent
        );
    }
}
