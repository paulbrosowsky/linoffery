<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
      /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->users();

        Schema::enableForeignKeyConstraints();
    }

    protected function users()
    {
        User::truncate();

        collect([
            [
                'name' => 'John Doe',                
                'email' => 'john@example.com',
                'password' => bcrypt('secret'),
                'avatar' => 'https://randomuser.me/portraits/men/85.jpg'
            ],
            [
                'name' => 'Indiana Jones',                
                'email' => 'indy@example.com',
                'password' => bcrypt('password'),
                'avatar' => 'https://randomuser.me/portraits/men/35.jpg'
            ],
            [
                'name' => 'Ben Solo',            
                'email' => 'kylo@example.com',
                'password' => bcrypt('password'),
                'avatar' => 'https://randomuser.me/portraits/men/22.jpg'
            ],
            [
                'name' => 'Marty McFly',
                'email' => 'calvin@example.com',
                'password' => bcrypt('password'),
                'avatar' => 'https://randomuser.me/portraits/men/10.jpg'
            ],
        ])->each(function ($user) {
            factory(User::class)->create(
                [
                    'name' => $user['name'],                 
                    'email' => $user['email'],
                    'password' => bcrypt('password'),
                    'avatar' => $user['avatar']
                ]
            );
        });        
    }   
}
