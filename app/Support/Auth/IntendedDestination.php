<?php

declare(strict_types = 1);

namespace App\Support\Auth;

use App\Enums\TypeUsers;

class IntendedDestination
{
    /** @param array<string, int|string> $fallbackQuery */
    public function pull(TypeUsers $type, array $fallbackQuery = []): string
    {
        $intended = session()->pull('url.intended');

        if (is_string($intended) && $this->belongsToArea($intended, $type)) {
            return $intended;
        }

        return route($type->initialRouteName(), $fallbackQuery);
    }

    private function belongsToArea(string $url, TypeUsers $type): bool
    {
        $expected = parse_url(route($type->loginRouteName()));
        $actual   = parse_url($url);

        if (!is_array($actual) || !is_array($expected) || isset($actual['user']) || isset($actual['pass'])) {
            return false;
        }

        foreach (['scheme', 'host', 'port'] as $part) {
            if (($actual[$part] ?? null) !== ($expected[$part] ?? null)) {
                return false;
            }
        }

        $path   = rawurldecode($actual['path'] ?? '');
        $prefix = substr($expected['path'] ?? '', 0, -strlen('/login'));

        if ($prefix === '' || preg_match('/[\\\\\x00-\x20%]|(?:^|\/)\.{1,2}(?:\/|$)/', $path) === 1) {
            return false;
        }

        return $path === $prefix || str_starts_with($path, $prefix . '/');
    }
}
