<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Services\WishList\WishlistService;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    /**
     * @var WishlistService
     */
    private $wishlistService;

    /**
     * WishListController constructor.
     * @param WishlistService $wishlistService
     */
    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    /**
     * @param int $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($userId)
    {
        $wishlist = $this->wishlistService->getUserWishlist($userId);

        return view('frontend.wishlist.list', [
            'wishlist' => $wishlist,
            'wishlistOwner' => $wishlist->user,
            'appliances' => $wishlist->getAppliances(),
        ]);
    }

    /**
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addAppliance(Request $request, $userId)
    {
        if ($userId != access()->id()) {
            abort(403, 'You can only add appliances to your own wishlist');
        }

        $applianceId = $request->input('applianceId');

        $this->wishlistService->addApplianceToUserWishlist($userId, $applianceId);

        return redirect()->route('frontend.wishlist', ['userId' => $userId]);
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeAppliance(Request $request, $userId)
    {
        if ($userId != access()->id()) {
            abort(403, 'You can only add appliances to your own wishlist');
        }

        $applianceId = $request->input('applianceId');

        $this->wishlistService->removeApplianceFromUserWishlist($userId, $applianceId);

        return redirect()->route('frontend.wishlist', ['userId' => $userId]);
    }
}