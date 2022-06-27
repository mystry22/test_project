<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Systems;

class Schedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '24hourly:sche';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears Db After 24hr';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all_data = Systems::all();
        $all_data.delete();
    }
}
