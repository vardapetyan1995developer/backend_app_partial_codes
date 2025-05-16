<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

final class OldPasswordRule implements Rule
{
    public function __construct(
        private ?User $user,
    ) {
        //
    }

    public function passes($attribute, $value)
    {
        if (!$this->user) {
            return false;
        }

        if (is_null($value)) {
            return is_null($this->user->password);
        }

        if (!is_string($value)) {
            return false;
        }

        return Hash::check($value, $this->user->password);
    }

    public function message()
    {
        return trans('validation.old_password');
    }
}
