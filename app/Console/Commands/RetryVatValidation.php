<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RetryVatValidation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linoffery:retry-vat-validation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retry Failed Vat Validation Jobs';

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
     * @return mixed
     */
    public function handle()
    {        
        $jobs = DB::table('failed_jobs')
                    ->where('payload', 'LIKE', '%ValidateVat%')
                    ->where('failed_at', '>=', now()->subDays(3))
                    ->get();

        $jobs->map(function($job){
            Artisan::call('queue:retry '. $job->id);
        });
       
    }
}
