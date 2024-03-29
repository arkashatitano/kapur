<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Publication extends Model
{
    protected $table = 'publication';
    protected $primaryKey = 'publication_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
