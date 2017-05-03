<?php

namespace App\Services\Wishlist;

use App\Exceptions\RemoveApplianceFromNotExistingWishlistException;
use App\Repositories\Frontend\Wishlist\WishlistRepository;

class WishlistService
{
    /**
     * @var WishlistRepository
     */
    private $wishListRepository;

    /**
     * WishlistService constructor.
     * @param WishlistRepository $wishListRepository
     */
    public function __construct(WishlistRepository $wishListRepository)
    {
        $this->wishListRepository = $wishListRepository;
    }

    /**
     * @param $userId
     * @return \App\Models\Wishlist\Wishlist
     */
    public function getUserWishlist($userId)
    {
        return $this->wishListRepository->findByUserId($userId);
    }

    /**
     * @param $userId
     * @param $applianceId
     */
    public function addApplianceToUserWishlist($userId, $applianceId)
    {
        $wishlist = $this->wishListRepository->findOrCreateByUserId($userId);
        $wishlist->addAppliance($applianceId);
        $wishlist->save();
    }

    /**
     * @param $userId
     * @param $applianceId
     */
    public function removeApplianceFromUserWishlist($userId, $applianceId)
    {
        $wishlist = $this->wishListRepository->findOrCreateByUserId($userId);

        if (!$wishlist) {
            throw new RemoveApplianceFromNotExistingWishlistException($userId);
        }

        $wishlist->removeAppliance($applianceId);
        $wishlist->save();
    }
}