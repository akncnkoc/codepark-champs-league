<?php


	namespace App\Repostories\Teams;


	use Illuminate\Support\Collection;

	interface TeamsRepositoryInterface
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
		 * @param $find
		 * @param $value
		 * @return mixed
		 */
		public function where($find, $value);

		/**
		 * @return Collection
		 */
		public function all(): Collection;
	}
