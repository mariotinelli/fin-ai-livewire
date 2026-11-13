<?php

declare(strict_types = 1);

namespace App\Console\Commands\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\select;

/** @phpstan-require-extends \App\Console\Commands\MakeSearch */
trait SearchQuestionsCommand
{
    /** @var Collection<int, object{name: string, type: string}> */
    public Collection $columns;

    public ?string $model = null;

    public ?string $searchAttribute = null;

    public ?string $optionValue = null;

    public ?string $optionLabel = null;

    protected function getModel(): ?string
    {
        $selectedModel = select('Selecione a model', options: $this->models->all(), default: $this->models->first());

        $model = $this->models->get((int) $selectedModel);

        if ($model === null) {
            throw new \InvalidArgumentException('Model selecionada inválida.');
        }

        $this->columns = $this->getColumns($model);

        return $model;
    }

    protected function getSearchAttribute(): string
    {
        return $this->selectColumn('Selecione campo de busca', 1);
    }

    protected function getOptionValue(): string
    {
        return $this->selectColumn('Selecione o campo de valor (armazena ao selecionar um item no select)', 0);
    }

    protected function getOptionLabel(): ?string
    {
        return $this->selectColumn('Selecione o campo de label (exibido em cada item do select)', 1);
    }

    private function selectColumn(string $label, int $defaultIndex): string
    {
        $options = [];

        foreach ($this->columns as $column) {
            $options[$column->name] = $column->name;
        }

        return (string) select(
            label: $label,
            options: $options,
            default: $this->columns->get($defaultIndex)->name ?? $this->columns->first()?->name,
        );
    }

    protected function formatType(string $type): string
    {
        return match ($type) {
            'tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'int2', 'int4', 'int8'         => 'int',
            'decimal', 'numeric', 'float', 'double', 'real', 'float4', 'float8'                 => 'float',
            'char', 'varchar', 'text', 'tinytext', 'mediumtext', 'longtext', 'bpchar', 'citext' => 'string',
            default                                                                             => 'mixed',
        };
    }

    /** @return Collection<int, object{name: string, type: string}> */
    protected function getColumns(string $model): Collection
    {
        $modelInstance = app('App\\Models\\' . $model);

        if (!$modelInstance instanceof Model) {
            throw new \InvalidArgumentException('Model selecionada inválida.');
        }

        $columns = [];

        foreach (Schema::getColumns($modelInstance->getTable()) as $column) {
            $type = $this->formatType($column['type_name']);

            if (in_array($type, ['int', 'string', 'float'], true)) {
                $columns[] = (object) ['name' => $column['name'], 'type' => $type];
            }
        }

        return collect($columns);
    }
}
