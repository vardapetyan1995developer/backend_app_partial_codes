<?php

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Dto\UpdateAdminDto;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateAdminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function toDto(): UpdateAdminDto
    {
        return new UpdateAdminDto(
            $this->input('username'),
        );
    }
}
