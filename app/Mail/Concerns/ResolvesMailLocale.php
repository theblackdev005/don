<?php

namespace App\Mail\Concerns;

trait ResolvesMailLocale
{
    protected function mailLocale(): string
    {
        return $this->locale ?? config('locales.default', 'fr');
    }

    /**
     * @param  array<string, string|int|float>  $replace
     */
    protected function mailTrans(string $key, array $replace = []): string
    {
        return trans($key, $replace, $this->mailLocale());
    }
}
