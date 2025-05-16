<?php

namespace Modules\Admin\Dto;

final class UpdateAdminDto
{
    public function __construct(
        public readonly ?string $username,
    ) {
        //
    }
}
