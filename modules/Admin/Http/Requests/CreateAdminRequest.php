<?php

namespace Modules\Admin\Http\Requests;

use App\Rules\PasswordRule;
use Modules\Admin\Dto\CreateAdminDto;
use Illuminate\Foundation\Http\FormRequest;

final class CreateAdminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'username' => [
                'nullable',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'confirmed',
                new PasswordRule(),
            ],
        ];
    }

    public function toDto(): CreateAdminDto
    {
        return new CreateAdminDto(
            $this->input('email'),
            $this->input('username'),
            $this->input('password'),
        );
    }
}
