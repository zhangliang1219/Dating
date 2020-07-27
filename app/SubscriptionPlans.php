<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model; 

class SubscriptionPlans extends Model
{
    use SoftDeletes;    
    use Sortable;
    protected $table = 'subscription_plans';
    public function subscriptionPrice()
    {
        return $this->hasMany('App\SubscriptionPrices','subscription_id');
    }
    
    public function subscriptionFeatureQty()
    {
        return $this->hasMany('App\SubscriptionFeaturesQuantity','subscription_id');
    }
}
