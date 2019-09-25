<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Draft extends Model
{
    /*use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }*/

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'thumb',
        'photo',
        'sort',
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
        'thumb_url',
        'photo_url',
    ];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 slug 字段为空
            if (!$model->slug) {
                // 调用 generateSlug 生成 Slug
                $model->slug = static::generateSlug();
                // 如果生成失败，则终止创建订单
                if (!$model->slug) {
                    return false;
                }
            }
        });
    }

    //  生成 Slug
    public static function generateSlug()
    {
        // Slug前缀
        // $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
            // $slug = $prefix . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $slug = 'Dr' . Str::random();
            // 判断是否已经存在
            if (!static::query()->where('slug', $slug)->exists()) {
                return $slug;
            }
        }
        Log::error('generating draft slug failed');
        return false;
    }

    /* Accessors */
    public function getThumbUrlAttribute()
    {
        if ($this->attributes['thumb']) {
            // 如果 thumb 字段本身就已经是完整的 url 就直接返回
            /*if (Str::startsWith($this->attributes['thumb'], ['http://', 'https://'])) {
                return $this->attributes['thumb'];
            }
            return Storage::disk('public')->url($this->attributes['thumb']);*/
            return generate_image_url($this->attributes['thumb'], 'public');
        }
        return '';
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->attributes['photo']) {
            // 如果 photo 字段本身就已经是完整的 url 就直接返回
            /*if (Str::startsWith($this->attributes['photo'], ['http://', 'https://'])) {
                return $this->attributes['photo'];
            }
            return Storage::disk('public')->url($this->attributes['photo']);*/
            return generate_image_url($this->attributes['photo'], 'public');
        }
        return '';
    }

    /* Mutators */
    public function setThumbUrlAttribute($value)
    {
        unset($this->attributes['thumb_url']);
    }

    public function setPhotoUrlAttribute($value)
    {
        unset($this->attributes['photo_url']);
    }

    /* Eloquent Relationships */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
