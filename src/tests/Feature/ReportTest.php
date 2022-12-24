<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class ReportTest
 * @package Tests\Feature
 */
class ReportTest extends TestCase
{
    /**
     *
     */
    public function testReportEndpoint()
    {

        $user = User::where('type', ['APPROVER'])->first();

        Sanctum::actingAs($user, ['APPROVER']);

        $response = $this->get("/api/report");

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'first_name',
                    'last_name',
                    'total',
                    'user_id'
                ]
            ],
        ]);

        $approverNumber = User::where('type', 'APPROVER')->count();

        $this->assertEquals($approverNumber, count($response->json('data')));
    }


    /**
     *
     */
    public function testAccessOnReport()
    {
        $response = $this->get("/api/report");

        $response->assertStatus(401);
    }


}
