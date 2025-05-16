<?php

namespace Tests\Modules;

use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class AbstractModuleTestCase extends BaseTestCase
{
    use CreatesApplication;
}
