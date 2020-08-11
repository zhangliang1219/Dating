<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfoPrivacy extends Authenticatable
{
    use SoftDeletes;    
    use Sortable;
    protected $table = 'user_info_privacy';
}
