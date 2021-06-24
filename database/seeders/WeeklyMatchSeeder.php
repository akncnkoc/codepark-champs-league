<?php

	namespace Database\Seeders;

	use App\Models\Team;
	use App\Models\WeeklyMatch;
	use Faker\Factory as Faker;
	use Illuminate\Database\Seeder;

	class WeeklyMatchSeeder extends Seeder
	{


		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			$faker = Faker::create();
			for ($week = 1; $week <= 5; $week++) {
				$teams = Team::get()->toArray();
				for ($i = 0; $i <= count($teams) + 7; $i++) {
					$rand_keys = array_rand($teams, 2);
					$host = $teams[$rand_keys[0]]["id"];
					$away = $teams[$rand_keys[1]]["id"];
					unset($teams[$rand_keys[0]]);
					unset($teams[$rand_keys[1]]);
					WeeklyMatch::create([
						'host_team' => $host,
						'away_team' => $away,
						'week' => $week,
						'host_goal' => $faker->numberBetween(1, 7),
						'away_goal' => $faker->numberBetween(1, 7),
					]);
				}
			}
		}
	}
