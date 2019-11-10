<?php

use App\Priority;
use Illuminate\Database\Seeder;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $priorities = [
            'Low', 'Medium', 'High'
        ];

        foreach($priorities as $priority)
        {
            Priority::create([
                'name'  => $priority,
                'color' => $faker->hexcolor
            ]);
        }
    }
}
