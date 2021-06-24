<?php

	namespace App\Http\Controllers;

	use App\Models\Team;
	use App\Models\WeeklyMatch;
	use App\Repostories\Teams\TeamsRepository;
	use App\Repostories\WeeklyMatches\WeeklyMatchesRepository;
	use Faker\Factory as Faker;

	class TeamController extends Controller
	{

		/**
		 * @var TeamsRepository
		 */
		private $teamRepository;
		/**
		 * @var WeeklyMatchesRepository
		 */
		private $matchesRepository;

		/**
		 * TeamController constructor.
		 * @param TeamsRepository $teamRepository
		 * @param WeeklyMatchesRepository $matchesRepository
		 */
		public function __construct(TeamsRepository $teamRepository, WeeklyMatchesRepository $matchesRepository)
		{
			$this->teamRepository = $teamRepository;
			$this->matchesRepository = $matchesRepository;
		}

		/**
		 * @param $team_id
		 * @return array
		 */
		public function getStats($team_id)
		{
			$teamMatches = $this->matchesRepository->where('host_team', $team_id)->orWhere('away_team', $team_id)->get();
			$team = $this->teamRepository->find($team_id);
			$goalsFor = 0;
			$goalsAgainst = 0;
			$goalsDifference = 0;
			$pts = 0;
			//for each team matches
			foreach ($teamMatches as $teamMatch) {
				//if current team host team and host team more goal from the away team is winning team the current team
				//current team plus 3 point
				//current team plus 1 wonned match
				if ($teamMatch->host_team == $team_id && $teamMatch->host_team_goal() > $teamMatch->away_team_goal()) {
					$team->wonnedMatchCount++;
					$team->pts += 3;
				}
				//is not if current team away team and host team more goal from the host team is winning team the current team
				//current team plus 3 point
				//current team plus 1 wonned match
				elseif ($teamMatch->away_team == $team_id && $teamMatch->away_team_goal() > $teamMatch->host_team_goal()) {
					$team->wonnedMatchCount++;
					$team->pts += 3;
				}
				//is not if current team host team and host team less goal from the away team is loses team the current team
				//current team plus 1 losed match
				elseif ($teamMatch->host_team == $team_id && $teamMatch->host_team_goal() < $teamMatch->away_team_goal()) {
					$team->losedMatchCount++;
				}
				//is not if current team away team and host team less goal from the host team is loses team the current team
				//current team plus 1 losed match
				elseif ($teamMatch->away_team == $team_id && $teamMatch->away_team_goal() < $teamMatch->host_team_goal()) {
					$team->losedMatchCount++;
				}
				//otherwise add plus 1 current team to drawn match
				//current team plus 1 point
				else {
					$team->drawnMatchCount++;
					$team->pts += 1;
				}
				// if host team is current team
				if ($teamMatch->host_team == $team_id) {
					// plus host team up to current team goalsfor
					$goalsFor += $teamMatch->host_team_goal();
					// plus host team up to current team goalagainst
					$goalsAgainst += $teamMatch->away_team_goal();
				} else {
					// plus away team up to current team goalsfor
					$goalsFor += $teamMatch->away_team_goal();
					// plus awy team up to current team goalagainst
					$goalsAgainst += $teamMatch->host_team_goal();
				}
				//current team played match count
				$team->playedMatchCount++;
				//current match goals difference
				$goalsDifference = floor($goalsFor - $goalsAgainst);
			}

			return [
				'won' => $team->wonnedMatchCount,
				'lose' => $team->losedMatchCount,
				'drawn' => $team->drawnMatchCount,
				'played' => $team->playedMatchCount,
				'goals_for' => $goalsFor,
				'goals_against' => $goalsAgainst,
				'goals_diff' => $goalsDifference,
				'pts' => $team->pts
			];
		}

		/**
		 * @return mixed
		 */
		public function teams()
		{
			$teams = $this->teamRepository->get();
			foreach ($teams as $team) {
				$stats = $this->getStats($team->id);
				$team['stats'] = $stats;
			}
			return $teams;
		}

		/**
		 * @param $team_id
		 * @return mixed
		 */
		public function getPlayedMatches($team_id)
		{
			return $this->matchesRepository->where('host_team', $team_id)->orWhere('away_team', $team_id)->count();
		}


		/**
		 * @param $weekTime
		 * @return bool[]
		 */
		public function organizeMatches($weekTime)
		{
			if ($this->resetMatches()) {
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
							'host_team' => $host,
							'away_team' => $away,
							'week' => $week,
							'host_goal' => $faker->numberBetween(0, 4),
							'away_goal' => $faker->numberBetween(0, 4),
						]);
					}
				}
				return ['success' => true];
			}
		}

		/**
		 * @return bool|\Exception
		 */
		public function resetMatches()
		{
			try {
				$this->matchesRepository->truncate();
				return true;
			} catch (\Exception $e) {
				return $e;
			}
		}

		/**
		 * @return mixed
		 */
		public function getFixtures()
		{
			return $this->matchesRepository->with(['host_team', 'away_team'])->get()->groupBy('week');
		}
	}
