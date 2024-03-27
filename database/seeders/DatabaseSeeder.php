<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Status;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('role_user')->truncate();
        DB::table('statuses')->truncate();

        Schema::enableForeignKeyConstraints();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            RoleUserSeeder::class,
            StatusSeeder::class
        ]);

    }
}
