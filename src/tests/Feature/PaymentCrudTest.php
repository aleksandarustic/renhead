<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class PaymentCrudTest
 * @package Tests\Feature
 */
class PaymentCrudTest extends TestCase
{

    /**
     *
     */
    public function testIfNonApproverCanSeeHisPayments()
    {
        $user = User::where('type', 'NON_APPROVER')->first();

        Sanctum::actingAs($user, ['NON_APPROVER']);

        $response = $this->get('/api/payments');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'total_amount',
                    'user_id'
                ]
            ],
            'meta' => [
                'path',
                'total',
                'per_page',
                'to'
            ]
        ]);

        $total = $response->json('meta')['total'];

        $this->assertEquals($total, $user->payments()->count());

    }

    /**
     *
     */
    public function testCreateAndUpdatePayment(){

        $user = User::where('type', 'NON_APPROVER')->first();

        Sanctum::actingAs($user, ['NON_APPROVER']);

        $response = $this->post("/api/payments", ['total_amount' => 20]);
        $response->assertOk();
        $response->assertJsonFragment(['total_amount' => 20, 'user_id' => $user->id]);

        $response = $this->put("/api/payments/{$response->json('data')['id']}", ['total_amount' => 30]);

        $response->assertOk();

    }


    /**
     *
     */
    public function testShowDeletePayment(){

        $user = User::where('type', 'NON_APPROVER')->first();

        Sanctum::actingAs($user, ['NON_APPROVER']);

        $payment = $user->payments()->first();

        $response = $this->get("/api/payments/{$payment->id}");
        $response->assertOk();
        $response->assertJsonFragment(['total_amount' => $payment->total_amount, 'user_id' => $payment->user_id, 'id' => $payment->id]);

        $response = $this->delete("/api/payments/{$response->json('data')['id']}");
        $response->assertOk();

        $this->assertSoftDeleted('payments',['id' => $payment->id]);
    }


    /**
     *
     */
    public function testAccessForNonApproval()
    {
        $user = User::where('type', 'NON_APPROVER')->first();

        Sanctum::actingAs($user, ['NON_APPROVER']);

        $payment = Payment::where('user_id', '!=', $user->id)->first();

        $response = $this->get("/api/payments/{$payment->id}");

        $response->assertStatus(403);

        $response = $this->put("/api/payments/{$payment->id}");

        $response->assertStatus(403);

        $response = $this->delete("/api/payments/{$payment->id}");

        $response->assertStatus(403);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAccessForApprover()
    {
        $user = User::where('type', 'APPROVER')->first();

        Sanctum::actingAs($user, ['APPROVER']);

        $response = $this->get('/api/payments');

        $response->assertStatus(200);

        $payment = Payment::first();

        $response = $this->get("/api/payments/{$payment->id}");

        $response->assertStatus(200);

        $response = $this->put("/api/payments/{$payment->id}");

        $response->assertStatus(403);

        $response = $this->delete("/api/payments/{$payment->id}");

        $response->assertStatus(403);

        $response = $this->post("/api/payments");

        $response->assertStatus(403);
    }

}
