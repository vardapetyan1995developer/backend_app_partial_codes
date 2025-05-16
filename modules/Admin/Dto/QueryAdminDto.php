<?php

namespace Modules\Admin\Dto;

final class QueryAdminDto
{
    public function __construct(
        public readonly ?string $queryString,
    ) {
        //
    }
}
