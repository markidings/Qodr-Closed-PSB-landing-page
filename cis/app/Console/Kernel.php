<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\CekMoota;
use App\Models\Broadcast;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\MootaCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
     protected $cekmoota;
     
    protected function schedule(Schedule $schedule)
    {
        // \Log::info('before');        
    
    $this->cekmoota = new CekMoota();
    
        $schedule->call(function() {
            $this->cekmoota->index();
            // $data = [
            //     'message' => 'cron',
            //     'phone_number' => '085647443311',
            //     'type' => 'testing'
            // ];
            
            // $history = Broadcast::create($data);
        })->cron('*/15 * * * *');
        // \Log::info('after');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
