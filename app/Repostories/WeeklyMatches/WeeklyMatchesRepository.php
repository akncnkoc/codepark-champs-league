<?php


	namespace App\Repostories\WeeklyMatches;


	use App\Models\Team;
	use App\Models\WeeklyMatch;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Collection;

	class WeeklyMatchesRepository implements WeeklyMatchesRepositoryInterface
	{

		/**
		 * @var WeeklyMatch
		 */
		protected $model;

		/**
		 * WeeklyMatchesRepository constructor.
		 * @param WeeklyMatch $model
		 */
		public function __construct(WeeklyMatch $model)
		{
			$this->model = $model;
		}

		/**
		 * @return mixed
		 */
		public function get()
		{
			return $this->model->get();
		}

		/**
		 * @param int $id
		 * @return mixed
		 */
		public function find(int $id)
		{
			return $this->model->find($id);
		}


		/**
		 * @return Collection
		 */
		public function all(): Collection
		{
			 return $this->model->all();
		}

		/**
		 * void
		 */
		public function truncate(): void
		{
			$this->model->truncate();
		}


		/**
		 * @param $find
		 * @param $value
		 * @return mixed
		 */
		public function where($find, $value)
		{
			return $this->model->where($find,$value);
		}
	}
