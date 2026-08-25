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
        // Expresión regular que valida minúsculas, mayúsculas, números y caracteres especiales (mínimo 8 caracteres)
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$!%*?&])[A-Za-z\d$!%*?&]{8,}$/';

        if (!preg_match($pattern, $value)) {
            $fail('El campo :attribute debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un caracter especial.');
        }
    }
}
