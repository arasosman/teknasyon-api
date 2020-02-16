<?php


namespace App\Repositories\Contracts;


use App\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryContract
{
    /**
     * Idsi verilen elemanı döner.
     * @param $entityId
     * @return  $model
     * @internal param array|int $id
     */
    public function find($entityId);

    /**
     * Idsi verilen elemanı istenilen ilişkileri ile döner.
     * @param int $entityId
     * @param array $with
     * @return  $model
     * @internal param array|int $id
     */
    public function findWith(int $entityId, array $with);

    /**
     * parametre numeric ise idye bakar değilse slug kriterine uyan tek kaydı döner
     *
     * @param int|string $idOrSlug
     * @return null|Model
     */
    public function findByIdOrSlug($idOrSlug);

    /**
     * @param  $attributes
     * @return static
     */
    public function firstOrCreate($attributes);

    /**
     * Kaynağın tüm elemanlarını döner
     * @return mixed
     */
    public function all();

    /**
     * Sayfalanmış koleksiyon döner.
     * @param array $params
     * @return mixed
     */
    public function paginate($params = []);

    /**
     * Yeni kayıt oluşturur.
     * @param  $data
     * @return mixed
     */
    public function create($data);

    /**
     * Create or update resource
     *
     * @param  $attributes
     * @param  $values
     * @return mixed
     */
    public function updateOrCreate($attributes, $values = []);

    /**
     * Kaydı günceller.
     * @param  $model
     * @param array $data
     * @return mixed
     */
    public function update($model, $data);

    /**
     * Kaydı kaldırır.
     * @param $model
     * @return mixed
     */
    public function destroy($model);

    /**
     * Slug (kısa ismi) verilen bir kaydı bulur.
     * @param int $slug
     * @return object
     */
    public function findBySlug($slug);

    /**
     * Özellikleri verilen bir kaydı bulur.
     * @param array $attributes
     * @return object
     */
    public function findByAttributes(array $attributes);

    /**
     * Özellikleri verilen bir çok kaydı bulur.
     * @param array $attributes
     * @return object
     */
    public function findManyByAttributes(array $attributes);

    /**
     * @return mixed
     */
    public function getModel();

    /**
     * @param $model
     * @param null $servicePrefix
     * @return $this
     */
    public function setModel($model);
}
