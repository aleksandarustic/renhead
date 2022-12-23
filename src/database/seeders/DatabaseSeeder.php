<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\PaymentApproval;
use App\Models\TravelPayment;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $approvers = User::factory()->approver()->createMany(
            [
                ['email' => 'approver_1@gmail.com'],
                ['email' => 'approver_2@gmail.com'],
                ['email' => 'approver_3@gmail.com'],
            ]
        );

        $nonApprovers = User::factory()->nonApprover()->createMany(
            [
                ['email' => 'non_approver_1@gmail.com'],
                ['email' => 'non_approver_2@gmail.com'],
                ['email' => 'non_approver_3@gmail.com'],
            ]
        );

        $nonApprovers->each(function ($nonApprover) use ($approvers) {

            $payments = Payment::factory(100)->create(['user_id' => $nonApprover->id]);
            $travelPayments = TravelPayment::factory(100)->create(['user_id' => $nonApprover->id]);

            $approvers->each(function ($approver) use ($payments, $travelPayments) {

                $payments->slice(0, random_int(20, 30))->each(function ($payment) use ($approver) {
                    PaymentApproval::factory()->create([
                        'payment_id' => $payment->id,
                        'payment_type' => Payment::class,
                        'user_id' => $approver->id,
                        'status' => 'APPROVED'
                    ]);
                });

                $travelPayments->slice(0, random_int(20, 30))->each(function ($travelPayment) use ($approver) {
                    PaymentApproval::factory()->create([
                        'payment_id' => $travelPayment->id,
                        'payment_type' => TravelPayment::class,
                        'user_id' => $approver->id,
                        'status' => 'APPROVED'
                    ]);
                });


                $payments->slice(30, random_int(5, 10))->each(function ($payment) use ($approver) {
                    PaymentApproval::factory()->create([
                        'payment_id' => $payment->id,
                        'payment_type' => Payment::class,
                        'user_id' => $approver->id,
                    ]);
                });

                $travelPayments->slice(30, random_int(5, 10))->each(function ($travelPayment) use ($approver) {
                    PaymentApproval::factory()->create([
                        'payment_id' => $travelPayment->id,
                        'payment_type' => TravelPayment::class,
                        'user_id' => $approver->id,
                    ]);
                });

            });

        });

    }
}
