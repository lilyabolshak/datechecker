<?php

namespace App\Services;

use App\Models\HolidayStatistic;
use Illuminate\Support\Facades\DB;

class HolidayStatisticManagement
{
    /**
     * @param string $date
     * @return void
     */
    public function addStatistic(string $date): void
    {
        HolidayStatistic::updateOrInsert(
            ['date' => $date],
            ['count' => DB::raw('count + 1')]
        );
    }
}
