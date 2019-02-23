<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Question extends Model
{
    protected $table = 'question';
    protected $primaryKey = 'question_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
