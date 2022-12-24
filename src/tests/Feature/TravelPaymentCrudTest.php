<?php

namespace Tests\Feature;

use App\Models\TravelPayment;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class TravelPaymentCrudTest
 * @package Tests\Feature
 */
class TravelPaymentCrudTest extends TestCase
{

    /**
     *
     */
    public function testIfNonApproverCanSeeHisPayments()
    {
        $user = User::where('type', 'NON_APPROVER')->first();

        Sanctum::actingAs($user, ['NON_APPROVER']);

        $response = $this->get('/api/travel-payments');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'amount',
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

        $this->assertEquals($total, $user->travelPayments()->count());

    }

    /**
     *
     */
    public function testCreateAndUpdatePayment(){

        $user = User::where('type', 'NON_APPROVER')->first();

        Sanctum::actingAs($user, ['NON_APPROVER']);

        $response = $this->post("/api/travel-payments", ['amount' => 20]);
        $response->assertOk();
        $response->assertJsonFragment(['amount' => 20, 'user_id' => $user->id]);

        $response = $this->put("/api/travel-payments/{$response->json('data')['id']}", ['amount' => 30]);

        $response->assertOk();

    }


    /**
     *
     */
    public function testShowDeletePayment(){

        $user = User::where('type', 'NON_APPROVER')->first();

        Sanctum::actingAs($user, ['NON_APPROVER']);

        $payment = $user->travelPayments()->first();

        $response = $this->get("/api/travel-payments/{$payment->id}");
        $response->assertOk();
        $response->assertJsonFragment(['amount' => $payment->amount, 'user_id' => $payment->user_id, 'id' => $payment->id]);

        $response = $this->delete("/api/travel-payments/{$response->json('data')['id']}");
        $response->assertOk();

        $this->assertSoftDeleted('travel_payments',['id' => $payment->id]);
    }


    /**
     *
     */
    public function testAccessForNonApproval()
    {
        $user = User::where('type', 'NON_APPROVER')->first();

        Sanctum::actingAs($user, ['NON_APPROVER']);

        $payment = TravelPayment::where('user_id', '!=', $user->id)->first();

        $response = $this->get("/api/travel-payments/{$payment->id}");

        $response->assertStatus(403);

        $response = $this->put("/api/travel-payments/{$payment->id}");

        $response->assertStatus(403);

        $response = $this->delete("/api/travel-payments/{$payment->id}");

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

        $response = $this->get('/api/travel-payments');

        $response->assertStatus(200);

        $payment = TravelPayment::first();

        $response = $this->get("/api/travel-payments/{$payment->id}");

        $response->assertStatus(200);

        $response = $this->put("/api/travel-payments/{$payment->id}");

        $response->assertStatus(403);

        $response = $this->delete("/api/travel-payments/{$payment->id}");

        $response->assertStatus(403);

        $response = $this->post("/api/travel-payments");

        $response->assertStatus(403);
    }

}
