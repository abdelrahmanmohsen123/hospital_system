<?php

namespace Database\Seeders;

use App\Models\speciality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        speciality::create(['name'=>'General practice']);
        speciality::create(['name'=>'Pediatrics']);
        speciality::create(['name'=>'Radiology']);
        speciality::create(['name'=>'Ophthalmology']);
        speciality::create(['name'=>'Sports medicine and rehabilitation']);
        speciality::create(['name'=>'Oncology']);
        speciality::create(['name'=>'Dermatology']);
        speciality::create(['name'=>'Emergency Medicine']);

    }
}