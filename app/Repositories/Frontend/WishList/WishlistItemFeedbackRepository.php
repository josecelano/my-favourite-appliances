<?php

namespace App\Repositories\Frontend\Wishlist;

use App\Models\Wishlist\Wishlist;
use App\Models\Wishlist\WishlistItemFeedback;
use App\Repositories\BaseRepository;

/**
 * TODO: Not implemented yet.
 * Class WishlistItemFeedbackRepository
 * @package App\Repositories\Frontend\Wishlist
 */
class WishlistItemFeedbackRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = WishlistItemFeedback::class;

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