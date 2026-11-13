<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use App\Console\Commands\Traits\SearchControllerCommand;
use App\Console\Commands\Traits\SearchQuestionsCommand;
use App\Console\Commands\Traits\SearchResourceCommand;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Stringable;
use SplFileInfo;

#[Signature('make:search')]
#[Description('Create a search controller and search resource necessary to search for a model in input select fields.')]
class MakeSearch extends Command
{
    use SearchResourceCommand;
    use SearchQuestionsCommand;
    use SearchControllerCommand;

    /** @var Collection<int, string> */
    public Collection $models;

    public function __construct(
        private readonly Filesystem $filesystem
    ) {
        parent::__construct();

        $this->models = collect(File::allFiles(app_path('Models')))
            ->map(fn (SplFileInfo $file): string => str($file->getFilename())->replace('.php', '')->toString())
            ->filter(fn (string $model): bool => $model !== 'BaseModel');
    }

    public function handle(): void
    {
        $this->model           = $this->getModel();
        $this->searchAttribute = $this->getSearchAttribute();
        $this->optionValue     = $this->getOptionValue();
        $this->optionLabel     = $this->getOptionLabel();

        $this->makeSearchResource();
        $this->makeSearchController();

        $this->newLine();

        $this->info("Agora vá para 'search.php' e crie a rota para o novo controller");
    }

    protected function makeDirectory(string $path): string
    {
        if (!$this->filesystem->isDirectory($path)) {
            $this->filesystem->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    protected function getPluralModel(string $model): Stringable
    {
        return str(Pluralizer::plural($model));
    }

    /**
     * @param array<string, string> $stubVariables
     */
    protected function getStubContents(string $stub, array $stubVariables = []): string
    {
        $contents = $this->filesystem->get($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('{{ ' . $search . ' }}', $replace, $contents);
        }

        return $contents;
    }
}
