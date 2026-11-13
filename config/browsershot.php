<?php

declare(strict_types = 1);

return [
    'chrome_path'      => env('BROWSERSHOT_CHROME_PATH') ?: '',
    'node_binary'      => env('BROWSERSHOT_NODE_BINARY') ?: '',
    'node_module_path' => env('BROWSERSHOT_NODE_MODULE_PATH') ?: base_path('node_modules'),
    'bin_path'         => env('BROWSERSHOT_BIN_PATH') ?: '',
];
