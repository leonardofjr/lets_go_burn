<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Studio;
class StudiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Studio::truncate();
        $miguel = User::where('email', 'miguel@webmaster.com')->first();

        $data = [
            'name' => 'Young Savage Studio',
            'phone' => '(416) 907-4697',
            'address' => '188 Bur Oak Avenue',
            'city' => 'Markham',
            'postal_code' => 'L6C-2M1',
            'lat' => 43.890381,
            'lon' => -79.309113,
        ];


        $studio = Studio::create($data);

        $studio->user()->associate($miguel);
        $studio->save();

        $miguel->studio_id = $studio->id;
        $miguel->save();
        
        $studio->testStudioDatabase();

        }
}
