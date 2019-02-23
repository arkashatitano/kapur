<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Member extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'member_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
