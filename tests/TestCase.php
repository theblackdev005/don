<?php

namespace Tests;

use App\Support\LocalizedRouteSlugs;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $locale = (string) config('locales.default', 'fr');

        App::setLocale($locale);
        URL::defaults(array_merge(
            ['locale' => $locale],
            LocalizedRouteSlugs::defaultsForLocale($locale)
        ));
    }
}
