<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Exposition extends Model
{
    protected $table = 'exposition';
    protected $primaryKey = 'exposition_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
