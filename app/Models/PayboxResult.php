<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PayboxResult extends Model
{
    protected $table = 'paybox_result';
    protected $primaryKey = 'paybox_result_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
