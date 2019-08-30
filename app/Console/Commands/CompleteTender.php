<?php

namespace App\Console\Commands;

use App\Notifications\TenderRunOut;
use App\Tender;
use Illuminate\Console\Command;

class CompleteTender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linoffery:complete-tender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set tender as complete and notify the owner.';

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
        $tenders = Tender::where('valid_date', '<', now())
                        ->where('published_at','!=', null)
                        ->where('completed_at', null )
                        ->get();
        
        $tenders->map(function($tender){            
            $tender->complete();
            
            if(env('APP_ENV') === 'testing'){
               return  $tender->user->notify(new TenderRunOut($tender));
            } 
                    
            $later = now()->addHours(8);

            $tender->user->notify((new TenderRunOut($tender))->delay($later));                    
        });
    }
}
