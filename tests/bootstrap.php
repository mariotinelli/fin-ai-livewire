<?php

declare(strict_types = 1);
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$project = dirname(__DIR__);

if (is_file($project . '/.git')) {
    if (!is_file($project . '/.env') || !is_file($project . '/.env.testing')) {
        throw new RuntimeException('Prepare .env e .env.testing da worktree antes de executar testes.');
    }

    $application         = Dotenv::parse(file_get_contents($project . '/.env') ?: '');
    $testing             = Dotenv::parse(file_get_contents($project . '/.env.testing') ?: '');
    $applicationDatabase = $application['DB_DATABASE'] ?? null;
    $testingDatabase     = $testing['DB_DATABASE'] ?? null;

    if (!is_string($applicationDatabase) || !preg_match('/\A[A-Za-z0-9_]{1,47}\z/', $applicationDatabase)
        || $testingDatabase !== $applicationDatabase . '_testing') {
        throw new RuntimeException('Configure o banco exclusivo da worktree em .env.testing antes de executar testes.');
    }

    $_ENV['DB_DATABASE'] = $testingDatabase;
    putenv('DB_DATABASE=' . $testingDatabase);
}

/** PHPUnit forces $_ENV and putenv, but Laravel reads inherited $_SERVER values first. */
foreach (['APP_ENV', 'BCRYPT_ROUNDS', 'HASH_DRIVER', 'CACHE_STORE', 'BROADCAST_CONNECTION', 'DB_CONNECTION', 'DB_DATABASE', 'DB_URL', 'MAIL_MAILER', 'QUEUE_CONNECTION', 'QUEUE_PREFIX', 'SESSION_DRIVER'] as $name) {
    if (isset($_ENV[$name])) {
        $_SERVER[$name] = $_ENV[$name];
    }
}
