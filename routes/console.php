<?php

declare(strict_types = 1);

use App\Console\Commands\MaintainEmailNotifications;
use Illuminate\Support\Facades\Schedule;

Schedule::command(MaintainEmailNotifications::class)->everyFiveMinutes()->withoutOverlapping(60);
