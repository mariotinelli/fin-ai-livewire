<?php

declare(strict_types = 1);

namespace App\Support\Alerts;

use Illuminate\Contracts\Debug\ShouldntReport;
use RuntimeException;

class DiscordAlertDeliveryException extends RuntimeException implements ShouldntReport
{
}
