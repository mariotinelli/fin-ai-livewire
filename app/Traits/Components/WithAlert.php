<?php

declare(strict_types = 1);

namespace App\Traits\Components;

trait WithAlert
{
    /** Titles, descriptions and button labels are plain text, never HTML.
     * @param array<array-key, mixed>|int|string|null $params */
    protected function alert(
        string $title,
        ?string $description = null,
        string $type = 'alert',
        ?string $method = 'confirm',
        array | int | string | null $params = null,
        string $textConfirm = 'Confirmar',
        ?string $textCancel = 'Cancelar',
        bool $actionConfirm = true,
        ?string $cancelMethod = null,
        ?string $color = null,
        ?string $icon = null,
        ?string $descriptionHighlight = null,
    ): void {
        $this->dispatch(
            'alert',
            description: $description,
            title: $title,
            type: $type,
            method: $method,
            params: $params,
            componentId: $this->getId(),
            actionConfirm: $actionConfirm,
            textConfirm: $textConfirm,
            textCancel: $textCancel,
            actionCancel: $cancelMethod,
            color: $color,
            icon: $icon,
            descriptionHighlight: $descriptionHighlight,
        );
    }

    /** @param array<array-key, mixed>|int|string|null $params */
    protected function confirmAlert(
        string $title,
        ?string $description = null,
        ?string $method = 'confirm',
        array | int | string | null $params = null,
        string $textConfirm = 'Confirmar',
        ?string $textCancel = 'Cancelar',
        bool $actionConfirm = true,
        ?string $cancelMethod = null,
        ?string $color = null,
        ?string $icon = null,
        ?string $descriptionHighlight = null,
    ): void {

        $this->alert(
            $title,
            $description,
            'confirmation',
            $method,
            $params,
            $textConfirm,
            $textCancel,
            $actionConfirm,
            $cancelMethod,
            $color,
            $icon,
            $descriptionHighlight,
        );
    }
}
