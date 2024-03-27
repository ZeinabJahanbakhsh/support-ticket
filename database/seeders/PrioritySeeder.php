<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = collect([
            [
                'name' => 'high'
            ],
            [
                'name' => 'medium'
            ],
            [
                'name' => 'low'
            ],
        ]);

        $data->each(function ($value) {
            Priority::create([
                'name' => $value['name']
            ]);
        });

    }
}
