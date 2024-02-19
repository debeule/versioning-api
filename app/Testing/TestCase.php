<?php

namespace App\Testing;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Bus\DispatchesJobs;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, dispatchesJobs, RefreshDatabase;

    /**
     * @param object $class
     */
    protected function handle(object $class)
    {
        return $this->app->call([$class, 'handle']);
    }

    /**
     * @param object $class
     */
    protected function dispatch(object $class)
    {
        return $this->app->call([$class, '__invoke']);
    }

    public function setUp(): void
    {
        parent::setUp();
    }
}
