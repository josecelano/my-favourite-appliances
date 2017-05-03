<?php

namespace App\Repositories\Frontend\WishList;

use App\Models\WishList\WishList;
use App\Repositories\BaseRepository;
use App\Repositories\Frontend\Appliance\ApplianceRepository;

class WishListRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = WishList::class;

    /**
     * @var ApplianceRepository
     */
    private $applianceRepository;

    /**
     * WishListRepository constructor.
     * @param ApplianceRepository $applianceRepository
     */
    public function __construct(ApplianceRepository $applianceRepository)
    {
        $this->applianceRepository = $applianceRepository;
    }

    /**
     * @param array $data
     * @param bool $provider
     *
     * @return WishList
     */
    public function create(array $data, $provider = false)
    {
        $wishList = self::MODEL;
        $wishList = new $wishList();
        $wishList->user_id = $data['user_id'];
        $wishList->appliance_ids = $data['appliance_ids'];

        /** @noinspection PhpUndefinedMethodInspection */
        $wishList->save();

        return $wishList;
    }

    /**
     * @param $userId
     * @param int $appliancesLimit
     * @return WishList
     */
    public function findByUserId($userId, $appliancesLimit = 20)
    {
        /** @var WishList $wishlist */
        $wishlist = $this->query()->where('user_id', $userId)->first();

        /** @var ApplianceRepository $applianceRepository */
        $applianceRepository = $this->applianceRepository;

        $appliancesReference = function ($applianceIds) use ($applianceRepository, $appliancesLimit) {
            return $applianceRepository->findWhereIdIn($applianceIds, $appliancesLimit);
        };

        $wishlist->setAppliancesReference($appliancesReference);

        return $wishlist;
    }

    /**
     * @param int $userId
     * @return WishList
     */
    public function findOrCreateByUserId($userId)
    {
        $wishlist = $this->findByUserId($userId);

        if (!$wishlist) {
            $wishlist = $this->create([
                'user_id' => $userId,
                'appliance_ids' => [],
            ]);
        }

        return $wishlist;
    }
}