<?php

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Dto\QueryAdminDto;
use Illuminate\Foundation\Http\FormRequest;

final class QueryAdminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => [
                'string',
                'max:255',
            ],
        ];
    }

    public function toDto(): QueryAdminDto
    {
        return new QueryAdminDto(
            $this->query('q'),
        );
    }
}
