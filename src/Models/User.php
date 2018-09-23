<?php

namespace TCG\Voyager\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TCG\Voyager\Contracts\User as UserContract;
use TCG\Voyager\Traits\HasRelationships;
use TCG\Voyager\Traits\VoyagerUser;

class User extends Authenticatable implements UserContract
{
    use VoyagerUser,
        HasRelationships;

    protected $guarded = [];

    protected $casts = [
        'settings' => 'array',
    ];

    public function getAvatarAttribute($value)
    {
        if (is_null($value)) {
            return '';
        }

        return $value;
    }

    public function isAvatarDeletable() 
    {
        if(!is_null($this->attributes['avatar']) && !empty($this->attributes['avatar'])) {
            return true;
        }

        return false;
    }

    public function getAvatar() 
    {
        $avatar = config('voyager.user.default_avatar', 'users/default.png');

        if (!is_null($this->attributes['avatar']) && !empty($this->attributes['avatar'])) {
            $avatar = $this->attributes['avatar'];
        }

        if (starts_with($avatar, 'http://') || starts_with($avatar, 'https://') || starts_with($avatar, '//')) {
            return $avatar;
        }

        return Voyager::image($avatar);
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setLocaleAttribute($value)
    {
        $this->attributes['settings'] = collect($this->settings)->merge(['locale' => $value]);
    }

    public function getLocaleAttribute()
    {
        return $this->settings['locale'];
    }
}
