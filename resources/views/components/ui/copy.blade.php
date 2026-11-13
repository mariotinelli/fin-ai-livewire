@props([
    'text',
    'label' => null,
    'copyLabel' => null,
    'successMessage' => 'Copiado com sucesso!',
    'errorMessage' => 'Não foi possível copiar',
    'successToast' => false,
    'alwaysShowIcon' => true,
])

@php
    $ariaLabel = $copyLabel ?? $attributes->get('aria-label') ?? ($label ? "Copiar {$label}" : 'Copiar conteúdo');
@endphp

<button
    type="button"
    {{ $attributes->except('aria-label')->class(['group/copy tooltip inline-flex max-w-full cursor-pointer items-center gap-2 py-2']) }}
    x-data="{
        text: @js($text),
        copied: false,
        feedbackMessage: '',
        feedbackTimer: null,
        destroy() { clearTimeout(this.feedbackTimer) },
        setFeedback(message, copied = false) {
            this.feedbackMessage = message
            this.copied = copied
            clearTimeout(this.feedbackTimer)
            this.feedbackTimer = setTimeout(() => {
                this.feedbackMessage = ''
                this.copied = false
            }, 1000)
        },
        fallbackCopy(text) {
            const textarea = document.createElement('textarea')
            textarea.value = text
            textarea.setAttribute('readonly', '')
            textarea.style.position = 'absolute'
            textarea.style.left = '-9999px'
            document.body.appendChild(textarea)
            textarea.select()

            const focused = this.$el
            try {
                if (!document.execCommand('copy')) throw new Error('copy-failed')
            } finally {
                textarea.remove()
                focused.focus({ preventScroll: true })
            }
        },
        toast(title, type) {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: { title, description: null, type, time: 3, persistent: false }
            }))
        },
        async copy() {
            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(this.text)
                } else {
                    this.fallbackCopy(this.text)
                }

                this.setFeedback(@js($successMessage), true)
                if (@js($successToast)) this.toast(@js($successMessage), 'success')
            } catch {
                this.setFeedback(@js($errorMessage))
                this.toast(@js($errorMessage), 'error')
            }
        }
    }"
    x-bind:class="copied ? 'tooltip-success tooltip-open' : ''"
    @click.stop="copy()"
    x-bind:data-tip="feedbackMessage || @js($ariaLabel)"
    aria-label="{{ $ariaLabel }}"
>
    @isset($prefix)
        <span class="inline-flex shrink-0" aria-hidden="true">{{ $prefix }}</span>
    @endisset

    @if ($label)
        <span class="truncate">{{ $label }}</span>
    @elseif ($slot->isNotEmpty())
        <span class="truncate">{{ $slot }}</span>
    @endif

    <span
        data-copy-default-icon
        x-show="!copied"
        @class([
            'inline-flex shrink-0',
            'md:opacity-0 md:group-hover/copy:opacity-100 md:group-focus-visible/copy:opacity-100' => !$alwaysShowIcon
        ])
        aria-hidden="true"
    >
        @isset($icon)
            {{ $icon }}
        @else
            <x-icons.clipboard class="h-5 w-5" />
        @endisset
    </span>
    <span data-copy-success-icon x-cloak x-show="copied" class="inline-flex shrink-0 text-success" aria-hidden="true">
        <x-icons.check class="h-5 w-5" />
    </span>

    <span class="sr-only" aria-live="polite" role="status" x-text="feedbackMessage"></span>
</button>
