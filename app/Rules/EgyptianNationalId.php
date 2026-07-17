<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class EgyptianNationalId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    /**
     * Validates the structural fields (century, birth date) of an Egyptian National ID.
     *
     * The 14-digit checksum (last digit) has no single officially published
     * algorithm — public implementations disagree on the exact weights, so it is
     * deliberately not checked here to avoid rejecting genuine national IDs.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! preg_match('/^\d{14}$/', $value)) {
            $fail('الرقم القومي يجب أن يتكون من 14 رقمًا.');

            return;
        }

        $century = (int) $value[0];

        if (! in_array($century, [2, 3], true)) {
            $fail('الرقم القومي غير صالح.');

            return;
        }

        $year = ($century === 2 ? 1900 : 2000) + (int) substr($value, 1, 2);
        $month = (int) substr($value, 3, 2);
        $day = (int) substr($value, 5, 2);

        if (! checkdate($month, $day, $year) || mktime(0, 0, 0, $month, $day, $year) > time()) {
            $fail('الرقم القومي لا يحتوي على تاريخ ميلاد صحيح.');
        }
    }
}
