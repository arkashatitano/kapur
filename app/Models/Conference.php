<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Conference extends Model
{
    protected $table = 'conference';
    protected $primaryKey = 'conference_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
