<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Enums\ApplicationEnvironments;
use App\Enums\Can;
use App\Http\Middleware\EnsureUserCanAccessAdminArea;
use App\Http\Middleware\EnsureUserCanAccessCustomerArea;
use App\Http\Middleware\EnsureUserCanAccessSupportArea;
use App\Http\Middleware\RestrictByIp;
use App\Mail\BrevoTransport;
use App\Models\User;
use App\Support\QueueNames;
use Carbon\Carbon;
use Carbon\Month;
use Carbon\WeekDay;
use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\DevCommands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

use Illuminate\Validation\Rules\Password;
use Livewire\Livewire;
use Opcodes\LogViewer\Facades\LogViewer;
use Spatie\Browsershot\Browsershot;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configBrowsershot();
    }

    public function boot(): void
    {
        Livewire::addPersistentMiddleware([
            EnsureUserCanAccessAdminArea::class,
            EnsureUserCanAccessCustomerArea::class,
            EnsureUserCanAccessSupportArea::class,
            RestrictByIp::class,
        ]);

        $this->configDatabase();
        $this->configCommands();
        $this->configModels();
        $this->configRules();
        $this->configGates();
        $this->configMorphs();
        $this->configLogViewer();
        $this->configVite();
        $this->configHttp();
        $this->configCarbon();
        $this->configQaEnvBar();
        $this->configBrevo();
        $this->configArtisanDev();
        $this->configMailRateLimit();
        $this->configAuthRateLimits();
    }

    private function configMailRateLimit(): void
    {
        RateLimiter::for('outgoing-mail', fn (): Limit => Limit::perSecond(1)->by(app()->environment()));
    }

    private function configAuthRateLimits(): void
    {
        RateLimiter::for('registration', fn (Request $request): Limit => Limit::perHour(3)->by(app()->environment() . ':ip:' . $request->ip()));
        RateLimiter::for('verification-mail', fn (Request $request): array => [
            Limit::perMinute(1)->by(app()->environment() . ':minute:' . ($request->user()->id ?? $request->ip())),
            Limit::perHour(5)->by(app()->environment() . ':hour:' . ($request->user()->id ?? $request->ip())),
        ]);
    }

    private function configDatabase(): void
    {
        Schema::defaultStringLength(191);
    }

    private function configCommands(): void
    {
        DB::prohibitDestructiveCommands(applicationEnvironment() === ApplicationEnvironments::Production);
    }

    private function configModels(): void
    {
        Model::unguard();

        Model::shouldBeStrict(applicationEnvironment() !== ApplicationEnvironments::Production);
    }

    private function configRules(): void
    {
        Password::defaults(fn () => Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised());
    }

    private function configGates(): void
    {
        foreach (Can::allCases() as $permission) {
            Gate::define($permission, fn (User $user): bool => $user->hasPermissionTo($permission) || $user->isAdmin());
        }
    }

    private function configMorphs(): void
    {
        Relation::morphMap([]);
    }

    private function configLogViewer(): void
    {
        LogViewer::auth(fn (Request $request): bool => $request->user()?->isAdmin() ?? false);
    }

    private function configVite(): void
    {
        Vite::useAggressivePrefetching();
    }

    private function configHttp(): void
    {
        URL::forceHttps(applicationEnvironment() === ApplicationEnvironments::Production);
    }

    private function configCarbon(): void
    {
        Carbon::macro('diffInWholeDays', function (\DateTimeInterface | Month | WeekDay | string | int | float | null $date = null, bool $absolute = true, bool $utc = false): int {
            $date    = Carbon::parse($date);
            $current = $this->copy();

            if ($utc || ($date->timezoneName !== $current->timezoneName)) {
                $date    = $date->utc();
                $current = $current->utc();
            }

            $diff = $current->diffInDays($date, $absolute);

            return (int) round($diff);
        });
    }

    private function configBrowsershot(): void
    {
        $this->app->resolving(Browsershot::class, function (Browsershot $browsershot): void {
            foreach ([
                'chrome_path'      => 'setChromePath',
                'node_binary'      => 'setNodeBinary',
                'node_module_path' => 'setNodeModulePath',
                'bin_path'         => 'setBinPath',
            ] as $key => $method) {
                $path = config()->string("browsershot.{$key}");

                if ($path !== '') {
                    $browsershot->{$method}($path);
                }
            }
        });
    }

    private function configQaEnvBar(): void
    {
        Event::listen(LoginEvent::class, function (): void {
            if (!in_array(applicationEnvironment(), [ApplicationEnvironments::Qa, ApplicationEnvironments::Homolog], true) || session('fake_login')) {
                return;
            }

            Cookie::queue(Cookie::forever('envbar_enabled', '1'));
        });
    }

    private function configBrevo(): void
    {
        Mail::extend('brevo', fn (array $config): BrevoTransport => new BrevoTransport(is_string($key = ($config['api_key'] ?? config('services.brevo.key'))) ? $key : ''));
    }

    private function configArtisanDev(): void
    {
        DevCommands::artisan('schedule:work --whisper', 'schedule')->color('blue');

        $queues = implode(',', QueueNames::all());

        DevCommands::except('server');
        DevCommands::artisan("queue:listen --tries=1 --timeout=0 --queue=$queues", 'queue')->color('red');
    }
}
