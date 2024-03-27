<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = collect([
            [
                'name' => 'open',
                'code' => 'Open'
            ],
            [
                'name' => 'close',
                'code' => 'Close'
            ]
        ]);

        $data->each(function ($value) {
            Status::create([
                'name' => $value['name'],
                'code' => $value['code'],
            ]);
        });
    }


}
