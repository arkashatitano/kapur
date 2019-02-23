<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Seminar extends Model
{
    protected $table = 'seminar';
    protected $primaryKey = 'seminar_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
