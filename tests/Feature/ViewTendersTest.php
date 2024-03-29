<?php

namespace Tests\Features;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tender;
use Carbon\Carbon;

class ViewTendersTest extends PassportTestCase
{
    use RefreshDatabase;
    
    /** @test */
    function a_user_can_view_all_tenders()
    {
        create('App\Tender', [], 3);

        $response = $this->getJson('api/tenders')->json();
        
        $this->assertCount(3, $response['data']);        
    }

    /** @test */
    function a_user_can_view_a_single_tender()    
    {
        $tender = create('App\Tender');

        $response = $this->getJson('api/tenders/'.$tender->id)->json();

        $this->assertContains($tender->title, $response['title']);  
    }

    /** @test */
    function users_can_view_only_published_tenders()
    {
        create('App\Tender');
        create('App\Tender', ['published_at' => null]);

        $this->assertCount(2, Tender::all()); 

        $response = $this->getJson('api/tenders')->json();
        
        $this->assertCount(1, $response['data']);  
    }

    /** @test */
    function not_owners_may_not_view_unpublished_tenders()
    {
        $this->withExceptionHandling();

        $user = create('App\User');
        $tender = create('App\Tender', [
            'user_id' => $user->id,
            'published_at' => null
        ]);

        $this->signIn();        

        $this->getJson('api/tenders/'.$tender->id)
            ->assertStatus(403);
    }

    /** @test */
    function not_owners_may_not_view_completed_tenders()
    {
        $this->withExceptionHandling();

        $user = create('App\User');
        $tender = create('App\Tender', [
            'user_id' => $user->id,
            'completed_at' => Carbon::now()
        ]);

        $this->signIn();        

        $this->getJson('api/tenders/'.$tender->id)
            ->assertStatus(403);
    }

    /** @test */
    function only_owners_can_view_unpublished_tenders()
    { 
        $user = create('App\User');
        $tender = create('App\Tender', [
            'user_id' => $user->id,
            'published_at' => null
        ]);

        $this->signIn($user);        

        $response = $this->getJson('api/tenders/'.$tender->id)->json();

        $this->assertContains($tender->title, $response['title']);             
    }

    /** @test */
    function only_owners_can_view_completed_tenders()
    { 
        $user = create('App\User');
        $tender = create('App\Tender', [
            'user_id' => $user->id,
            'completed_at' => Carbon::now()
        ]);

        $this->signIn($user);        

        $response = $this->getJson('api/tenders/'.$tender->id)->json();

        $this->assertContains($tender->title, $response['title']);             
    }

    /** @test */
    function users_can_filter_tenders_by_the_route()
    {   
        create('App\Tender', [], 4);
        $tender = create('App\Tender');
        create('App\Location', [
            'tender_id' => $tender->id,
            'type' => 'pickup',
            'lat' =>  42,
            'lng' => 2
        ]);
        create('App\Location', [
            'tender_id' => $tender->id,
            'type' => 'delivery',
            'lat' =>  43,
            'lng' => 3
        ]);

        $route = [
            "bounds" =>[["south"=>40, "north"=>44, "west"=>1, "east"=> 4]],
            "locations"=>[
                "start"=>["lat"=>41, "lng"=>2],
                "end"=>["lat"=>46, "lng"=>3],
            ]          
        ];

        $response = $this->getJson('api/tenders?route='.json_encode($route))->json();               
        
        $this->assertCount(5, Tender::all());
        $this->assertCount(1, $response['data']);       
        $this->assertEquals($tender->title, $response['data'][0]['title']);
    }

    /** @test */
    function users_can_filter_tenders_near_by()
    {   
        create('App\Tender', [], 4);
        $tender = create('App\Tender');
        $pickup = create('App\Location', [
            'tender_id' => $tender->id,
            'type' => 'pickup',
            'lat' =>  42,
            'lng' => 2
        ]); 

        $location = ["south"=>40, "north"=>44, "west"=>1, "east"=> 4];

        $response = $this->getJson('api/tenders?location='.json_encode($location))->json();               
        
        $this->assertCount(5, Tender::all());
        $this->assertCount(1, $response['data']);       
        $this->assertEquals($tender->title, $response['data'][0]['title']);
    }

    /** @test */
    function users_cam_filter_tenders_by_category()
    {
        $tenders = create('App\Tender', [], 5);

        $categories = [
            $tenders->first()->category, 
            $tenders->last()->category
        ];

        $response = $this->getJson('api/tenders?category='.json_encode($categories))->json(); 

        $this->assertCount(5, Tender::all());
        $this->assertCount(2, $response['data']); 
    }

    /** @test */
    function users_can_filter_tenders_by_price()
    {
        create('App\Tender', [], 3);
        $tenderWithOffer = create('App\Tender');
        create('App\Offer', [
            'tender_id' => $tenderWithOffer->id,
            'price' => 120
        ]);
        $tenderMaxPrice = create('App\Tender', ['max_price' => 150]);

        $priceRange = [ 'min'=>100, 'max'=>150];

        $response = $this->getJson('api/tenders?price='.json_encode($priceRange))->json();

        $this->assertCount(5, Tender::all());
        $this->assertCount(2, $response['data']); 
        $this->assertContains($tenderWithOffer->title, $response['data'][1]);
        $this->assertContains($tenderMaxPrice->title, $response['data'][0]);        
    }

     /** @test */
    function users_can_filter_tenders_by_date()
    {
        create('App\Tender', [], 3);
        $tender = create('App\Tender');
        create('App\Location', [
            'tender_id' => $tender->id,            
            'earliest_date' => Carbon::now(),
            'latest_date' => Carbon::now()->addDays(2)
        ], 2); 

        $dateRange = [ 'from'=> Carbon::now(), 'to'=>Carbon::now()->addDays(3)];

        $response = $this->getJson('api/tenders?date='.json_encode($dateRange))->json();

        $this->assertCount(4, Tender::all());
        $this->assertCount(1, $response['data']);         
        $this->assertContains($tender->title, $response['data'][0]);        
    }

     /** @test */
    function users_can_filter_tenders_by_weight()
    {
        create('App\Freight', [], 4);
        $tender= create('App\Tender');
        create('App\Freight', [
            'tender_id' => $tender->id,
            'weight' => 2
        ], 2);
               

        $weightRange = [ 'min'=>2, 'max'=>5];

        $response = $this->getJson('api/tenders?weight='.json_encode($weightRange))->json();
        
        $this->assertCount(5, Tender::all());
        $this->assertCount(1, $response['data']); 
        $this->assertContains($tender->title, $response['data'][0]);           
    }
    
}