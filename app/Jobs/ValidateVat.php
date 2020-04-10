<?php

namespace App\Jobs;

use App\Company;
use App\Notifications\InvalidVatNumber;
use DvK\Laravel\Vat\Facades\Validator;
use DvK\Vat\Vies\ViesException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ValidateVat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {    
        try {
            $valid =  Validator::validate($this->company->vat);
            
        } catch (ViesException $e) {
            throw $e;
        }

        if(!$valid){
            return $this->company->user->notify(new InvalidVatNumber());
        }

        return $this->company->update(['vat_validated_at' => now()]);
    }
}
