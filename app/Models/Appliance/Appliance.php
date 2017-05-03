<?php

namespace App\Models\Appliance;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string external_id
 * @property string title
 * @property string description
 * @property string image
 * @property string category
 * @property int price_amount
 * @property string price_currency
 */
class Appliance extends Model
{
    /** @var string */
    protected $table = 'appliances';

    /** @var array */
    protected $fillable = [
        'external_id',
        'title',
        'description',
        'image',
        'category',
        'price_amount',
        'price_currency'
    ];
}
