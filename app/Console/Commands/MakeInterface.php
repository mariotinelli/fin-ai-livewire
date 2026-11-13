<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Foundation\Console\InterfaceMakeCommand;

#[Signature('make:interface {name : The name of the interface} {--f|force : Create the interface even if the interface already exists}')]
#[Description('Create a new interface')]
class MakeInterface extends InterfaceMakeCommand
{
    protected function getStub(): string
    {
        return base_path('stubs/interface.stub');
    }
}
