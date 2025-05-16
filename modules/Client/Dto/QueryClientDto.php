<?php

namespace Modules\Client\Dto;

final class QueryClientDto
{
    public function __construct(
        public readonly ?string $queryString,
    ) {
        //
    }
}
