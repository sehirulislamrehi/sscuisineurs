<?php

namespace App\Console\Commands;

use App\Models\Bogo;
use App\Models\category;
use App\Models\menu;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class everyDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Menu Delete';

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
    public function handle(menu $menu)
    {
        //every day food deleted from menu
        // $categories = category::all();
        // foreach( $categories as $category){
        //     $category->menu()->detach();
        // }

        //everyday all bogo card number delete
        // $bogos = Bogo::whereDate('reservation_date', Carbon::now()->toDateString())->where('reservation_id', NULL)->where('reservation_date', NULL)->get();
        // foreach( $bogos as $bogo ):
        //     $bogo->delete();
        // endforeach;
    }
}
