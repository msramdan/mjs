<?php

namespace Database\Seeders;

use App\Models\Sale\TimeSheet;
use Illuminate\Database\Seeder;

class TimeSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeSheet = TimeSheet::create([
            'spal_id' => 1,
            'kode_time_sheet' => 'TS0001',
            'qty' => 6,
            'hari' => 5,
            'jam' => 9,
            'menit' => 30,
        ]);

        $timeSheet->detail_time_sheets()->create([
            'date' => date('Y-m-d'),
            'remark' => 'test',
            'from' => '08:00',
            'to' => '09:00',
            'keterangan' => 'test',
        ]);
    }
}
