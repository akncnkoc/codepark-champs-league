<?php


	namespace App\Repostories\WeeklyMatches;


	use Illuminate\Support\Collection;

	interface WeeklyMatchesRepositoryInterface
	{
		/**
		 * @return mixed
		 */
		public function get();

		/**
		 * @param int $id
		 * @return mixed
		 */
		public function find(int $id);

		/**
		 * @return Collection
		 */
		public function all(): Collection;

		/**
		 * @param $find
		 * @param $value
		 * @return mixed
		 */
		public function where($find, $value);

		/**
		 *
		 */
		public function truncate(): void;
	}
