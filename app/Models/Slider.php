<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Slider extends Model
{
    protected $table = 'slider';
    protected $primaryKey = 'slider_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
