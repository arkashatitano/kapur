<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Video extends Model
{
    protected $table = 'video';
    protected $primaryKey = 'video_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
