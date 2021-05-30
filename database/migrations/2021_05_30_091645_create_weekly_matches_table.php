<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	class CreateWeeklyMatchesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('weekly_matches', function (Blueprint $table) {
				$table->id();
				$table->integer('week');
				$table->foreignId('host_team');
				$table->foreignId('away_team');
				$table->integer('host_goal');
				$table->integer('away_goal');
				$table->timestamps();
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('weekly_matches');
		}
	}
