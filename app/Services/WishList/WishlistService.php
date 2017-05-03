<?php

namespace App\Services\WishList;

use App\Exceptions\RemoveApplianceFromNotExistingWishlistException;
use App\Repositories\Frontend\WishList\WishListRepository;

class WishlistService
{
    /**
     * @var WishListRepository
     */
    private $wishListRepository;

    /**
     * WishlistService constructor.
     * @param WishListRepository $wishListRepository
     */
    public function __construct(WishListRepository $wishListRepository)
    {
        $this->wishListRepository = $wishListRepository;
    }

    /**
     * @param $userId
     * @return \App\Models\WishList\WishList
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