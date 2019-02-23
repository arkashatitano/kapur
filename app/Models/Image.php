<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Image extends Model
{
    protected $table = 'image';
    protected $primaryKey = 'image_id';

  /*  use SoftDeletes;
    protected $dates = ['deleted_at'];
    */
}
