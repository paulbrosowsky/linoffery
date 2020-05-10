<?php

namespace App\Providers;

use App\Events\InvoiceCreated;
use App\Events\OfferAccepted;
use App\Events\OfferCreated;
use App\Events\OrderCreated;
use App\Events\TenderCompleted;
use App\Listeners\CompleteTender;
use App\Listeners\CreateInvoice;
use App\Listeners\CreateOrder;
use App\Listeners\CreatePayment;
use App\Listeners\CreatePdf;
use App\Listeners\NotifyOutbiddedUsers;
use App\Listeners\NotifyTenderOfferer;
use App\Listeners\NotifyTenderOwner;
use App\Listeners\RemoveUnusedOffers;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        OfferCreated::class => [            
            NotifyOutbiddedUsers::class
        ],

        OrderCreated::class => [                       
            CreateInvoice::class                 
        ],         
        
        InvoiceCreated::class => [
            CreatePayment::class
        ],
        
        OfferAccepted::class => [
            CompleteTender::class,
            RemoveUnusedOffers::class,
            CreateOrder::class
        ]        
    ];

     /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        NotifyTenderOfferer::class,
        NotifyTenderOwner::class,
        CreatePdf::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
