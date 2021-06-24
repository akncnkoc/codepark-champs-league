<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;

	class WeeklyMatch extends Model
	{
		use HasFactory;

		protected $guarded = [];

		public function host_team()
		{
			return $this->belongsTo(Team::class, 'host_team');
		}

		public function away_team()
		{
			return $this->belongsTo(Team::class, 'away_team');
		}

		public function host_team_goal()
		{
			return $this->host_goal;
		}

		public function away_team_goal()
		{
			return $this->away_goal;
		}
	}
