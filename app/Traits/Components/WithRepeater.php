<?php

declare(strict_types = 1);

namespace App\Traits\Components;

trait WithRepeater
{
    use WithAlert;

    /** @var array<string, list<string>> */
    public array $repeaterFields = [];

    public function addItem(string $model): void
    {
        $items   = $this->repeaterItems($model, true);
        $field   = str($model)->afterLast('.')->toString();
        $items[] = array_fill_keys($this->getRepeaterFields($field), null);
        $this->putRepeaterItems($model, $items);
    }

    public function duplicateItem(string $model): void
    {
        $segments = explode('.', $model);
        $index    = array_pop($segments);
        $path     = implode('.', $segments);
        $items    = $this->repeaterItems($path);

        if (!array_key_exists($index, $items)) {
            throw new \InvalidArgumentException('Item do repeater não encontrado.');
        }

        $copy = $items[$index];
        unset($copy['id']);
        $items[] = $copy;
        $this->putRepeaterItems($path, $items);
    }

    public function removeItem(string $model): void
    {
        $this->confirmAlert(
            'Tem certeza que deseja remover este item?',
            'O item será removido definitivamente a partir do momento que você salvar o formulário.',
            'confirmRemoveItem',
            $model
        );
    }

    public function confirmRemoveItem(string $model): void
    {
        $segments = explode('.', $model);
        $index    = array_pop($segments);
        $path     = implode('.', $segments);
        $items    = $this->repeaterItems($path);
        unset($items[$index]);
        $this->putRepeaterItems($path, array_values($items));
    }

    /** @return list<string> */
    public function getRepeaterFields(string $model): array
    {
        return $this->repeaterFields[$model];
    }

    /** @param list<string> $fields */
    public function setRepeaterFields(string $model, array $fields): void
    {
        $this->repeaterFields[$model] = $fields;
    }

    /** @return array<array-key, array<array-key, mixed>> */
    private function repeaterItems(string $path, bool $allowMissing = false): array
    {
        $value = data_get($this, $path, $allowMissing ? [] : null);

        if ($allowMissing && $value === null) {
            $value = [];
        }

        if (!is_array($value)) {
            throw new \InvalidArgumentException('Coleção do repeater inválida.');
        }

        $items = [];

        foreach ($value as $key => $item) {
            if (!is_array($item)) {
                throw new \InvalidArgumentException('Item do repeater inválido.');
            }

            $items[$key] = $item;
        }

        return $items;
    }

    /** @param array<array-key, array<array-key, mixed>> $items */
    private function putRepeaterItems(string $path, array $items): void
    {
        $component = $this;
        data_set($component, $path, $items);
    }
}
