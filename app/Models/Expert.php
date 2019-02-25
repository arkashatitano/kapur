<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Expert extends Model
{
    protected $table = 'expert';
    protected $primaryKey = 'expert_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
