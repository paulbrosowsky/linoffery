<?php

use App\Tender;
use App\Freight;
use App\Location;
use Illuminate\Database\Seeder;
use App\Category;

class TenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->categories()->content();

        Schema::enableForeignKeyConstraints();   
    }

    protected function categories()
    {
        Category::truncate();

        collect([
            [
                'name' => 'Standard',
                'slug' => 'standard',              
                'color' => '#4FD1C5',
            ],
            [
                'name' => 'Havy load',
                'slug' => 'havy-load',              
                'color' => '#F56565',
            ],
            [
                'name' => 'Foods',
                'slug' => 'foods',              
                'color' => '#ED8936',
            ],
            [
                'name' => 'Refrigerated',
                'slug' => 'refigerated',              
                'color' => '#4299E1',
            ],
            [
                'name' => 'Car transport',
                'slug' => 'car',              
                'color' => '#D69E2E',
            ],
            [
                'name' => 'Bulk',
                'slug' => 'bulk',              
                'color' => '#5A67D8',
            ],
            [
                'name' => 'Animals',
                'slug' => 'animals',              
                'color' => '#48BB78',
            ],
            [
                'name' => 'Luquids',
                'slug' => 'liquids',              
                'color' => '#9F7AEA',
            ],
            [
                'name' => 'Dangerous',
                'slug' => 'dangerous',              
                'color' => '#ED64A6',
            ],
        ])->each(function ($category) {
            factory(Category::class)->create([
                'name' => $category['name'],
                'slug' => $category['slug'],                
                'color' => $category['color'],                
            ]);
        });

        return $this;;
    }

    public function content()
    {
        Tender::truncate();

        factory(Tender::class, 100)->states('from-existing-data')->create()->each(function($tender){
            factory(Location::class)->create([
                'tender_id' => $tender->id,
                'type' => 'delivery',                
            ]);

            factory(Location::class)->create([
                'tender_id' => $tender->id,
                'type' => 'pickup',                
            ]);
            
            factory(Freight::class, 3)->create([
                'tender_id' => $tender->id
            ]);
        });
    }
}
