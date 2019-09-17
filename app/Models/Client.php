<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
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
        'gender',
        'qq',
        'wechat',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        //
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
