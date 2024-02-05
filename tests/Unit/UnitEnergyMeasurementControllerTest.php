<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\EnergyMeasurementController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UnitEnergyMeasurementControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetMeasurementsWithinDateRange()
    {
        $controller = new EnergyMeasurementController();

        $startDate = '2023-01-01';
        $endDate = '2023-12-30';
        $user_id = 1;
        $response = $controller->getMeasurementsWithinDateRange(
            new Request(['start_date' => $startDate, 'end_date' => $endDate]),
            $user_id
        );
        $responseArray = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('total_items_encontrados', $responseArray);
        $this->assertArrayHasKey('energy_value_total', $responseArray);
        $this->assertArrayHasKey('measurements', $responseArray);
    }
}
