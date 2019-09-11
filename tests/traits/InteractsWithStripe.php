<?php

namespace Tests\Traits;

use Illuminate\Database\Eloquent\Model;
use Stripe\Token;

trait InteractsWithStripe
{
    /**
     *  Create Stripe Token
     * 
     * @return Objekt stripeToken
     */
    protected function getStripeToken()
    {
        return Token::create([
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 1,
                'exp_year' => 2050,
                'cvc' => 123
            ]
        ]);
    }

    /**
     *  Create Stripe Customer
     * 
     * @param Company
     */
    protected function createStripeCustomer($company)
    {
        $company->addAsStripeCustomer($this->getStripeToken());
    }
    
    
}