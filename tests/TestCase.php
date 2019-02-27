<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param $array
     * @return array
     */
    protected function arraySnakeCase($array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $result[snake_case($key)] = $value;
        }

        return $result;
    }
}
