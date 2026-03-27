<?php

namespace Database\Seeders;

use App\Models\Fee;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    public function run(): void
    {
        $fees = [
            ['minFee' => 0, 'maxFee' => 1000, 'percentage' => 0],
            ['minFee' => 1001, 'maxFee' => 5000, 'percentage' => 5],
            ['minFee' => 5001, 'maxFee' => 1000000, 'percentage' => 10],
        ];

        foreach ($fees as $fee) {
            Fee::updateOrCreate(
                ['minFee' => $fee['minFee'], 'maxFee' => $fee['maxFee']],
                ['percentage' => $fee['percentage']]
            );
        }
    }
}