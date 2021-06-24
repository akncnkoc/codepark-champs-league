<?php


	namespace App\Repostories\Teams;


	use App\Models\Team;
	use Illuminate\Support\Collection;

	class TeamsRepository implements TeamsRepositoryInterface
	{

		/**
		 * @var Team
		 */
		protected $model;


		/**
		 * TeamsRepository constructor.
		 * @param Team $model
		 */
		public function __construct(Team $model)
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
		 * @param $find
		 * @param $value
		 * @return mixed
		 */
		public function where($find, $value)
		{
			return $this->model->where($find, $value);
		}
	}
