<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Magazine extends Model
{
    protected $table = 'magazine';
    protected $primaryKey = 'magazine_id';

    /*use SoftDeletes;
    protected $dates = ['deleted_at'];*/
}
