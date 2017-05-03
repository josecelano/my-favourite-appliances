<?php

namespace App\Repositories\Frontend\Wishlist;

use App\Models\Wishlist\Wishlist;
use App\Repositories\BaseRepository;
use App\Repositories\Frontend\Appliance\ApplianceRepository;

class WishlistRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Wishlist::class;

    /**
     * @var ApplianceRepository
     */
    private $applianceRepository;

    /**
     * WishlistRepository constructor.
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
     * @return Wishlist
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
     * @return Wishlist
     */
    public function findByUserId($userId, $appliancesLimit = 20)
    {
        /** @var Wishlist $wishlist */
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
     * @return Wishlist
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