<?php

declare(strict_types = 1);

namespace App\Console\Commands\Traits;

/** @phpstan-require-extends \App\Console\Commands\MakeSearch */
trait SearchResourceCommand
{
    protected function makeSearchResource(): void
    {
        $path = $this->getSearchResourcePath();

        $this->makeDirectory($this->getSearchResourceDirectory($path));

        $contents = $this->getSearchResourceSourceFile();

        $this->newLine();

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->error("File : {$path} already exits");
        }
    }

    protected function getSearchResourceStub(): string
    {
        return __DIR__ . '/../../../../stubs/search-resource.stub';
    }

    protected function getSearchResourcePath(): string
    {
        return app_path('Http/Resources/Search/' . $this->model . 'Resource.php');
    }

    protected function getSearchResourceSourceFile(): string
    {
        return $this->getStubContents($this->getSearchResourceStub(), $this->getSearchResourceStubVariables());
    }

    protected function getSearchResourceDirectory(string $path): string
    {
        $lastForwardSlash  = strrpos($path, '/');
        $lastBackwardSlash = strrpos($path, '\\');
        $lastSeparator     = max($lastForwardSlash === false ? -1 : $lastForwardSlash, $lastBackwardSlash === false ? -1 : $lastBackwardSlash);

        return $lastSeparator === -1 ? '.' : substr($path, 0, $lastSeparator);
    }

    /** @return array<string, string> */
    protected function getSearchResourceStubVariables(): array
    {
        return [
            'model'           => (string) $this->model,
            'optionValue'     => (string) $this->optionValue,
            'optionLabel'     => (string) $this->optionLabel,
            'optionValueType' => (string) $this->columns->firstWhere('name', $this->optionValue)?->type,
            'optionLabelType' => (string) $this->columns->firstWhere('name', $this->optionLabel)?->type,
        ];
    }
}
