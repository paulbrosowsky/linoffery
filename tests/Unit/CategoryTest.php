<?php
namespace Test\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;   

    /** @test */
    function it_consists_of_tenders()
    {
        $category = create('App\Category');
        $tender = create('App\Tender', ['category_id' => $category->id]);        

        $this->assertTrue($category->tenders->contains($tender));
    }

    /** @test */
    function all_categories_can_be_fetched()
    {
        $category = create('App\Category');
        create('App\Category', [], 4);

        $response = $this->getJson('/api/categories')->json(); 

        $this->assertCount(5, $response);       
        $this->assertContains($category->name, $response[0]['name']);       
    }
    
}