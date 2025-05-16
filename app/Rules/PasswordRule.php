<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class PasswordRule implements Rule
{
    public const PATTERN = '/^(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/';

    public function passes($attribute, $value)
    {
        return is_string($value) && preg_match(self::PATTERN, $value);
    }

    public function message()
    {
        return trans('validation.password');
    }
}
