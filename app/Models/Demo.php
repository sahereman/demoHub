<?php

namespace App\Models;

use App\Admin\Models\Administrator;
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

    const DEMO_SCENARIO_PC = 'PC';
    const DEMO_SCENARIO_MOBILE = 'Mobile';

    public static $demoScenarioMap = [
        self::DEMO_SCENARIO_PC => 'PC 端',
        self::DEMO_SCENARIO_MOBILE => '移动端',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scenario',
        'name',
        'slug',
        'description',
        'memo',
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
    public function designers()
    {
        return $this->belongsToMany(Administrator::class, 'demo_designers', 'demo_id', 'admin_user_id', 'id', 'id', 'designers');
    }
}
