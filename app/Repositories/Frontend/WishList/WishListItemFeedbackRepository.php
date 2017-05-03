<?php

namespace App\Repositories\Frontend\WishList;

use App\Models\WishList\WishList;
use App\Models\WishList\WishListItemFeedback;
use App\Repositories\BaseRepository;

/**
 * TODO: Not implemented yet.
 * Class WishListItemFeedbackRepository
 * @package App\Repositories\Frontend\WishList
 */
class WishListItemFeedbackRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = WishListItemFeedback::class;

    /**
     * @param array $data
     * @param bool $provider
     *
     * @return static
     */
    public function create(array $data, $provider = false)
    {
        $wishListItemFeedback = self::MODEL;
        $wishListItemFeedback = new $wishListItemFeedback();
        $wishListItemFeedback->user_id = $data['user_id'];
        $wishListItemFeedback->wishlist_id = $data['wishlist_id'];
        $wishListItemFeedback->appliance_id = $data['appliance_id'];
        $wishListItemFeedback->disliked = $data['disliked'];

        $wishListItemFeedback->save();

        return $wishListItemFeedback;
    }
}