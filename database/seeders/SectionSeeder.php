<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $i=0;

        for($i=0 ; $i<1 ; $i++){
            Section::create([
                'section_name'=>'البنك الاهلى ',
                'description'=>'توضيح البنك الاهلى',
                'created_by'=>'1'
            ]);
            Section::create([
                'section_name'=>'بنك القاهرة ',
                'description'=>'توضيح بنك القاهرة',
                'created_by'=>'1'
            ]);
            Section::create([
                'section_name'=>'بنك مصر ',
                'description'=>'توضيح بنك الاسكندرية',
                'created_by'=>'1'
            ]);
            Section::create([
                'section_name'=>'بنك العراق ',
                'description'=>'توضيح بنك العراث',
                'created_by'=>'1'
            ]);
            

        }

    }
}
