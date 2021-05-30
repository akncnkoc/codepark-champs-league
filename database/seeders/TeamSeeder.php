<?php

	namespace Database\Seeders;

	use App\Models\Team;
	use Illuminate\Database\Seeder;

	class TeamSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			$teams = [
				'Manchester City',
				'Manchester United',
				'Liverpool',
				'Chelsea',
				'Leicester City',
				'West Ham United',
				'Tottenham Hotspur',
				'Arsenal',
				'Leeds United',
				'Everton',
				'Aston Villa',
				'Newcastle United',
				'Wolverhampton Wanderers',
				'Crystal Palace',
				'Southampton',
				'Brighton and Hove Albion',
				'Burnley',
				'Fulham',
				'Wesh Bromwich Albion',
				'Sheffield United'
			];
			if (Team::count() <= 0){
				foreach ($teams as $team) {
					Team::create([
						'name' => $team,
					]);
				}
			}
		}
	}
