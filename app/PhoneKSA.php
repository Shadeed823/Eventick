<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneKSA implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^05\d{8}$/', $value); // Saudi format: starts with 05 and has 10 digits
    }

    public function message()
    {
        return 'Invalid phone number. It must start with 05 and contain 10 digits.';
    }
}
