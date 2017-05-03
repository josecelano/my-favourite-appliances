<?php

namespace App\Models\Wishlist;

use App\Models\Access\User\User;
use App\Models\Appliance\Appliance;
use Closure;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wishlist
 * @property int user_id
 * @property integer[] appliance_ids
 * @property User user
 * @package App\Models\Wishlist
 */
class Wishlist extends Model
{
    /** @var string */
    protected $table = 'wishlists';

    /** @var array */
    protected $fillable = [
        'user_id',
        'appliance_ids,
    '];

    /** @var array */
    protected $casts = [
        'appliance_ids' => 'array',
    ];

    /** @var  Closure */
    private $appliancesReference;

    /** @var  Appliance[] */
    private $appliances;

    /**
     * Get the user that owns the wishlist.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User');
    }

    /**
     * @param int $applianceId
     */
    public function addAppliance($applianceId)
    {
        $this->appliance_ids = array_unique(array_merge($this->appliance_ids, [(int)$applianceId]));
    }

    /**
     * @param int $applianceId
     */
    public function removeAppliance($applianceId)
    {
        $this->appliance_ids = array_unique(array_diff($this->appliance_ids, [(int)$applianceId]));
    }

    /**
     * @param Closure $appliancesReference
     */
    public function setAppliancesReference(Closure $appliancesReference)
    {
        $this->appliancesReference = $appliancesReference;
    }

    /**
     * @return Appliance[]
     */
    public function getAppliances()
    {
        // TODO: Code Review: This is a test for this approach:
        // http://verraes.net/2011/05/lazy-loading-with-closures/
        // but it can be refactored to use a Eloquent many to many relationship.
        if (!isset($this->appliances)) {
            $reference = $this->appliancesReference;
            $this->appliances = $reference($this->appliance_ids);
        }
        return $this->appliances;
    }
}