<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Gallery extends Model
{
    protected $table = 'gallery';
    protected $primaryKey = 'gallery_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
