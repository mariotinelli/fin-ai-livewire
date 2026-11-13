@props(['header', 'content', 'steps', 'submit' => 'save',])

<div
    x-data="{
        currentStep: $wire.entangle('currentStep'),
        firstStep: $wire.entangle('firstStep'),
        lastStep: $wire.entangle('lastStep'),
        steps: @js($steps),
        goToStep(stepId) {
            this.currentStep = stepId;

            if (this.$wire) {
                this.$wire.set('currentStep', stepId);
            }
        },
        currentStepPosition() {
            const index = this.steps.findIndex((step) => step.id === this.currentStep);

            return index >= 0 ? index + 1 : 1;
        },
        progressAnnouncement() {
            return `Passo ${this.currentStepPosition()} de ${this.steps.length}`;
        },
        focusFirstFieldInCurrentStep() {
            const stepContainer = this.$el.querySelector(`[data-wizard-step='${this.currentStep}']`);

            if (! stepContainer) {
                return false;
            }

            const focusableElements = [...stepContainer.querySelectorAll(`input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), a[href], [tabindex]:not([tabindex='-1'])`)]
                .filter((element) => element.offsetParent !== null);

            if (focusableElements.length === 0) {
                return false;
            }

            focusableElements[0].focus();

            return true;
        },
        handleStepTab(event, stepId) {
            if (event.shiftKey || this.currentStep !== this.firstStep || stepId !== this.firstStep) {
                return;
            }

            const focused = this.focusFirstFieldInCurrentStep();

            if (focused) {
                event.preventDefault();
            }
        },
        focusRelativeStep(index, direction) {
            const targetIndex = index + direction;

            if (targetIndex < 0 || targetIndex >= this.steps.length) {
                return;
            }

            this.$el.querySelector(`[data-step-index='${targetIndex}']`)?.focus();
        },
    }"
    class="mx-auto w-full"
    role="group"
    aria-label="Progresso do formulário"
>
    <div class="divide-y divide-base-300 rounded-lg border border-base-300">
        <div class="rounded-t-lg bg-base-100 p-4">
            <ol class="flex items-center justify-between" role="list">
                <template x-for="(step, index) in steps" :key="step.id">
                    <li class="flex w-full items-center" :aria-current="currentStep === step.id ? 'step' : null">
                        <button
                            data-ui-loading-control
                            type="button"
                            class="flex items-center border-0 bg-transparent p-0 text-left"
                            :data-step-index="index"
                            :aria-label="`Ir para ${step.label}`"
                            @click="goToStep(step.id)"
                            @keydown.enter.prevent="goToStep(step.id)"
                            @keydown.space.prevent="goToStep(step.id)"
                            @keydown.right.prevent="focusRelativeStep(index, 1)"
                            @keydown.left.prevent="focusRelativeStep(index, -1)"
                            @keydown.tab="handleStepTab($event, step.id)"
                        >
                            <div
                                class="flex h-8 w-8 items-center justify-center rounded-full border-2 text-sm font-semibold"
                                :class="{
                                    'border-primary text-primary': currentStep !== step.id,
                                    'bg-primary text-primary-content border-primary': currentStep === step.id,
                                }"
                            >
                                <span x-text="(index + 1).toString().padStart(2, '0')"></span>
                            </div>

                            <div
                                class="text-md ml-2 font-medium"
                                :class="{
                                    'text-primary': currentStep === step.id,
                                    'text-base-content/65': currentStep !== step.id,
                                }"
                                x-text="step.label"
                            ></div>
                            <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
                        </button>

                        <template x-if="index < steps.length - 1">
                            <div class="flex flex-1 items-center justify-center">
                                <x-icons.chevron-right class="size-8 text-base-content/30" />
                            </div>
                        </template>
                    </li>
                </template>
            </ol>

            <div class="sr-only" aria-live="polite" x-text="progressAnnouncement()"></div>
        </div>

        <div class="rounded-b-lg">{{ $content }}</div>
    </div>

    <div class="mt-6 flex items-center justify-between">
        <x-ui.button id="previous-step" sm white outline wire:click="prevStep" x-bind:disabled="currentStep === firstStep">
            Anterior
        </x-ui.button>

        <x-ui.button id="next-step" sm primary outline wire:click="nextStep" x-show="currentStep !== lastStep"> Próximo </x-ui.button>

        <x-ui.button id="submit-form" sm primary outline wire:click="{{ $submit }}" x-show="currentStep === lastStep"> Salvar </x-ui.button>
    </div>
</div>
