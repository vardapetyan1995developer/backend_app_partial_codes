<?php

namespace Modules\Admin\Dto;

final class UpdateAdminPasswordDto
{
    public function __construct(
        public readonly ?string $password,
    ) {
        //
    }
}
