<?php

use Illuminate\Database\Seeder;
use App\Geopoint;
class GeopointTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toronto = [
            'lat' => 43.653225,
            'lon' => -79.383186
        ];

        $markham = [
            'lat' => 43.890380,
            'lon' => -79.309110
        ];

        $stouffville = [
            'lat' => 43.963840,
            'lon' => -79.236150
        ];


        Geopoint::truncate();
        Geopoint::create([
            'lat' => $toronto['lat'],
            'lon' => $toronto['lon'],
        ]);
        Geopoint::create([
            'lat' => $markham['lat'],
            'lon' => $markham['lon'],
        ]);
        Geopoint::create([
            'lat' => $stouffville['lat'],
            'lon' => $stouffville['lon'],
        ]);

    }
}
