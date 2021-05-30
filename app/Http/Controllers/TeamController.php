<?php

	namespace App\Http\Controllers;

	use App\Models\Team;
	use App\Models\WeeklyMatch;
	use Faker\Factory as Faker;

	class TeamController extends Controller
	{

		public function teams(){
			$teams =  Team::orderBy('name', 'ASC')->get();
			foreach ($teams as $team){
				$stats = $this->getStats($team->id);
				$team['stats'] = $stats;
			}
			return $teams;
		}

		public function getPlayedMatches($team_id){
			return WeeklyMatch::where('host', $team_id)->orWhere('away', $team_id)->count();
		}

		public function resetMatches(){
			try {
				WeeklyMatch::truncate();
				return true;
			}catch (\Exception $e){
				return $e;
			}
		}

		public function organizeMatches($weekTime){
			if ($this->resetMatches()){
				$faker = Faker::create();
				for ($week = 1; $week <= $weekTime; $week++) {
					$teams = Team::get()->toArray();
					for ($i = 0; $i <= count($teams) + 7; $i++) {
						$rand_keys = array_rand($teams, 2);
						$host = $teams[$rand_keys[0]]["id"];
						$away = $teams[$rand_keys[1]]["id"];
						unset($teams[$rand_keys[0]]);
						unset($teams[$rand_keys[1]]);
						WeeklyMatch::create([
							'host' => $host,
							'away' => $away,
							'week' => $week,
							'host_goal' => $faker->numberBetween(0, 4),
							'away_goal' => $faker->numberBetween(0, 4),
						]);
					}
				}
				return ['success' => true];
			}
		}

		public function getStats($team_id){
			$teamMatches = WeeklyMatch::where('host', $team_id)->orWhere('away', $team_id)->get();
			$wonnedMatchCount = 0;
			$losedMatchCount = 0;
			$drawnMatchCount = 0;
			$playedMatchCount = 0;
			$goalsFor = 0;
			$goalsAgainst = 0;
			$goalsDifference = 0;
			$pts = 0;
			foreach ($teamMatches as $teamMatch){
				if($teamMatch->host == $team_id && $teamMatch->host_team_goal() > $teamMatch->away_team_goal()){
					$wonnedMatchCount++;
					$pts += 3;
				}
				elseif($teamMatch->away == $team_id && $teamMatch->away_team_goal() > $teamMatch->host_team_goal()){
					$wonnedMatchCount++;
					$pts += 3;
				}
				elseif ($teamMatch->host == $team_id && $teamMatch->host_team_goal() < $teamMatch->away_team_goal()){
					$losedMatchCount++;
				}
				elseif($teamMatch->away == $team_id && $teamMatch->away_team_goal() < $teamMatch->host_team_goal()){
					$losedMatchCount++;
				}else{
					$drawnMatchCount++;
					$pts += 1;
				}
				if ($teamMatch->host == $team_id){
					$goalsFor += $teamMatch->host_team_goal();
					$goalsAgainst += $teamMatch->away_team_goal();
				}else{
					$goalsFor += $teamMatch->away_team_goal();
					$goalsAgainst += $teamMatch->host_team_goal();
				}
				$playedMatchCount++;
				$goalsDifference = floor($goalsFor - $goalsAgainst);
			}

			return [
				'won' => $wonnedMatchCount,
				'lose' => $losedMatchCount,
				'drawn' => $drawnMatchCount,
				'played' => $playedMatchCount,
				'goals_for' => $goalsFor,
				'goals_against' => $goalsAgainst,
				'goals_diff' => $goalsDifference,
				'pts' => $pts
			];
		}

		public function getFixtures(){
			return WeeklyMatch::with(['host_team', 'away_team'])->get()->groupBy('week');
		}
	}
