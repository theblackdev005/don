<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Mail;

class EnvironmentSettingsService
{
    public function __construct(
        private readonly Filesystem $files,
    ) {
    }

    public function persist(array $envUpdates, array $runtimeConfig = []): void
    {
        $this->writeEnvValues($envUpdates);

        $this->clearRuntimeCaches();

        if ($runtimeConfig !== []) {
            config($runtimeConfig);
        }

        if (app()->bound('mail.manager')) {
            Mail::forgetMailers();
        }
    }

    private function writeEnvValues(array $updates): void
    {
        $envPath = base_path('.env');
        $contents = file_exists($envPath) ? (string) file_get_contents($envPath) : '';

        foreach ($updates as $key => $value) {
            $escaped = $this->escapeEnvValue((string) $value);
            $pattern = "/^".preg_quote($key, '/')."=.*/m";

            if (preg_match($pattern, $contents)) {
                $contents = (string) preg_replace($pattern, $key.'='.$escaped, $contents);
                continue;
            }

            $contents .= rtrim($contents) === '' ? '' : PHP_EOL;
            $contents .= $key.'='.$escaped;
        }

        file_put_contents($envPath, $contents.PHP_EOL);
    }

    private function clearRuntimeCaches(): void
    {
        foreach ([
            base_path('bootstrap/cache/config.php'),
            base_path('bootstrap/cache/routes-v7.php'),
            base_path('bootstrap/cache/routes.php'),
            base_path('bootstrap/cache/events.php'),
            base_path('bootstrap/cache/compiled.php'),
        ] as $path) {
            if ($this->files->exists($path)) {
                $this->files->delete($path);
            }
        }

        if (function_exists('opcache_reset')) {
            @opcache_reset();
        }
    }

    private function escapeEnvValue(string $value): string
    {
        if ($value === '') {
            return '""';
        }

        $needsQuotes = preg_match('/\s|"|#|=/', $value) === 1;
        $escaped = str_replace('"', '\"', $value);

        return $needsQuotes ? '"'.$escaped.'"' : $escaped;
    }
}
