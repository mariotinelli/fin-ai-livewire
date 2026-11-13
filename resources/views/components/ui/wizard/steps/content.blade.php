@props(['id', 'active' => false,])

<div class="bg-base-100 px-6 pt-4 pb-6" data-wizard-step="{{ $id }}" x-show="currentStep === @js($id)">{{ $slot }}</div>
