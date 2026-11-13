<?php

declare(strict_types = 1);

namespace App\Console\Commands\Traits;

/** @phpstan-require-extends \App\Console\Commands\MakeSearch */
trait SearchControllerCommand
{
    protected function makeSearchController(): void
    {
        $path = $this->getSearchControllerPath();

        $this->makeDirectory($this->getSearchControllerDirectory($path));

        $contents = $this->getSearchControllerSourceFile();

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->error("File : {$path} already exits");
        }
    }

    protected function getSearchControllerStub(): string
    {
        return __DIR__ . '/../../../../stubs/search-controller.stub';
    }

    protected function getSearchControllerPath(): string
    {
        return app_path('Http/Controllers/Search/' . $this->getPluralModel((string) $this->model)->ucfirst()->toString() . 'Controller.php');
    }

    protected function getSearchControllerSourceFile(): string
    {
        return $this->getStubContents($this->getSearchControllerStub(), $this->getSearchControllerStubVariables());
    }

    protected function getSearchControllerDirectory(string $path): string
    {
        $lastForwardSlash  = strrpos($path, '/');
        $lastBackwardSlash = strrpos($path, '\\');
        $lastSeparator     = max($lastForwardSlash === false ? -1 : $lastForwardSlash, $lastBackwardSlash === false ? -1 : $lastBackwardSlash);

        return $lastSeparator === -1 ? '.' : substr($path, 0, $lastSeparator);
    }

    /** @return array<string, string> */
    protected function getSearchControllerStubVariables(): array
    {
        return [
            'model'           => (string) $this->model,
            'pluralModel'     => $this->getPluralModel((string) $this->model)->ucfirst()->toString(),
            'searchAttribute' => (string) $this->searchAttribute,
        ];
    }
}
