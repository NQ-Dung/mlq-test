<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Subordinate;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();
        Subordinate::truncate();

        $faker = Faker\Factory::create();
        $userData = [];
        $subData = [];
        $tmp = [];
        $cnt = 1;

        for ($i=10; $i > 0; $i--) {
            $superiors = $tmp;
            $tmp = [];
            for ($j=0; $j < pow(4, 11 - $i) ; $j++) { 
                $userData[] = [
                    'id' => $cnt,
                    'name' => $faker->name,
                    'level' => $i,
                ];

                if ($i < 10) {
                    // $superiors = User::where('level', $i)->pluck('id')->toArray();
                    $subData[] = [
                        'user_id' => $superiors[array_rand($superiors)],
                        'sub_id' => $cnt,
                    ];
                }
                $tmp[] = $cnt;
                $cnt++;
            }
        }

        $chunks = array_chunk($userData, 10000);

        foreach ($chunks as $chunk) {
            User::insert($chunk);
        }

        $chunks = array_chunk($subData, 10000);

        foreach ($chunks as $chunk) {
            Subordinate::insert($chunk);
        }
    }
}
