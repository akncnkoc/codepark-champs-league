<?php

	namespace App\Providers;

	use App\Repostories\Teams\TeamsRepository;
	use App\Repostories\Teams\TeamsRepositoryInterface;

	use App\Repostories\WeeklyMatches\WeeklyMatchesRepository;
	use App\Repostories\WeeklyMatches\WeeklyMatchesRepositoryInterface;
	use Illuminate\Support\ServiceProvider;

	class AppServiceProvider extends ServiceProvider
	{
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			$this->app->bind(TeamsRepositoryInterface::class, TeamsRepository::class);
			$this->app->bind(WeeklyMatchesRepositoryInterface::class, WeeklyMatchesRepository::class);
		}

		/**
		 * Bootstrap any application services.
		 *
		 * @return void
		 */
		public function boot()
		{
			//
		}
	}
