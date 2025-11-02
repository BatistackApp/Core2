<?php

namespace App\Rules;

use App\Services\VatValidator;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VatIntraCommunity implements ValidationRule
{
    protected VatValidator $validator;

    public function __construct(VatValidator $validator)
    {
        $this->validator = $validator;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || !$this->validator->isValid($value)) {
            $fail("Le numéro de TVA intracommunautaire fourni n'est pas valide ou actif.");
        }
    }
}
