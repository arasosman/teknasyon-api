<?php


namespace App\Repositories;


use App\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryContract
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model = null)
    {
        if ($model) {
            $this->model = $model;
        }
    }

    public function find($entityId)
    {
        return $this->model->find($entityId);
    }

    /**
     * @inheritdoc
     * @param  $idOrSlug
     * @return null|Model|mixed
     */
    public function findByIdOrSlug($idOrSlug)
    {
        if (empty($idOrSlug)) {
            return null;
        }

        if (is_numeric($idOrSlug)) {
            return $this->find((int)$idOrSlug);
        }

        return $this->findBySlug($idOrSlug);
    }

    public function firstOrCreate($attributes)
    {
        return $this->model->firstOrCreate($attributes);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function paginate($params = [])
    {
        return $this->model->paginate($params);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function updateOrCreate($attributes, $values = [])
    {
        $this->model->updateOrCreate($attributes, $values);
    }

    public function update($model, $data)
    {
        $model->fill($data)->save();
        return $model;
    }

    public function destroy($model)
    {
        // TODO: Implement destroy() method.
    }

    public function findBySlug($slug)
    {
        return $this->model->where(['slug' => $slug])->first();
    }

    public function findByAttributes(array $attributes)
    {
        return $this->model->where($attributes)->first();
    }

    public function findManyByAttributes(array $attributes)
    {
        return $this->model->where($attributes)->get();
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $model
     * @return BaseRepository
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }
}
