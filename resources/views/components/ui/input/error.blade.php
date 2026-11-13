@props(['message', 'id' => null,])

<small @if ($id) id="{{ $id }}" @endif role="alert" class="label-alt label -mt-1.5 text-wrap text-error">{{ $message }}</small>
