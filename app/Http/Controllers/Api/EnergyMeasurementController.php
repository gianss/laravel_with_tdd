<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnergyMeasurement;
use App\Traits\BinaryConversionTrait;

class EnergyMeasurementController extends Controller
{
    use BinaryConversionTrait;
    public function getMeasurementsWithinDateRange(Request $request, $user_id)
    {
        try {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $limit = $request->query('limit', 10);
            $offset = $request->query('offset', 0);

            $energyMeasurement = new EnergyMeasurement();
            $measurements = $energyMeasurement->getMeasurementsWithinDateRange($user_id, $startDate, $endDate, $limit, $offset);
            $total = 0;
            $energy_value = 0;
            foreach ($measurements as $measurement) {
                $binaryEnergyValue = $measurement->energy_value;
                $decimalEnergyValue = $this->convertBinaryToDecimal($binaryEnergyValue);
                $measurement->energy_value = $decimalEnergyValue;
                $total++;
                $energy_value += $decimalEnergyValue;
            }

            return response()->json([
                'total_items_encontrados' => $total,
                'energy_value_total' => $energy_value,
                'measurements' => $measurements,
            ]);
        } catch (\Exception $excecao) {

            return response()->json(['error' => $excecao], 500);
        }
    }
}
