<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class IntegrationEnergyMeasurementControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testGetMeasurementsWithinDateRange()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $startDate = '2023-01-30';
        $endDate = '2023-12-30';

        $response = $this->get("/api/energy-measurements/{$user->id}?start_date={$startDate}&end_date={$endDate}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total_items_encontrados',
            'energy_value_total',
            'measurements',
        ]);
    }
}
