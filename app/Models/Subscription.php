<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Subscription extends Model
{
    protected $table = 'subscription';
    protected $primaryKey = 'subscription_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
