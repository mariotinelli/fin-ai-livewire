<?php

declare(strict_types = 1);

use App\Dev\Providers\DevServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\ParameterStoreServiceProvider;
use App\Providers\QueueServiceProvider;
use OwenIt\Auditing\AuditingServiceProvider;

return [
    ParameterStoreServiceProvider::class,
    DevServiceProvider::class,
    AppServiceProvider::class,
    QueueServiceProvider::class,
    AuditingServiceProvider::class,
];
