<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

// class Designer extends Model
// class Designer extends Authenticatable
class Designer extends User
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'email_verified_at',
        'gender',
        'qq',
        'wechat',
        'phone',
        'password',
        'remember_token',
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        // 'email_verified_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar_url',
    ];

    /* Accessors */
    public function getAvatarUrlAttribute()
    {
        if ($this->attributes['avatar']) {
            // 如果 image 字段本身就已经是完整的 url 就直接返回
            /*if (Str::startsWith($this->attributes['avatar'], ['http://', 'https://'])) {
                return $this->attributes['avatar'];
            }
            return \Storage::disk('public')->url($this->attributes['avatar']);*/
            return generate_image_url($this->attributes['avatar'], 'public');
        }
        return '';
    }

    /* Mutators */
    public function setAvatarUrlAttribute($value)
    {
        unset($this->attributes['avatar_url']);
    }

    /* Eloquent Relationships */
    public function demos()
    {
        return $this->hasMany(Demo::class);
    }
}
