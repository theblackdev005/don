<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundingRequestFinancialChange extends Model
{
    public const FIELD_AMOUNT_REQUESTED = 'amount_requested';

    public const FIELD_ADMINISTRATIVE_FEES = 'administrative_fees';

    public const ACTION_SET = 'set';

    public const ACTION_INCREASE = 'increase';

    protected $fillable = [
        'funding_request_id',
        'admin_id',
        'field',
        'action',
        'old_amount',
        'new_amount',
        'delta_amount',
        'note',
    ];

    protected $casts = [
        'old_amount' => 'decimal:2',
        'new_amount' => 'decimal:2',
        'delta_amount' => 'decimal:2',
    ];

    public static function fieldLabels(): array
    {
        return [
            self::FIELD_AMOUNT_REQUESTED => 'Montant du dossier',
            self::FIELD_ADMINISTRATIVE_FEES => 'Frais de dossier',
        ];
    }

    public function fieldLabel(): string
    {
        return self::fieldLabels()[$this->field] ?? $this->field;
    }

    public function fundingRequest(): BelongsTo
    {
        return $this->belongsTo(FundingRequest::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
