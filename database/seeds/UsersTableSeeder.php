<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Studio;
use App\Geopoint;
use Faker\Factory as Faker;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        
        $adminRole = Role::where('name', 'admin')->first();
        $producerRole = Role::where('name', 'producer')->first();
        $userRole = Role::where('name', 'user')->first();

        /* Getting geopoints table data */
  
        /* Getting studios table data */

       /* Creating user table data */ 
        $admin = User::create([
            'fname' => 'Leo',
            'email' => 'leo@webmaster.com',
            'password' => bcrypt('password'),
        ]);

        $producer = User::create([
            'fname' => 'Miguel',
            'email' => 'miguel@webmaster.com',
            'password' => bcrypt('password'),
        ]);

        $user = User::create([
            'fname' => 'Fernando',
            'email' => 'fernando@webmaster.com',
            'password' => bcrypt('password'),
        ]);



        $admin->roles()->attach($adminRole);
        $producer->roles()->attach($producerRole);
        $user->roles()->attach($userRole);
        


        $user->testDatabase();


    }
}
