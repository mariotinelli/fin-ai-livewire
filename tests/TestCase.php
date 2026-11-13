<?php

declare(strict_types = 1);

namespace Tests;

use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\Attributes\Seeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;

#[Seeder(PermissionSeeder::class)]
abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
        Process::fake([]);
        Process::preventStrayProcesses();
    }
}
