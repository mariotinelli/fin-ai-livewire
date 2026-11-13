@props([
    'footer' => null,
    'cancelRoute' => null,
])

<form novalidate {{ $attributes }}>
    {{ $slot }}

    @if ($footer)
        {{ $footer }}
    @endif
</form>
