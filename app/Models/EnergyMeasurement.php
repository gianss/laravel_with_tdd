<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EnergyMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'energy_value',
        'measurement_datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMeasurementsWithinDateRange($user_id, $startDate = null, $endDate = null, $limit = 10, $offset = 0)
    {
        $query = DB::table('energy_measurements')
            ->select('id', 'user_id', 'energy_value', 'measurement_datetime')
            ->where('user_id', $user_id);
        if ($startDate !== null && $endDate !== null) {
            $query->whereBetween('measurement_datetime', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $query->limit($limit)->offset($offset);

        return $query->get();
    }
}
