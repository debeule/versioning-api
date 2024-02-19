<?php

namespace App\Testing;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param object $class
     * @return mixed
     */
    public function handle(object $class): mixed
    {
        return $this->app->call([$class, 'handle']);
    }

    // /**
    //  * @param object $class
    //  * @return mixed
    //  */
    // public function dispatch(object $class): mixed
    // {
    //     return $this->app->call([$class, '__invoke']);
    // }
}
