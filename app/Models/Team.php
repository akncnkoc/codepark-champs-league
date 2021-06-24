<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;

	class Team extends Model
	{
		use HasFactory;

		protected $guarded = [];
		public $wonnedMatchCount;
		public $losedMatchCount;
		public $drawnMatchCount;
		public $pts;
		public $playedMatchCount;

		public function weekly_matches()
		{
			return $this->hasMany(WeeklyMatch::class, ['host', 'away']);
		}
	}
