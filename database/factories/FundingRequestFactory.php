<?php

namespace Database\Factories;

use App\Models\FundingRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FundingRequest>
 */
class FundingRequestFactory extends Factory
{
    protected $model = FundingRequest::class;

    public function definition(): array
    {
        return [
            'dossier_number' => 'ARD-2026-'.strtoupper(Str::random(6)),
            'public_slug' => strtolower(Str::random(12)),
            'locale' => 'fr',
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('6########'),
            'phone_prefix' => '+33',
            'country' => 'France',
            'address' => fake()->address(),
            'current_situation' => FundingRequest::CURRENT_SITUATION_SALARIED,
            'monthly_income_approx' => '1800 EUR',
            'family_situation' => FundingRequest::FAMILY_SINGLE,
            'situation' => fake()->paragraph(),
            'need_type' => FundingRequest::NEED_PERSONAL,
            'amount_requested' => 50000,
            'administrative_fees' => FundingRequest::ADMINISTRATIVE_FEES,
            'declare_accurate' => true,
            'status' => FundingRequest::STATUS_PENDING,
            'identity_document_type' => FundingRequest::IDENTITY_DOCUMENT_ID_CARD,
        ];
    }
}
