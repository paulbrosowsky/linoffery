<?php

use App\Tender;
use App\Freight;
use App\Location;
use Illuminate\Database\Seeder;


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

        $this->content();

        Schema::enableForeignKeyConstraints();   
    }

    public function content()
    {
        Tender::truncate();

        factory(Tender::class, 50)->states('from-existing-data')->create()->each(function($tender){
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
