<?php

declare(strict_types = 1);

namespace App\View\Components\Ui\Input;

use App\Enums\DatepickerMode;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Datepicker extends Component
{
    public function __construct(
        private readonly bool $range = false,
        private readonly bool $multiple = false,
        private readonly int $showMonths = 1,
        private readonly bool $time24hr = true,
        private readonly ?string $minDate = null,
        private readonly ?string $maxDate = null,
        private readonly ?string $minTime = null,
        private readonly ?string $maxTime = null,
        private readonly bool $date = false,
        private readonly bool $time = false,
        private readonly bool $datetime = false,
        private readonly bool $allowInput = true,
    ) {
        //
    }

    /** @return array<string, mixed> */
    public function getConfig(): array
    {
        return [
            'locale'     => 'pt',
            'mode'       => $this->getMode(),
            'showMonths' => $this->isRange() ? 2 : $this->showMonths,
            'dateFormat' => $this->getFormat(),
            'minDate'    => $this->minDate,
            'maxDate'    => $this->maxDate,
            'minTime'    => $this->minTime,
            'maxTime'    => $this->maxTime,
            'time_24hr'  => $this->time24hr,
            'enableTime' => $this->time || $this->datetime,
            'noCalendar' => $this->time,
            'allowInput' => $this->allowInput && !$this->isRange(),
        ];
    }

    protected function getMode(): string
    {
        return match (true) {
            $this->range    => 'range',
            $this->multiple => 'multiple',
            default         => 'single',
        };
    }

    public function getFormat(): ?string
    {
        return match (true) {
            $this->datetime => 'd/m/Y H:i',
            $this->date     => 'd/m/Y',
            $this->time     => 'H:i',
            default         => null,
        };
    }

    public function mask(): ?string
    {
        return match (true) {
            $this->time     => '99:99',
            $this->date     => '99/99/9999',
            $this->datetime => '99/99/9999 99:99',
            default         => null,
        };
    }

    public function isRange(): bool
    {
        return $this->getMode() === DatepickerMode::Range->value;
    }

    public function render(): View | Closure | string
    {
        return view('components.ui.input.datepicker');
    }
}
