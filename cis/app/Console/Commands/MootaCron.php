<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CekMoota;
use App\Models\Broadcast;

class MootaCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moota:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek Moota User Payment';

    protected $cekmoota;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->cekmoota = new CekMoota();
        
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $this->cekmoota->index();
        $data = [
            'message' => 'cron',
            'phone_number' => '085647443311',
            'type' => 'testing'
        ];
        \Log::info('success gan wjwjw');
        print('awa');
        $history = Broadcast::create($data);
        $this->info('Moota Checking');
    }
}
