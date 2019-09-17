<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Demo extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'designer_id',
        'client_id',
        'name',
        'slug',
        'description',
        'content',
        'thumb',
        'photos',
        'is_index',
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
        'photos' => 'json',
        'is_index' => 'boolean',
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
        'thumb_url',
        'photo_urls',
    ];

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

    public function getPhotoUrlsAttribute()
    {
        $photo_urls = [];
        if ($this->attributes['photos']) {
            $photos = json_decode($this->attributes['photos'], true);
            if (count($photos) > 0) {
                foreach ($photos as $photo) {
                    /*if (Str::startsWith($photo, ['http://', 'https://'])) {
                        $photo_urls[] = $photo;
                    }
                    $photo_urls[] = Storage::disk('public')->url($photo);*/
                    $photo_urls[] = generate_image_url($photo, 'public');
                }
            }
        }
        return $photo_urls;
    }

    public function getDesignerNameAttribute()
    {
        return $this->designer->name;
    }

    public function getClientNameAttribute()
    {
        return $this->client->name;
    }

    /* Mutators */
    public function setThumbUrlAttribute($value)
    {
        unset($this->attributes['thumb_url']);
    }

    public function setPhotoUrlsAttribute($value)
    {
        unset($this->attributes['photo_urls']);
    }

    public function setDesignerNameAttribute($value)
    {
        unset($this->attributes['designer_name']);
    }

    public function setClientNameAttribute($value)
    {
        unset($this->attributes['client_name']);
    }

    /* Eloquent Relationships */
    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
