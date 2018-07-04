<?php

namespace App\Models;

use App\Models\Inbound\Folder;
use App\Models\Inbound\InboundEmail;
use App\Models\Outbound\OutboundEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function inboundEmails()
    {
        return $this->hasMany(InboundEmail::class);
    }

    public function outboundEmails()
    {
        return $this->hasMany(OutboundEmail::class);
    }
}
