<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industries=[
            'Software',
            'Healthcare',
            'Finance',
            'Retail',
            'Education',
            'Manufacturing'
        ];
        foreach($industries as $industry){
            Industry::create(['name'=>$industry]);
        }
    }
}
