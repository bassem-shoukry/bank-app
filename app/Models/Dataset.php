<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Rules\EgyptianNationalId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\Rule;

/**
 * @method static create(array $array)
 */
class Dataset extends Model
{
    use HasFactory;

    /**
     * Arabic/Latin letters, spaces, and name punctuation only — no digits.
     */
    public const NAME_REGEX = '/^[\p{Arabic}a-zA-Z\s.\'-]+$/u';

    /**
     * Egyptian court case numbers vary by court (e.g. "1234/2026", "1234 لسنة 2026 مدني كلي").
     */
    public const CASE_NUMBER_REGEX = '/^[\p{Arabic}a-zA-Z0-9\s\/-]+$/u';

    protected $fillable = [
        'name',
        'national_id',
        'address',
        'case_number',
        'case_type_id',
        'verdict',
        'payment_status',
        'user_id',
    ];

    /**
     * Shared validation rules for the public form and the Filament resource.
     *
     * @return array<string, array<int, mixed>>
     */
    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:'.self::NAME_REGEX],
            'national_id' => ['required', new EgyptianNationalId],
            'address' => ['required', 'string', 'max:1000'],
            'case_number' => ['required', 'string', 'max:100', 'regex:'.self::CASE_NUMBER_REGEX],
            'case_type_id' => ['required', 'integer', 'exists:case_types,id'],
            'verdict' => ['required', 'string', 'max:5000'],
            'payment_status' => ['required', Rule::enum(PaymentStatus::class)],
        ];
    }

    protected function casts(): array
    {
        return [
            'payment_status' => PaymentStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function caseType(): BelongsTo
    {
        return $this->belongsTo(CaseType::class);
    }
}
