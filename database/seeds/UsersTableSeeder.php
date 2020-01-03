<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Geopoint;

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
        $geopoint = Geopoint::get();

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
        
        $admin->geopoints()->attach($geopoint[0]);
        $producer->geopoints()->attach($geopoint[1]);
        $user->geopoints()->attach($geopoint[2]);

    }
}
