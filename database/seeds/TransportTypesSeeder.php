<?php

use App\TransportType;
use Illuminate\Database\Seeder;

class TransportTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->transportTypes();

        Schema::enableForeignKeyConstraints();   
    }

    protected function transportTypes()
    {
        collect([
            [
                'title'     => 'Custom size',
                'subtitle'  =>  null,
                'width'     =>  null,
                'depth'     =>  null,
                'height'    =>  null
            ],
            // Euro Palette
            [
                'title'     => 'EURO palett',
                'subtitle'  =>  'EUR-EPAL1 120x80x14',
                'width'     =>  120,
                'depth'     =>  80,
                'height'    =>  null
            ],
            [
                'title'     => 'EURO palett',
                'subtitle'  =>  'EUR-EPAL2 120x100x14',
                'width'     =>  120,
                'depth'     =>  100,
                'height'    =>  null
            ],
            [
                'title'     => 'EURO palett',
                'subtitle'  =>  'EUR-EPAL3 100x120x14',
                'width'     =>  100,
                'depth'     =>  120,
                'height'    =>  null
            ],
            [
                'title'     => 'EURO palett',
                'subtitle'  =>  'EUR-EPAL6/7 60x80x14',
                'width'     =>  120,
                'depth'     =>  120,
                'height'    =>  null
            ],
            // Einwegpalette
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '40x30',
                'width'     =>  40,
                'depth'     =>  30,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '40x60',
                'width'     =>  40,
                'depth'     =>  60,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '60x80',
                'width'     =>  60,
                'depth'     =>  80,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x120',
                'width'     =>  80,
                'depth'     =>  120,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x125',
                'width'     =>  80,
                'depth'     =>  125,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x130',
                'width'     =>  80,
                'depth'     =>  130,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x135',
                'width'     =>  80,
                'depth'     =>  135,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x140',
                'width'     =>  80,
                'depth'     =>  140,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x145',
                'width'     =>  80,
                'depth'     =>  145,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x150',
                'width'     =>  80,
                'depth'     =>  150,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x155',
                'width'     =>  80,
                'depth'     =>  155,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x160',
                'width'     =>  80,
                'depth'     =>  160,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x165',
                'width'     =>  80,
                'depth'     =>  165,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x170',
                'width'     =>  80,
                'depth'     =>  170,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x175',
                'width'     =>  80,
                'depth'     =>  175,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x180',
                'width'     =>  80,
                'depth'     =>  180,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x185',
                'width'     =>  80,
                'depth'     =>  185,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x190',
                'width'     =>  80,
                'depth'     =>  190,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x195',
                'width'     =>  80,
                'depth'     =>  195,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '80x200',
                'width'     =>  80,
                'depth'     =>  200,
                'height'    =>  null
            ],
            [
                'title'     => 'One-way palett',
                'subtitle'  =>  '100x200',
                'width'     =>  100,
                'depth'     =>  200,
                'height'    =>  null
            ],

            //INKA- Palette
            [
                'title'     => 'INKA palett',
                'subtitle'  =>  '1/4 F44 F46 40x60',
                'width'     =>  40,
                'depth'     =>  60,
                'height'    =>  null
            ],
            [
                'title'     => 'INKA palett',
                'subtitle'  =>  '1/3 F36 40x80',
                'width'     =>  40,
                'depth'     =>  80,
                'height'    =>  null
            ],
            [
                'title'     => 'INKA palett',
                'subtitle'  =>  '1/2 F64 F65 60x80',
                'width'     =>  60,
                'depth'     =>  80,
                'height'    =>  null
            ],
            [
                'title'     => 'INKA palett',
                'subtitle'  =>  'Container F76 76x144',
                'width'     =>  76,
                'depth'     =>  144,
                'height'    =>  null
            ],
            [
                'title'     => 'INKA palett',
                'subtitle'  =>  'Euro F86 F87 F8/LF F8/LFs 80x120',
                'width'     =>  80,
                'depth'     =>  120,
                'height'    =>  null
            ],
            [
                'title'     => 'INKA palett',
                'subtitle'  =>  'Industry F10-2 F10-2s 100x120',
                'width'     =>  100,
                'depth'     =>  120,
                'height'    =>  null
            ],
            [
                'title'     => 'INKA palett',
                'subtitle'  =>  'Container F11 144x144',
                'width'     =>  144,
                'depth'     =>  144,
                'height'    =>  null
            ],
            // Plastic Palette
            [
                'title'     => 'Plastic palett',
                'subtitle'  =>  'Display 40x60',
                'width'     =>  40,
                'depth'     =>  60,
                'height'    =>  null
            ],
            [
                'title'     => 'Plastic palett',
                'subtitle'  =>  'Display 60x80',
                'width'     =>  60,
                'depth'     =>  80,
                'height'    =>  null
            ],
            [
                'title'     => 'Plastic palett',
                'subtitle'  =>  'Display 80x120',
                'width'     =>  80,
                'depth'     =>  120,
                'height'    =>  null
            ],
            [
                'title'     => 'Plastic palett',
                'subtitle'  =>  'Display 100x120',
                'width'     =>  100,
                'depth'     =>  120,
                'height'    =>  null
            ],
            
            // Chemie Palette
            [
                'title'     => 'Chemical palett',
                'subtitle'  =>  'CP1 100x120',
                'width'     =>  100,
                'depth'     =>  120,
                'height'    =>  null
            ],
            [
                'title'     => 'Chemical palett',
                'subtitle'  =>  'CP2 80x120',
                'width'     =>  80,
                'depth'     =>  120,
                'height'    =>  null
            ],
            [
                'title'     => 'Chemical palett',
                'subtitle'  =>  'CP3 114x144',
                'width'     =>  144,
                'depth'     =>  144,
                'height'    =>  null
            ],
            [
                'title'     => 'Chemical palett',
                'subtitle'  =>  'CP4 110x130',
                'width'     =>  110,
                'depth'     =>  130,
                'height'    =>  null
            ],
            [
                'title'     => 'Chemical palett',
                'subtitle'  =>  'CP5 76x114',
                'width'     =>  76,
                'depth'     =>  114,
                'height'    =>  null
            ],
            [
                'title'     => 'Chemical palett',
                'subtitle'  =>  'CP6 100x120',
                'width'     =>  100,
                'depth'     =>  120,
                'height'    =>  null
            ],
            [
                'title'     => 'Chemical palett',
                'subtitle'  =>  'CP7 110x130',
                'width'     =>  110,
                'depth'     =>  130,
                'height'    =>  null
            ],
            [
                'title'     => 'Chemical palett',
                'subtitle'  =>  'CP8 114x144',
                'width'     =>  114,
                'depth'     =>  144,
                'height'    =>  null
            ],
            [
                'title'     => 'Chemical palett',
                'subtitle'  =>  'CP9 144x144',
                'width'     =>  144,
                'depth'     =>  144,
                'height'    =>  null
            ],
            // CONE PAL
            [
                'title'     => 'CONE PAL',
                'subtitle'  =>  '40x60',
                'width'     =>  40,
                'depth'     =>  60,
                'height'    =>  null
            ],
            [
                'title'     => 'CONE PAL',
                'subtitle'  =>  '80x60',
                'width'     =>  80,
                'depth'     =>  60,
                'height'    =>  null
            ],
            [
                'title'     => 'CONE PAL',
                'subtitle'  =>  '120x80',
                'width'     =>  120,
                'depth'     =>  80,
                'height'    =>  null
            ],

            //FassPalette
            [
                'title'     => 'Drum palett',
                'subtitle'  =>  '2/4/6 120x120',
                'width'     =>  120,
                'depth'     =>  120,
                'height'    =>  null
            ],

            // Bigbag Palette
            [
                'title'     => 'BigBag palett',
                'subtitle'  =>  '110x110',
                'width'     =>  110,
                'depth'     =>  110,
                'height'    =>  null
            ],
            [
                'title'     => 'BigBag palett',
                'subtitle'  =>  '115x115',
                'width'     =>  115,
                'depth'     =>  115,
                'height'    =>  null
            ],

            // GitterBox
            [
                'title'     => 'Grid box',
                'subtitle'  =>  'EURO 84x124x97',
                'width'     =>  84,
                'depth'     =>  124,
                'height'    =>  97
            ],
            [
                'title'     => 'Grid box',
                'subtitle'  =>  'EURO 1/2 84x124x53(63)',
                'width'     =>  84,
                'depth'     =>  124,
                'height'    =>  53
            ],

            // Container
            [
                'title'     => 'Dry Container',
                'subtitle'  =>  'Standard 20"',
                'width'     =>  610,
                'depth'     =>  235,
                'height'    =>  240
            ],            
            [
                'title'     => 'Dry Container',
                'subtitle'  =>  'Standard 40"',
                'width'     =>  1203,
                'depth'     =>  235,
                'height'    =>  240
            ],
            [
                'title'     => 'Dry Container',
                'subtitle'  =>  'High Cube',
                'width'     =>  1203,
                'depth'     =>  235,
                'height'    =>  270
            ],
            [
                'title'     => 'Reefer Container',
                'subtitle'  =>  'Standard 20"',
                'width'     =>  545,
                'depth'     =>  228,
                'height'    =>  227
            ], 
            [
                'title'     => 'Reefer Container',
                'subtitle'  =>  'Standard 40"',
                'width'     =>  1158,
                'depth'     =>  228,
                'height'    =>  225
            ],
            [
                'title'     => 'Reefer Container',
                'subtitle'  =>  'High Cube',
                'width'     =>  1158,
                'depth'     =>  228,
                'height'    =>  256
            ],
            [
                'title'     => 'Open Top Container',
                'subtitle'  =>  'Standard 20"',
                'width'     =>  590,
                'depth'     =>  233,
                'height'    =>  234
            ],
            [
                'title'     => 'Open Top Container',
                'subtitle'  =>  'Standard 40"',
                'width'     =>  1203,
                'depth'     =>  233,
                'height'    =>  234
            ],
            [
                'title'     => 'Fiat Rack Container',
                'subtitle'  =>  'Standard 20"',
                'width'     =>  563,
                'depth'     =>  217,
                'height'    =>  216
            ],
            [
                'title'     => 'Fiat Rack Container',
                'subtitle'  =>  'Standard 40"',
                'width'     =>  1776,
                'depth'     =>  218,
                'height'    =>  199
            ],
            [
                'title'     => 'High Cube(45HC)',
                'subtitle'  =>  'Standard 45"',
                'width'     =>  1372,
                'depth'     =>  290,
                'height'    =>  244
            ],
            [
                'title'     => 'Palletwide(45PW)',
                'subtitle'  =>  'Standard 45"',
                'width'     =>  1372,
                'depth'     =>  259,
                'height'    =>  250
            ],
            [
                'title'     => 'Storage Container',
                'subtitle'  =>  '6"',
                'width'     =>  null,
                'depth'     =>  null,
                'height'    =>  null
            ],
            [
                'title'     => 'Storage Container',
                'subtitle'  =>  '8"',
                'width'     =>  null,
                'depth'     =>  null,
                'height'    =>  null
            ],
            [
                'title'     => 'Storage Container',
                'subtitle'  =>  '10"',
                'width'     =>  null,
                'depth'     =>  null,
                'height'    =>  null
            ],
            [
                'title'     => 'Storage Container',
                'subtitle'  =>  '15"',
                'width'     =>  null,
                'depth'     =>  null,
                'height'    =>  null
            ],
            [
                'title'     => 'Storage Container',
                'subtitle'  =>  '20"',
                'width'     =>  null,
                'depth'     =>  null,
                'height'    =>  null
            ],
            [
                'title'     => 'Tank Container',
                'subtitle'  =>  '20"',
                'width'     =>  606,
                'depth'     =>  244,
                'height'    =>  244
            ],

        ])->each(function ($type) {
            factory(TransportType::class)->create([
                'title' => $type['title'],
                'subtitle' => $type['subtitle'],
                'width' => $type['width'],
                'depth' => $type['depth'],
                'height' => $type['height']                                
            ]);
        });
    }
}
