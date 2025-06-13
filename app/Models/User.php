<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Users\AccountRoles;
use App\Models\Users\AccountStatuses;
use App\Models\Users\AccountStatusNotes;
use App\Models\Users\Genders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'dob',
        'gender_id',
        'current_address',
        'avatar',
        'account_status_id',
        'account_role_id',
    ];


    public function gender () {
        return $this->belongsTo(Genders::class, 'gender_id', 'gender_id');
    }

    public function accountStatus () {
        return $this->belongsTo(AccountStatuses::class, 'account_status_id', 'account_status_id');
    }
    public function accountRole () {
        return $this->belongsTo(AccountRoles::class, 'account_role_id', 'account_role_id');
    }

    public function accountStatusNotes () {
        return $this->hasOne(AccountStatusNotes::class, 'user_id', 'user_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
