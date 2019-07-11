<?php

use Illuminate\Database\Seeder;
use App\Cargo;
use App\Freight;
use App\Location;

class CargoSeeder extends Seeder
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
        Cargo::truncate();

        factory(Cargo::class, 20)->states('from-existing-data')->create()->each(function($cargo){
            factory(Location::class)->create([
                'cargo_id' => $cargo->id,
                'type' => 'delivery',                
            ]);
            factory(Location::class)->create([
                'cargo_id' => $cargo->id,
                'type' => 'pickup',                
            ]);
            
            factory(Freight::class, 3)->create([
                'cargo_id' => $cargo->id
            ]);
        });
    }
}
