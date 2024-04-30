<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * @var array
     */
    public $defaultListOfHolidays = [
        [
            'date' => '1004-01-01',
            'name' => 'New Year'
        ],
        [
            'date' => '1004-01-07',
            'name' => 'Christmas'
        ],
        [
            'start_date' => '1004-05-01',
            'end_date' => '1004-05-07',
            'name' => 'From 1st of May till 7th of May'
        ],
        [
            'week_number' => 3,
            'day_of_week' => 1,
            'month' => 1,
            'name' => 'Monday of the 3rd week of January'
        ],
        [
            'week_number' => -1,//-1 will be the last week of month
            'day_of_week' => 1,
            'month' => 3,
            'name' => 'Monday of the last week of March'
        ],
        [
            'week_number' => 4,
            'day_of_week' => 4,
            'month' => 11,
            'name' => 'Thursday of the 4th week of November'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->defaultListOfHolidays as $holiday) {
            Holiday::create($holiday);
        }
    }
}
