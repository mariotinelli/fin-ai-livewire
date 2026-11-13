<?php

declare(strict_types = 1);

namespace App\Services\Notifications;

class DatabaseNotification
{
    public ?string $color = null;

    public ?string $icon = null;

    public ?string $title = null;

    public ?string $description = null;

    /** @var array<string, mixed> */
    public array $details = [];

    /** @var array{action?: string, url?: string} */
    public array $actionButton = [];

    public function success(): self
    {
        return $this->color('border-green-600');
    }

    public function error(): self
    {
        return $this->color('border-red-600');
    }

    public function info(): self
    {
        return $this->color('border-sky-800');
    }

    public function warning(): self
    {
        return $this->color('border-yellow-600');
    }

    /**
     * Set the color of the border of the notifications
     *
     * @param string $color Use Tailwind CSS Border Classes
     */
    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /** @param array<string, mixed> $details */
    public function details(array $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function actionButton(string $buttonText, string $route): self
    {
        $this->actionButton = [
            'action' => $buttonText,
            'url'    => $route,
        ];

        return $this;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        $return = [];

        if ($this->color) {
            $return['color'] = $this->color;
        }

        if ($this->icon) {
            $return['icon'] = $this->icon;
        }

        if ($this->title) {
            $return['title'] = $this->title;
        }

        if ($this->description) {
            $return['description'] = $this->description;
        }

        if ($this->details) {
            $return['details'] = $this->details;
        }

        if ($this->actionButton) {
            $return['route'] = $this->actionButton;
        }

        return $return;
    }
}
