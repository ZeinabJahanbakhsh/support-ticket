<?php

namespace App\Console\Commands;

use App\Enums\RoleEnum;
use App\Models\Category;
use App\Models\CategoryTicket;
use App\Models\Comment;
use App\Models\Label;
use App\Models\LabelTicket;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Type\Integer;
use Symfony\Component\Console\Command\Command as CommandAlias;


class InsertRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'create:record {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get count of number records in the database';


    public function handle(): void
    {
        activity()->disableLogging();

        $count = $this->argument('count');
        $bar   = $this->output->createProgressBar($count);


        $bar->start();

        Artisan::call('migrate:fresh');
        Artisan::call('migrate');
        Artisan::call('db:seed');

        Category::factory($count)->create();
        Label::factory($count)->create();
        User::factory($count)->create();
        Ticket::factory($count)->create();
        CategoryTicket::factory($count)->create();
        LabelTicket::factory($count)->create();
        Comment::factory($count)->create();

        Artisan::call('optimize:clear');

        $this->newLine(1);
        $this->info('  Run migrations successful ...!');
        $this->info('  Run seeders successful ...!');
        $this->info('  Clear cache successful ...!');

        $bar->finish();

        $this->newLine(2);

        $this->alert('The command was successful! Check your database.');
    }


}
