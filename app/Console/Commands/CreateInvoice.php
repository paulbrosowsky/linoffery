<?php

namespace App\Console\Commands;

use App\Company;
use App\Order;
use Illuminate\Console\Command;

class CreateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linoffery:create-invoice';

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
        $companies = Company::where('stripe_id', '!=', NULL);

        $companies->each(function($company){

            $orders = Order::where('carrier_id', $company->user->id)            
                        ->where('carrier_id', $company->user->id)
                        ->where('billed_at', NULL)
                        ->get();
            
            $company->createInvoice($orders);
            
        });
    }
}
