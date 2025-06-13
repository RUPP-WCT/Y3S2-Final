<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class AccountStatusNotes extends Model
{
    protected $table = 'account_status_notes';
    protected $primaryKey = 'user_id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'account_status_note',
    ];
}
