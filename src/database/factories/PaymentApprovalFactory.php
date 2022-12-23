<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Sponsor;
use App\Models\TravelPayment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentApproval>
 */
class PaymentApprovalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'payment_type' => fake()->randomElement([TravelPayment::class, Payment::class]),
            'status' => fake()->randomElement(['APPROVED', 'DISAPPROVED'])
        ];
    }

    /**
     * @return PaymentApprovalFactory
     */
    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'APPROVED',
            ];
        });
    }

    /**
     * @return PaymentApprovalFactory
     */
    public function disapproved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'DISAPPROVED',
            ];
        });
    }

}
