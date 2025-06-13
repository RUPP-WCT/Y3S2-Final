<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class AccountRoles extends Model
{
    protected $table = 'account_roles';
    protected $primaryKey = 'account_role_id';
    public $timestamps = false;
    protected $fillable = [
        'account_role'
    ];
}
