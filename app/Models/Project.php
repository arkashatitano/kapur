<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Project extends Model
{
    protected $table = 'project';
    protected $primaryKey = 'project_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
