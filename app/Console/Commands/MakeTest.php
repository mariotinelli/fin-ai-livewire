<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Foundation\Console\TestMakeCommand;

#[Signature('make:test {name : The name of the test} {--f|force : Create the test even if the test already exists} {--u|unit : Create a unit test} {--pest : Create a Pest test} {--phpunit : Create a PHPUnit test}')]
#[Description('Create a new test class')]
class MakeTest extends TestMakeCommand
{
}
