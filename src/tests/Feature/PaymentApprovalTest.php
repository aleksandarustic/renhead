<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\PaymentApproval;
use App\Models\TravelPayment;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class PaymentApprovalTest
 * @package Tests\Feature
 */
class PaymentApprovalTest extends TestCase
{
    /**
     *
     */
    public function testApprovePayment()
    {
        $user = User::where('type', 'APPROVER')->first();

        Sanctum::actingAs($user, ['APPROVER']);

        $payment = Payment::first();

        $response = $this->post("/api/payments/{$payment->id}/approval", ['status' => 'APPROVED']);

        $response->assertOk();

        $response->assertJsonFragment([
            'payment_id' => $payment->id,
            'user_id' => $user->id,
            'status' => 'APPROVED'
        ]);

        $response = $this->post("/api/payments/{$payment->id}/approval", ['status' => 'DISAPPROVED']);

        $response->assertOk();

        $response->assertJsonFragment([
            'payment_id' => $payment->id,
            'user_id' => $user->id,
            'status' => 'DISAPPROVED'
        ]);

        $numberOfApprovals = PaymentApproval::where(['payment_id' => $payment->id, 'user_id' => $user->id, 'payment_type' => Payment::class])->count();

        $this->assertEquals(1, $numberOfApprovals);
    }


    /**
     *
     */
    public function testApproveTravelPayment()
    {
        $user = User::where('type', 'APPROVER')->first();

        Sanctum::actingAs($user, ['APPROVER']);

        $payment = TravelPayment::first();

        $response = $this->post("/api/travel-payments/{$payment->id}/approval", ['status' => 'DISAPPROVED']);

        $response->assertOk();

        $response->assertJsonFragment([
            'payment_id' => $payment->id,
            'user_id' => $user->id,
            'status' => 'DISAPPROVED'
        ]);

        $response = $this->post("/api/travel-payments/{$payment->id}/approval", ['status' => 'APPROVED']);

        $response->assertOk();

        $response->assertJsonFragment([
            'payment_id' => $payment->id,
            'user_id' => $user->id,
            'status' => 'APPROVED'
        ]);

        $numberOfApprovals = PaymentApproval::where(['payment_id' => $payment->id, 'user_id' => $user->id, 'payment_type' => Payment::class])->count();

        $this->assertEquals(1, $numberOfApprovals);

    }


    /**
     *
     */
    public function testAccessForNonApprover()
    {
        $user = User::where('type', 'NON_APPROVER')->first();

        Sanctum::actingAs($user, ['NON_APPROVER']);

        $payment = $user->payments()->first();
        $travelPayment = $user->travelPayments()->first();

        $response = $this->post("/api/payments/{$payment->id}/approval", ['status' => 'APPROVED']);

        $response->assertStatus(403);

        $response = $this->post("/api/travel-payments/{$travelPayment->id}/approval", ['status' => 'APPROVED']);

        $response->assertStatus(403);
    }




}
