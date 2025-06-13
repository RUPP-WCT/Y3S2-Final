<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class AccountStatuses extends Model
{
    protected $table = 'account_statuses';
    protected $primaryKey = 'account_status_id';
    public $timestamps = false;
    protected $fillable = [
        'account_status'
    ];
}
