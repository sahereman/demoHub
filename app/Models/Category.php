<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
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
        'demo_id',
        'name',
        'slug',
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
        //
    ];

    /* Accessors */
    //

    /* Mutators */
    public function setSlugAttribute($value)
    {
        $position = strpos($value, '-S-');
        if ($position === false) {
            $this->attributes['slug'] = $value . '-S-' . Str::random();
        } else {
            $this->attributes['slug'] = $value;
            // $this->attributes['slug'] = substr($value, 0, $position) . '-S-' . Str::random();
        }
    }

    /* Eloquent Relationships */
    public function demo()
    {
        return $this->belongsTo(Demo::class);
    }

    public function drafts()
    {
        return $this->hasMany(Draft::class);
    }
}
