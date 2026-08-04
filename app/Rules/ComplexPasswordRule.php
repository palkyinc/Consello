<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ComplexPasswordRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $fail = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $value);
        //dd('app\Rules\ComplexPasswordRule.php');
    }
    public function passes($attribute, $value)
    {
        // Add your custom password validation logic here
        // Example: Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character
        
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
         return 'EL :attribute debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número, y un caracter especial.';
         return 'The :attribute must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
    }
}
