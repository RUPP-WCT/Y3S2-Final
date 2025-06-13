<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Genders extends Model
{
    protected $table = 'genders';
    protected $primaryKey = 'gender_id';
    public $timestamps = false;
    protected $fillable = [
        'gender'
    ];
}
