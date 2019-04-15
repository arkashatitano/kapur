<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class File extends Model
{
    protected $table = 'file';
    protected $primaryKey = 'file_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
