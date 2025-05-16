<?php

namespace Tests\Infrastructure;

use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class AbstractInfrastructureTestCase extends BaseTestCase
{
    use CreatesApplication;
}
