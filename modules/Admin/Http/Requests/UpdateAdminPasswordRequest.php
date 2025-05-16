<?php

namespace Modules\Admin\Http\Requests;

use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Admin\Dto\UpdateAdminPasswordDto;

final class UpdateAdminPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'confirmed',
                new PasswordRule(),
            ],
        ];
    }

    public function toDto(): UpdateAdminPasswordDto
    {
        return new UpdateAdminPasswordDto(
            $this->input('password'),
        );
    }
}
