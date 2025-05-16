<?php

namespace Modules\Client\Dto;

final class UpdateClientPasswordDto
{
    public function __construct(
        public readonly string $password,
    ) {
        //
    }
}
