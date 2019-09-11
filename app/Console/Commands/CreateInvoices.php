<?php

namespace App\Console\Commands;

use App\Company;
use App\Jobs\CreateInvoicesJob;
use App\Order;
use Illuminate\Console\Command;

class CreateInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linoffery:create-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create monthly invoices.';

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
        $companies = Company::where('stripe_id', 'LIKE', 'cus_%');       
        
        $companies->each(function($company){
           CreateInvoicesJob::dispatch($company);            
        });
    }
}
