<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\CategoryTicket;
use App\Models\Comment;
use App\Models\Label;
use App\Models\LabelTicket;
use App\Models\RoleUser;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use Database\Factories\RoleUserFactory;
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

        DB::table('categories')->truncate();
        DB::table('category_ticket')->truncate();
        DB::table('labels')->truncate();
        DB::table('label_ticket')->truncate();
        DB::table('priorities')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('statuses')->truncate();
        DB::table('comments')->truncate();
        DB::table('tickets')->truncate();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            StatusSeeder::class,
            PrioritySeeder::class
        ]);

       /* Category::factory(10)->create();
        Label::factory(10)->create();
        User::factory(10)->create();
        Ticket::factory(10)->create();
        CategoryTicket::factory(10)->create();
        LabelTicket::factory(10)->create();
        Comment::factory(30)->create();*/

        Schema::enableForeignKeyConstraints();

    }
}
