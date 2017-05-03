<?php

namespace App\Repositories\Frontend\Appliance;

use App\Models\Appliance\Appliance;
use App\Repositories\BaseRepository;

class ApplianceRepository extends BaseRepository
{
    const MODEL = Appliance::class;

    /**
     * @param array $data
     * @param bool $provider
     *
     * @return static
     */
    public function create(array $data, $provider = false)
    {
        $appliance = Appliance::create($data);
        $appliance->save();
        return $appliance;
    }

    /**
     * @param $category
     * @return mixed
     */
    public function findByCategory($category)
    {
        return $this->query()->where('category', $category)->get();
    }

    /**
     * @param $category
     * @param int $limit
     * @return mixed
     */
    public function findByCategoryPaginate($category, $limit = 10)
    {
        return $this->query()->where('category', $category)->paginate($limit);
    }

    /**
     * @param array $ids
     * @param int $limit
     * @return mixed
     */
    public function findWhereIdIn(array $ids, $limit = -1)
    {
        if ($limit == -1) {
            return $this->query()->whereIn('id', $ids)->get();
        } else {
            return $this->query()->whereIn('id', $ids)->paginate($limit);
        }
    }
}
